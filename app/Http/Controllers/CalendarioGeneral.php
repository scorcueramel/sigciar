<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Sede;
use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarioGeneral extends Controller
{
    public function index(){
        $sedes = Sede::where("estado",'A')->get();
        $tiposervicios = TipoServicio::where('estado','A')->get();
        return view("pages.private.dashboard.calendario-general", compact('sedes','tiposervicios'));
    }

    public function chargePlaces(string $id){
        $lugares = Lugar::where('sede_id', $id)->get();
        return response()->json($lugares);
    }

    public function chargeEvents(){
        $eventos = DB::select("SELECT tiposervicio_id, sede_id, lugar_id, start, ends as end, nombre FROM calendario_listar(0,0,0)");
        dd($eventos);
        return response()->json($eventos);
    }
}
