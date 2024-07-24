<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\SubtipoServicio;
use App\Models\TipoServicio;
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
            $inscripciones = DB::select("SELECT distinct s.id as servicios_id,
                                            ts.descripcion || ' - ' || sts.titulo || ' - ' || sts.subtitulo as descripcion,
                                            per.documento,
                                            per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                            ver_horarios (cast(s.id as integer)) as horario,
                                            ver_horarios_ins (
                                                cast(s.id as integer),
                                                cast(
                                                    coalesce(ins.persona_id, 0) as integer
                                                )
                                            ) as horario_inscripcion,
                                            lc.costohora as pago,
                                            ins.estado as estado_inscripcion,
                                            pag.estadopago as estado_pago,
                                            pag.fechapago
                                            from
                                                servicios s
                                                left join public.tipo_servicios ts on s.tiposervicio_id = ts.id
                                                left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                                left join public.sedes sed on s.sede_id = sed.id
                                                left join public.lugars l on s.lugar_id = l.id
                                                left join public.lugar_costos lc on lc.lugars_id = l.id
                                                and lc.descripcion = s.turno
                                                left join public.servicio_plantillas sp on s.id = sp.servicio_id
                                                join public.servicio_inscripcions ins on s.id = ins.servicio_id
                                                left join public.servicio_reservas sr on ins.id = sr.servicioinscripcion_id
                                                left join public.personas per on ins.persona_id = per.id
                                                left join public.servicio_pagos pag on ins.id = pag.servicioinscripcion_id");
        } else {
                $inscripciones = DB::select("SELECT distinct s.id as servicios_id,
                                                ts.descripcion || ' - ' || sts.titulo || ' - ' || sts.subtitulo as descripcion,
                                                per.documento,
                                                per.apepaterno || ' ' || per.apematerno || ' ' || nombres as apeynom,
                                                ver_horarios (cast(s.id as integer)) as horario,
                                                ver_horarios_ins (
                                                    cast(s.id as integer),
                                                    cast(
                                                        coalesce(ins.persona_id, 0) as integer
                                                    )
                                                ) as horario_inscripcion,
                                                lc.costohora as pago,
                                                ins.estado as estado_inscripcion,
                                                pag.estadopago as estado_pago,
                                                pag.fechapago
                                                from
                                                    servicios s
                                                    left join public.tipo_servicios ts on s.tiposervicio_id = ts.id
                                                    left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                                    left join public.sedes sed on s.sede_id = sed.id
                                                    left join public.lugars l on s.lugar_id = l.id
                                                    left join public.lugar_costos lc on lc.lugars_id = l.id
                                                    and lc.descripcion = s.turno
                                                    left join public.servicio_plantillas sp on s.id = sp.servicio_id
                                                    join public.servicio_inscripcions ins on s.id = ins.servicio_id
                                                    left join public.servicio_reservas sr on ins.id = sr.servicioinscripcion_id
                                                    left join public.personas per on ins.persona_id = per.id
                                                    left join public.servicio_pagos pag on ins.id = pag.servicioinscripcion_id
                                                where s.responsable_id = ?", [$persona[0]->id]);
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
                                <button class="dropdown-item delete" onclick="deleteInscripcion('.$row->servicios_id.')"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>';
            })
            ->rawColumns(['estado_pago', 'acciones'])
            ->make(true);
    }

    public function create()
    {
        // $actividades = TipoServicio::where('id', '<>', 1)->orderBy('descripcion', 'asc')->get();
        return view("pages.private.actividades.inscripciones.create");
    }

    public function chargePrograms()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $actividades = DB::select("select s.id, ts.descripcion || ' - ' || coalesce(sts.titulo,'') || ' - ' || coalesce(l.descripcion,'') as title,
                                        sr.inicio as start,
                                        sr.fin as end
                                        from servicio_reservas sr
                                        left join public.servicio_plantillas sp  on sr.servicioplantilla_id = sp.id
                                        left join public.servicios s on sp.servicio_id = s.id
                                        left join public.tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join public.lugars l on s.lugar_id= l.id
                                        where s.estado = 'A' and s.tiposervicio_id=2 and s.subtiposervicio_id=4");
        } else {
            $actividades = DB::select("select s.id, ts.descripcion || ' - ' || coalesce(sts.titulo,'') || ' - ' || coalesce(l.descripcion,'') as title,
                                        sr.inicio as start,
                                        sr.fin as end
                                        from servicio_reservas sr
                                        left join public.servicio_plantillas sp  on sr.servicioplantilla_id = sp.id
                                        left join public.servicios s on sp.servicio_id = s.id
                                        left join public.tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join public.lugars l on s.lugar_id= l.id
                                        where s.estado = 'A' and s.tiposervicio_id=2 and s.subtiposervicio_id=4 and s.responsable_id = ?", [$persona[0]->id]);
        }
        return datatables()->of($actividades)
            ->addColumn('acciones', function ($row) {
                return '<div class="form-check">
                            <input class="form-check-input selectactivity" type="radio" name="actividadRadio" id="' . $row->id . '" onclick="actividadSeleccionada(' . $row->id . ')">
                            <label class="form-check-label" for="' . $row->id . '">
                            </label>
                        </div>';
            })
            ->addColumn('turno', function ($row) {
                if ($row->turno == "DIURNO") {
                    return 'DIURNO <i class="fa-solid fa-sun text-warning"></i>';
                }
                if ($row->turno == "NOCTURNO") {
                    return 'NOCTURNO <i class="fa-solid fa-moon-stars text-primary"></i>';
                }
            })
            ->addColumn('inicio', function ($row) {
                $inicio = \DateTime::createFromFormat('Y-m-d H:i:s', $row->inicio);
                return $inicio->format('d/m/Y');
            })
            ->addColumn('fin', function ($row) {
                $fin = \DateTime::createFromFormat('Y-m-d H:i:s', $row->fin);
                return $fin->format('d/m/Y');
            })
            ->addColumn('titulo', function ($row) {
                return $row->titulo == "" ? "SIN DATOS" : $row->titulo . ' - ' . $row->subtitulo;
            })
            ->rawColumns(['acciones', 'titulo', 'inicio', 'turno'])
            ->make(true);
    }

    //get days by activities, IN THIS FUNCTION GETTER THE SUBCATEGORIA, PREPARETE QUERY FOR DAYS IS REGISTERED ON THIS CATEGORY
    public function getDaysActivity(string $idactivity)
    {
        $diasPorActividad = DB::select("SELECT dia FROM servicioinscripcion_listardias(?);", [$idactivity]);
        return response()->json($diasPorActividad);
    }

    public function getHoursForDay(string $idServicio, string $day)
    {
        $hours = DB::select("SELECT horarios FROM servicioinscripcion_listarhora(?,?);", [$idServicio, $day]);
        return response()->json($hours);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = $persona[0]->nombres . " " . $persona[0]->apepaterno . " " . $persona[0]->apematerno;
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
