<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function index()
    {
        //
        $authenticate = false;
        $personalInfo = null;

        if (Auth::check()) {
            $authenticate = true;
            $personalInfo = Persona::where('usuario_id', Auth::user()->id)->select('id', 'nombres', 'apepaterno', 'apematerno')->get();
        }
        $sede = Sede::where('estado', 'A')->select('id', 'descripcion', 'abreviatura', 'estado')->get();
        $lugares = Lugar::all();
        return view('pages.public.reservation.index', compact('sede', 'lugares', 'personalInfo', 'authenticate'));
    }

    public function getPlaces($id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
        return response()->json($lugares);
    }

    public function dateQuery(Request $request)
    {
        $fechasRecibidas = $request->all();

        $message = "Este horario no se encuentra disponible, te sugerimos seleccionar otro.";

        $start = $fechasRecibidas["start"]; // desde el calendario
        $end = $fechasRecibidas["end"]; //desde el calendario
        $sede = $fechasRecibidas["sede"]; //desde el calendario
        $lugar = $fechasRecibidas["lugar"]; //desde el calendario

        $fechasAlmacenadas = DB::select("SELECT s.inicio, s.fin, s.sede_id, s.lugar_id FROM servicios s");

        $fecstart = substr($start, 0, 10) . " " . substr($start, 11, 8); //formatear fecha recibida del calendario
        $fecend = substr($end, 0, 10) . " " . substr($end, 11, 8); //formatear fecha recibida del calendario
        $sedeId = (int)$sede;
        $lugarId = (int)$lugar;

        foreach ($fechasAlmacenadas as $key => $value) {
            $fechaStart = $fechasAlmacenadas[$key]->inicio; //fechas obtenidas de la BD
            $fechaEnd = $fechasAlmacenadas[$key]->fin; //fechas obtenidas de la BD
            $sede_id = $fechasAlmacenadas[$key]->sede_id;
            $lugar_id = $fechasAlmacenadas[$key]->lugar_id;

            //fechavista    //fechabd
            if (($fecstart <= $fechaStart && $fecend > $fechaStart) && ($sedeId == $sede_id && $lugarId ==  $lugar_id)) {

                return response()->json(["msg" => $message]);
            }
            if (($fecstart < $fechaEnd && $fecend > $fechaEnd) && ($sedeId == $sede_id && $lugarId ==  $lugar_id)) {
                dd("caso 2");
                return response()->json(["msg" => $message]);
            }

            // if ($fecstart >= $fechaStart && $fecend <= $fechaEnd) {
            //     dd();
            //     return response()->json(["msg" => $message]);
            // }
        }

        return response()->json(["msg" => "ok"]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "inicio" => ["required"],
            "fin" => ["required"],
            "persona_id" => ["required"],
            "sede" => ["required"],
            "lugar" => ["required"],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->with('error', $validation->errors());
        }

        $usc = Persona::where("usuario_id", Auth::user()->id)->select('nombres', 'apepaterno', 'apematerno')->get();

        $usuario_creador = $usc[0]->nombres . ' ' . $usc[0]->apepaterno . ' ' . $usc[0]->apematerno;

        $datosReserva = [
            "inicio" => $request->inicio,
            "fin" => $request->fin,
            "persona_id" => $request->persona_id,
            "tipo_servicio_id" => 1,
            "sede" => $request->sede,
            "lugar" => $request->lugar,
            "capacidad" => 1,
            "usuario_creador" => $usuario_creador,
            "ip_usuario" => $request->ip(),
            "created_at" => Carbon::now()->toDateTimeString(),
            "periodicidad_id" => 1
        ];

        DB::select(
            "SELECT servicio_alquiler(?,?,?,?,?,?,?,?,?,?,?)",
            [
                $datosReserva["inicio"],
                $datosReserva["fin"],
                $datosReserva["persona_id"],
                $datosReserva["tipo_servicio_id"],
                $datosReserva["sede"],
                $datosReserva["lugar"],
                $datosReserva["capacidad"],
                $datosReserva["usuario_creador"],
                $datosReserva["ip_usuario"],
                $datosReserva["created_at"],
                $datosReserva["periodicidad_id"]
            ]
        );

        return response()->json(['msg' => 'Tu reserva fue generada satisfactoriamente!'], 200);
    }


    public function show($sede, $lugar)
    {
        $reservations = DB::select('SELECT s.id, s.tiposervicio_id, s.sede_id, s.lugar_id, s.capacidad, s.inicio AS start, s.fin AS end, s.estado FROM servicios s WHERE s.sede_id = ? AND s.lugar_id = ?', [$sede, $lugar]);

        return response()->json($reservations);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
