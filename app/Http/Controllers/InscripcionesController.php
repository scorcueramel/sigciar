<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InscripcionesController extends Controller
{
    public function index()
    {
        return view("pages.private.actividades.inscripciones.index");
    }

    public function tableInscriptions()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $inscripciones = DB::select("SELECT distinct
                                            s.id as servicios_id,
                                            ts.descripcion || ' - ' || sts.titulo || ' - ' ||sts.subtitulo as descripcion,
                                            per.documento,
                                            per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                            ver_horarios(cast (s.id as integer)) as horario,
                                            lc.costohora as pago,
                                            ins.estado as estado_inscripcion,
                                            pag.estadopago as estado_pago,
                                            pag.fechapago
                                            from servicios s
                                            left join public.tipo_servicios ts  on s.tiposervicio_id = ts.id
                                            left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                            left join public.sedes sed on s.sede_id = sed.id
                                            left join public.lugars l on s.lugar_id = l.id
                                            left join public.lugar_costos lc on lc.lugars_id = l.id  and lc.descripcion = s.turno
                                            left join public.servicio_plantillas  sp on s.id = sp.servicio_id
                                            left join public.servicio_inscripcions ins on s.id = ins.servicio_id
                                            left join public.personas per on ins.persona_id = per.id
                                            left join public.servicio_pagos pag on ins.id = pag.servicioinscripcion_id
                                            ");
        } else {
            $inscripciones = DB::select("SELECT distinct
                                            s.id as servicios_id,
                                            ts.descripcion || ' - ' || sts.titulo || ' - ' ||sts.subtitulo as descripcion,
                                            per.documento,
                                            per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                            ver_horarios(cast (s.id as integer)) as horario,
                                            lc.costohora as pago,
                                            ins.estado as estado_inscripcion,
                                            pag.estadopago as estado_pago,
                                            pag.fechapago
                                            from servicios s
                                            left join public.tipo_servicios ts  on s.tiposervicio_id = ts.id
                                            left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                            left join public.sedes sed on s.sede_id = sed.id
                                            left join public.lugars l on s.lugar_id = l.id
                                            left join public.lugar_costos lc on lc.lugars_id = l.id  and lc.descripcion = s.turno
                                            left join public.servicio_plantillas  sp on s.id = sp.servicio_id
                                            left join public.servicio_inscripcions ins on s.id = ins.servicio_id
                                            left join public.personas per on ins.persona_id = per.id
                                            left join public.servicio_pagos pag on ins.id = pag.servicioinscripcion_id
                                            where responsable_id = ?", [$persona[0]->id]);
        }

        return datatables()->of($inscripciones)
            ->addColumn('estado_pago', function ($row) {
                if ($row->estado_pago == "A") {
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState()"><span class="badge bg-label-success me-1">PAGADO</span></button>';
                } else {
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState()"><span class="badge bg-label-danger me-1">PENDIENTE</span></button>';
                }
            })
            ->addColumn('acciones', function ($row) {
                return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="fa-duotone fa-gear"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button data-bs-toggle="modal" data-bs-target="#modalcomponent" onclick="showDetail()" class="dropdown-item"><i class="bx bx-message-alt-detail me-1"></i> Detalle</button>
                                <button class="dropdown-item delete" onclick="deleteActivity()"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>';
            })
            ->rawColumns(['estado_pago', 'acciones'])
            ->make(true);
    }

    public function create()
    {
        $actividades = DB::select("select distinct
                                    servicios.id as servicios_id,
                                    subtipo_servicios.titulo,
                                    subtipo_servicios.subtitulo,
                                    servicios.turno,
                                    lugar_costos.costohora as desde
                                    from servicios
                                    left join public.tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
                                    left join public.subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
                                    left join public.sedes on servicios.sede_id = sedes.id
                                    left join public.lugars on servicios.lugar_id = lugars.id
                                    left join public.lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
                                    left join public.servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
                                    where subtipo_servicios.titulo  is not null
                                    and tipo_servicios.id = 3
                                    and servicios.estado= 'A'");
        return view("pages.private.actividades.inscripciones.create", compact("actividades"));
    }

    public function getDaysActivity(string $idactivity){
        $diasPorActividad = DB::select("select dia FROM servicioinscripcion_listardias(?);", [$idactivity]);
        return response()->json($diasPorActividad);
    }

    public function getHoursForDay(string $idRegister, string $day)
    {
        $hours = DB::select("select horarios FROM servicioinscripcion_listarhora(?,?)", [$idRegister, $day]);
        return response()->json($hours);
    }

    public function store(Request $request)
    {

        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = $persona[0]->nombres." ".$persona[0]->appaterno." ".$persona[0]->apematerno;
        $servicioId = $request->idservicio;
        $fechasDefinias = $request->fechasDefinidas;
        $usuarioId = $request->idmiembro;
        $ip = $request->ip();

        $request->validate([
            'idplantilla',
            'idmiembro',
            'fechasDefinidas'
        ]);

        foreach ($fechasDefinias as $fd) {
            $dia = $fd['dias'];
            $hora = $fd['horarios'];
            DB::select('SELECT servicio_inscripcion(?,?,?,?,?,?)', [$servicioId, $dia, $usuarioId, $hora, $usuarioActivo, $ip]);
        }

        return response()->json(['success' => 'ok']);
    }

    public function show($id)
    {
        //
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
