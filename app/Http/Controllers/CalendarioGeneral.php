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

    public function chargeEvents()
    {
        $reservas = $this->getCitas(0, 0, 0);
        return response()->json($reservas);
    }

    public function chargeEventsQuery($tiposervicioView,$sedeView,$lugarView)
    {
        $sedeView == 0 || $sedeView == null ? 0 : $sedeView;
        $lugarView == 0 || $lugarView == null ? 0 : $lugarView;
        $tiposervicioView  == 0 || $tiposervicioView == null ? 0 : $tiposervicioView ;
        $reservas = $this->getCitas($tiposervicioView, $sedeView , $lugarView);
        return response()->json($reservas);
    }

    protected function getCitas($tiposervicio, $sede, $lugar)
    {
        $reservas = [];
        $inscritos = DB::select("SELECT tiposervicio_id, sede_id, lugar_id, start, ends as end, nombre, movil, email, categoria FROM calendario_listar(?,?,?)", [$tiposervicio, $sede, $lugar]);

        foreach ($inscritos as $inscrito) {
            $fecha = Str::before($inscrito->start, " ");
            $inicio = Str::after($inscrito->start, " ");
            $fin = Str::after($inscrito->end, " ");

            $sede = Sede::where('id', $inscrito->sede_id)->get()[0];
            $lugar = Lugar::where('id', $inscrito->lugar_id)->get()[0];

            $reservas[] = [
                'title' => $inscrito->nombre,
                'start' =>  $inscrito->start,
                'end' => $inscrito->end,
                'color' =>  'red',
                'extendedProps' => [
                    'sede' => $sede->descripcion,
                    'lugar' => $lugar->descripcion,
                    'categoria' => $inscrito->categoria,
                    'fecha' => $fecha,
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'correo' => $inscrito->email,
                    'movil' => $inscrito->movil,
                ],
            ];
        }

        return $reservas;
    }
}
