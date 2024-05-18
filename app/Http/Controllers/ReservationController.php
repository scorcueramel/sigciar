<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{

    public function index()
    {
        //
        $sede = DB::select('SELECT * FROM sedes');
        return view('pages.public.reservation.index',compact('sede'));
    }

    public function getPlaces($id){
        $sedes = DB::select('SELECT l.id, l.descripcion, l.abreviatura, l.costohora, l.estado, l.tipo, l.sede_id FROM lugar l WHERE sede_id = ? ',[$id]);
        return response()->json($sedes);
    }

    public function dateQuery(Request $request){
        $fechasRecibidas = $request->all();
        $message = "Este horario no se encuentra disponible, te sugerimos seleccionar otro.";

        $start = $fechasRecibidas["start"]; // desde el calendario
        $end = $fechasRecibidas["end"]; //desde el calendario
        $fechasAlmacenadas = DB::select("SELECT s.inicio, s.fin FROM servicio s");

        $fecstart = substr($start,0,10) . " " . substr($start,11,8); //formatear fecha recibida del calendario
        $fecend = substr($end,0,10) . " " . substr($end,11,8); //formatear fecha recibida del calendario

        foreach ($fechasAlmacenadas as $key => $value) {
            $fechaStart = $fechasAlmacenadas[$key]->inicio; //fechas obtenidas de la BD
            $fechaEnd = $fechasAlmacenadas[$key]->fin; //fechas obtenidas de la BD

            //fechavista    //fechabd
            if($fecstart <= $fechaStart && $fecend > $fechaStart){
                return response()->json(["msg"=>$message]);
            }
            if($fecstart < $fechaEnd && $fecend > $fechaEnd){
                return response()->json(["msg"=>$message]);
            }
            if($fecstart >= $fechaStart && $fecend <= $fechaEnd){
                return response()->json(["msg"=>$message]);
            }
        }
        return response()->json(["msg"=>"ok"]);
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show()
    {
        //
        $reservations = DB::select('SELECT
        sr.id, sr.servicioplantilla_id, sr.inicio as "start", sr.fin as "end", sr.estado, sr.usuario_creador, sr.usuario_editor,
        sr.ip_usuario, sr.deleted_at, sr.created_at, sr.updated_at
        FROM servicioreserva sr');

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
