<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        //
        $authenticate = false;
        $personalInfo = null;

        if (Auth::check()) {
            $authenticate = true;
            $personalInfo = Persona::where('usuario_id', Auth::user()->id)->select('id', 'nombres', 'apepaterno', 'apematerno')->get();
        }
        $sede = Sede::where('estado', 'A')->select('id', 'descripcion', 'abreviatura', 'estado')->get();
        $lugares = null;

        return view('pages.public.reservation.index', compact('sede', 'lugares', 'personalInfo', 'authenticate'));
    }

    public function generateFormToken(Request $request, $codigo)
    {
        $datosReserva = $request->all();

        $authenticate = false;
        $personalInfo = null;

        if (Auth::check()) {
            $authenticate = true;
            $personalInfo = Persona::where('usuario_id', Auth::user()->id)->select('id', 'nombres', 'apepaterno', 'apematerno')->get();
        }

        $auth = base64_encode(config("services.izipay.client_id") . ":" . config("services.izipay.client_secret"));

        $response = Http::withHeaders([
            "Authorization" => "Basic $auth",
            "Content-Type" => "application/json"
        ])->post(config('services.izipay.url'), [
            'amount' => "{$request->precio}00",
            'currency' => 'USD',
            'orderId' => "Reserva de cancha",
            'customer' => [
                'email' => Auth::user()->email
            ]
        ])->json();

        $formToken = $response['answer']['formToken'];

        DB::select("INSERT INTO reserva_temporal
        (personaid, inicio, fin, perciomodal, sede, lugar, codigo)
        VALUES(?,?,?,?,?,?,?)", [Auth::user()->id, $request->inicio, $request->fin, $request->precio, $request->sede, $request->lugarModal, $codigo]);

        return view('pages.public.reservation.detalle-reserva', compact('formToken', 'personalInfo', 'authenticate', 'datosReserva'));
    }

    public function izipay(Request $request)
    {
        if ($request->get('kr-hash-algorithm') !== 'sha256_hmac') {
            throw new \Exception('Invalid hash algoritm');
        }

        $krAnswer = Str::replace('\/', '/', $request->get('kr-answer'));
        $calculateHash = hash_hmac('sha256', $krAnswer, config('services.izipay.hash_key'));

        if ($calculateHash !== $request->get('kr-hash')) {
            throw new \Exception('Invalid hash');
        }

        $codigo = $request->get('kr-hash');

        $lastRegister = DB::select("SELECT * FROM reserva_temporal rt ORDER BY id DESC LIMIT 1;");
        DB::select("UPDATE reserva_temporal SET codigo = ? WHERE id = ?;", [$codigo, $lastRegister[0]->id]);

        if ($this->store($codigo)) {
            return redirect()->route('prfole.user')->with(['msg' => 'Tu reserva fue generada satisfactoriamente!']);
        } else {
            return back()->with(['msg' => 'Hubo un problema al realizar tu reserva!']);
        }
    }

    public function store($codigo)
    {
        try {
            $reservaTemporal = DB::select("SELECT * FROM reserva_temporal WHERE codigo = ?", [$codigo]);

            $sede = Sede::where('descripcion', '=', $reservaTemporal[0]->sede)->get();
            $lugar = Lugar::where('descripcion', '=', $reservaTemporal[0]->lugar)->get();

            $usc = Persona::where("usuario_id", Auth::user()->id)->select('nombres', 'apepaterno', 'apematerno')->get();

            $usuario_creador = $usc[0]->nombres . ' ' . $usc[0]->apepaterno . ' ' . $usc[0]->apematerno;

            $datos_reserva = [
                "inicio" => $reservaTemporal[0]->inicio,
                "fin" => $reservaTemporal[0]->fin,
                "persona_id" => $reservaTemporal[0]->personaid,
                "tipo_servicio_id" => 1,
                "sede" => $sede[0]->id,
                "lugar" => $lugar[0]->id,
                "capacidad" => 1,
                "usuario_creador" => $usuario_creador,
                "ip_usuario" => request()->ip(),
                "created_at" => Carbon::now()->toDateTimeString(),
                "periodicidad_id" => 1,
                "conluz" => "SI"
            ];

            DB::select(
                "SELECT servicio_alquiler(?,?,?,?,?,?,?,?,?,?,?,?)",
                [
                    $datos_reserva["inicio"],
                    $datos_reserva["fin"],
                    $datos_reserva["persona_id"],
                    $datos_reserva["tipo_servicio_id"],
                    $datos_reserva["sede"],
                    $datos_reserva["lugar"],
                    $datos_reserva["capacidad"],
                    $datos_reserva["usuario_creador"],
                    $datos_reserva["ip_usuario"],
                    $datos_reserva["created_at"],
                    $datos_reserva["periodicidad_id"],
                    $datos_reserva["conluz"]
                ]
            );

            // return response()->json(['msg' => 'Tu reserva fue generada satisfactoriamente!'], 200);
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // public function store(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         "inicio" => ["required"],
    //         "fin" => ["required"],
    //         "persona_id" => ["required"],
    //         "sede" => ["required"],
    //         "lugar" => ["required"],
    //     ]);

    //     if ($validation->fails()) {
    //         return redirect()->back()->with('error', $validation->errors());
    //     }

    //     $usc = Persona::where("usuario_id", Auth::user()->id)->select('nombres', 'apepaterno', 'apematerno')->get();

    //     $usuario_creador = $usc[0]->nombres . ' ' . $usc[0]->apepaterno . ' ' . $usc[0]->apematerno;

    //     $datos_reserva = [
    //         "inicio" => $request->inicio,
    //         "fin" => $request->fin,
    //         "persona_id" => $request->persona_id,
    //         "tipo_servicio_id" => 1,
    //         "sede" => $request->sede,
    //         "lugar" => $request->lugar,
    //         "capacidad" => 1,
    //         "usuario_creador" => $usuario_creador,
    //         "ip_usuario" => $request->ip(),
    //         "created_at" => Carbon::now()->toDateTimeString(),
    //         "periodicidad_id" => 1,
    //         "conluz" => (string)$request->conluz
    //     ];

    //     DB::select(
    //         "SELECT servicio_alquiler(?,?,?,?,?,?,?,?,?,?,?,?)",
    //         [
    //             $datos_reserva["inicio"],
    //             $datos_reserva["fin"],
    //             $datos_reserva["persona_id"],
    //             $datos_reserva["tipo_servicio_id"],
    //             $datos_reserva["sede"],
    //             $datos_reserva["lugar"],
    //             $datos_reserva["capacidad"],
    //             $datos_reserva["usuario_creador"],
    //             $datos_reserva["ip_usuario"],
    //             $datos_reserva["created_at"],
    //             $datos_reserva["periodicidad_id"],
    //             $datos_reserva["conluz"]
    //         ]
    //     );

    //     return response()->json(['msg' => 'Tu reserva fue generada satisfactoriamente!'], 200);
    // }

    public function getPlaces($id)
    {
        $lugares = Lugar::where('estado', 'A')->where('sede_id', $id)->get();
        return response()->json($lugares);
    }

    public function dateQuery(Request $request)
    {
        $msg = "Este horario no se encuentra disponible, te sugerimos elegir otro.";

        $val_dispo = [
            "start" => $request->start,
            "end" => $request->end,
            "sede" => $request->sede,
            "lugar" => $request->lugar,
        ];

        $val_range_date = DB::select("select valida_disponibilidad(?,?,?,?)", [$val_dispo["start"], $val_dispo["end"], $val_dispo["sede"], $val_dispo["lugar"]]);
        $response = $val_range_date[0]->valida_disponibilidad;
        $split = Str::before($response, ',');
        $split_end = Str::after($split, '(');

        if ($split_end === "0") {
            return response()->json(["msg" => "disponible"]);
        } elseif ($split_end === "1") {
            return response()->json(["msg" => $msg]);
        }
    }

    public function show($sede, $lugar)
    {
        $reservations = DB::select("select s.id, s.tiposervicio_id, s.sede_id, s.lugar_id,
                                    s.capacidad, sr.inicio AS start, sr.fin AS end, s.estado
                                    from servicio_reservas sr
                                    left join servicio_plantillas sp on sr.servicioplantilla_id = sp.id
                                    left join servicios s on sp.servicio_id = s.id
                                    WHERE s.sede_id = ? AND s.lugar_id = ? AND sr.estado= 'CA'", [$sede, $lugar]);

        return response()->json($reservations);
    }
}
