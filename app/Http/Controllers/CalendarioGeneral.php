<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Sede;
use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CalendarioGeneral extends Controller
{
    public function index()
    {
        $sedes = Sede::where("estado", 'A')->get();
        $tiposervicios = TipoServicio::where('estado', 'A')->get();
        return view("pages.private.dashboard.calendario-general", compact('sedes', 'tiposervicios'));
    }

    //Obtener lugares por sedes
    public function chargePlaces(string $id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
        return response()->json($lugares);
    }

    public function chargeEvents(Request $request)
    {

        $reservas = [];
        $inscritos = DB::select("SELECT tiposervicio_id, sede_id, lugar_id, start, ends as end, nombre FROM calendario_listar(0,0,0)");

        foreach ($inscritos as $inscrito) {
            $fecha = Str::before($inscrito->start, " ");
            $inicio = Str::after($inscrito->start, " ");
            $fin = Str::after($inscrito->end, " ");

            $sede = Sede::where('id', $inscrito->sede_id)->get()[0];

            $reservas[] = [
                'title' => $inscrito->nombre,
                'start' =>  $inscrito->start,
                'end' => $inscrito->end,
                'color' =>  'red',
                'extendedProps' => [
                    'sede' => $sede->descripcion,
                    'lugar' => 'CONSULTORIO',
                    'fecha' => $fecha,
                    'inicio' => $inicio,
                    'fin' => $fin,
                ],
            ];
        }

        // dd($reservas);
        return response()->json($reservas);
    }
}
