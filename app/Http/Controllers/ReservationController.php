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
use Illuminate\Support\Str;

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
        // $lugares = Lugar::all();
        $lugares = null;
        return view('pages.public.reservation.index', compact('sede', 'lugares', 'personalInfo', 'authenticate'));
    }

    public function getPlaces($id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
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

        $datos_reserva = [
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
                $datos_reserva["periodicidad_id"]
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
