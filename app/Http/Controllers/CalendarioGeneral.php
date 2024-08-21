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

    public function chargeEventsQuery($tiposervicioView, $sedeView, $lugarView)
    {
        $sedeView == 0 || $sedeView == null ? 0 : $sedeView;
        $lugarView == 0 || $lugarView == null ? 0 : $lugarView;
        $tiposervicioView  == 0 || $tiposervicioView == null ? 0 : $tiposervicioView;
        $reservas = $this->getCitas($tiposervicioView, $sedeView, $lugarView);
        return response()->json($reservas);
    }

    protected function getCitas($tiposervicio, $sede, $lugar)
    {
        $reservas = [];
        $colores = [
            1=>'#1A5319',
            2=>'#FABC3F',
            3=>'#E85C0D',
            4=>'#C7253E',
            5=>'#0D7C66',
            6=>'#3A1078',
            7=>'#41B3A2',
            8=>'#BDE8CA',
            9=>'#821131',
            10=>'#4E31AA',
            11=>'#800000',
            12=>'#5B99C2',
            13=>'#1A4870',
            14=>'#674188',
            15=>'#4158A6',
            16=>'#7C00FE',
            17=>'#C63C51',
            18=>'#FF8225',
            19=>'#F6FB7A',
            20=>'#399918',
            21=>'#3FA2F6',
        ];
        $inscritos = DB::select("SELECT tiposervicio_id, sede_id, lugar_id, start, ends as end, nombre, movil, email, categoria_id, categoria FROM calendario_listar(?,?,?)", [$tiposervicio, $sede, $lugar]);

        foreach ($inscritos as $key => $inscrito) {
            $fecha = Str::before($inscrito->start, " ");
            $inicio = Str::after($inscrito->start, " ");
            $fin = Str::after($inscrito->end, " ");

            $sede = Sede::where('id', $inscrito->sede_id)->get()[0];
            $lugar = Lugar::where('id', $inscrito->lugar_id)->get()[0];

            $reservas[] = [
                'title' => $inscrito->nombre,
                'start' =>  $inscrito->start,
                'end' => $inscrito->end,
                'backgroundColor' =>  $colores[$inscrito->categoria_id],
                'borderColor' =>  $colores[$inscrito->categoria_id],
                'extendedProps' => [
                    'sede' => $sede->descripcion,
                    'lugar' => $lugar->descripcion,
                    'categoria_id' => $inscrito->categoria_id,
                    'categoria' => $inscrito->categoria,
                    'fecha' => $fecha,
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'correo' => $inscrito->email,
                    'movil' => $inscrito->movil,
                    'color' =>  $colores[$inscrito->categoria_id]
                ],
            ];
        }
        return $reservas;
    }
}
