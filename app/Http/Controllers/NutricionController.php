<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\Servicio;
use App\Models\SubtipoServicio;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NutricionController extends Controller
{
    public function index()
    {
        return view("pages.private.actividades.nutricion.index");
    }

    public function tableNutricion()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $tableNutrition = DB::select("select
                                            s.id ,ts.descripcion as tipo_servicio ,s.estado as estado ,
                                            s2.descripcion as sede,s2.direccion as direccion_sede,
                                            l.descripcion as lugar_descripcion,l.costohora as lugar_costo_hora,
                                            s.capacidad as capacidad,s.inicio as inicio,s.fin as fin,s.horas as hora,s.turno as turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) as responsable
                                        from servicios s
                                            left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                            left join sedes s2 on s.sede_id = s2.id
                                            left join lugars l on s.lugar_id = l.id
                                            left join personas p on s.responsable_id = p.id
                                            left join subtipo_servicios ss on s.subtiposervicio_id = ss.id
                                        where s.deleted_at is null and s.tiposervicio_id = 2");
        } else {
            $tableNutrition = DB::select("select
                                            s.id ,ts.descripcion as tipo_servicio ,s.estado as estado ,
                                            s2.descripcion as sede,s2.direccion as direccion_sede,
                                            l.descripcion as lugar_descripcion,l.costohora as lugar_costo_hora,
                                            s.capacidad as capacidad,s.inicio as inicio,s.fin as fin,s.horas as hora,s.turno as turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) as responsable
                                        from servicios s
                                            left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                            left join sedes s2 on s.sede_id = s2.id
                                            left join lugars l on s.lugar_id = l.id
                                            left join personas p on s.responsable_id = p.id
                                            left join subtipo_servicios ss on s.subtiposervicio_id = ss.id
                                        where s.deleted_at is null and s.tiposervicio_id = 2 and responsable_id = ?", [$persona[0]->id]);
        }

        return datatables()->of($tableNutrition)
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
            ->addColumn('direccion_sede', function ($row) {
                return $row->direccion_sede == "" ? "SIN DIRECCIÓN" : $row->direccion_sede;
            })
            ->addColumn('hora', function ($row) {
                return $row->hora == "" ? "SIN HORA" : $row->hora;
            })
            ->addColumn('acciones', function ($row) {
                return '<div class="dropdown">
                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                <i class="fa-duotone fa-gear"></i>
                            </button>
                            <div class="dropdown-menu">
                                <button data-bs-toggle="modal" data-bs-target="#modalcomponent" onclick="showDetail(' . $row->id . ')" class="dropdown-item"><i class="bx bx-message-alt-detail me-1"></i> Detalle</button>
                                <button class="dropdown-item delete" onclick="deleteNutricion(' . $row->id . ')"><i class="bx bx-trash me-1"></i> Eliminar</button>
                            </div>
                        </div>';
            })
            ->addColumn('estado', function ($row) {
                if ($row->estado == "A") {
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState(' . $row->id . ')"><span class="badge bg-label-success me-1">PUBLICADO</span></button>';
                } else {
                    return '
                    <button class="bg-transparent border-0 change-state" data-toggle="tooltip" title="Cambiar estado" onclick="changeState(' . $row->id . ')"><span class="badge bg-label-danger me-1">BORRADOR</span></button>';
                }
            })
            ->rawColumns(['direccion_sede', 'sede_imagen', 'hora', 'inicio', 'estado', 'turno', 'acciones'])
            ->make(true);
    }

    public function calendarioNutricion()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $nutricion = DB::select("select s.id, ts.descripcion || ' - ' || coalesce(sts.titulo, '') || ' - ' || coalesce(l.descripcion, '') as title, sp.inicio::date as start, sp.fin::date as end
                                    from
                                        public.servicio_plantillas sp
                                        left join public.servicios s on sp.servicio_id = s.id
                                        left join public.tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join public.lugars l on s.lugar_id = l.id
                                    where
                                        s.deleted_at is null
                                        and s.tiposervicio_id = 2");
        } else {
            $nutricion = DB::select("select s.id, ts.descripcion || ' - ' || coalesce(sts.titulo, '') || ' - ' || coalesce(l.descripcion, '') as title, sp.inicio::date as start, sp.fin::date as end
                                    from
                                        public.servicio_plantillas sp
                                        left join public.servicios s on sp.servicio_id = s.id
                                        left join public.tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join public.lugars l on s.lugar_id = l.id
                                    where
                                        s.deleted_at is null
                                        and s.tiposervicio_id = 2 and responsable_id = ?;", [$persona[0]->id]);
        }

        return response()->json($nutricion);
    }

    public function changeState(Request $request)
    {
        $servicio = Servicio::find($request->id);
        if ($servicio->estado == "I") {
            $servicio->estado = "A";
            $nombreCategoria = $servicio->descripcion;
            $servicio->save();
            return back()->with(["success" => "La sede $nombreCategoria fue ACTIVADA"]);
        }
        if ($servicio->estado == "A") {
            $servicio->estado = "I";
            $nombreCategoria = $servicio->descripcion;
            $servicio->save();
            return back()->with(["success" => "La sede $nombreCategoria fue DESACTIVADA"]);
        }
    }

    public function create()
    {
        // Obtener quien esta autenticado
        $responsable = Persona::where('usuario_id', Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id', '<>', 1)->where('tipocategoria_id', '<>', 2)->get();
        $sedes = Sede::where('estado', 'A')->get();
        $subtiposervicio = SubtipoServicio::where('tiposervicio_id', 4)->orderBy('id', 'desc')->get();

        return view("pages.private.actividades.nutricion.create", compact("responsable", "responsables", "sedes", "subtiposervicio"));
    }

    public function placesCharge(string $id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
        switch (count($lugares)) {
            case 0:
                $lugares = "No existen lugares asocidas a la sede seleccionada, favor comunicarse con el administrador del sistema";
                return response()->json($lugares);
            default:
                return response()->json($lugares);
        }
    }

    public function coastPlaces(string $idActividad, string $idLugar)
    {
        // $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	public.lugar_costos
        //                         where tiposervicios_id=? and lugars_id = ?", [$idActividad, $idLugar]);
        $lugar_costo = DB::select("SELECT id,descripcion,costohora AS costo,tipo FROM 	public.lugar_costos
                                   WHERE tiposervicios_id=? AND lugars_id = ?", [$idActividad, $idLugar]);
        return response()->json($lugar_costo);
    }

    public function store(Request $request)
    {
        $responsable = $request->responsable;
        $actividad = $request->actividad;
        $categoria = $request->categoria;
        $sede = $request->sede;
        $lugar = $request->lugar;
        $fechaInicio = "{$request->fechaInicio} 00:00:00";
        $termino = "{$request->termino} 00:00:00";
        $cupos = $request->cupos;
        $horasActividad = $request->horasActividad;
        $turno = $request->turno;
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = "{$usuario[0]->nombres} {$usuario[0]->apepaterno} {$usuario[0]->apematerno}";
        $ip = $request->ip();
        $created_at = new DateTime();
        $creacion = $created_at->format('Y-m-d H:i:s');
        $fechasDefinidas = $request->fechasDefinidas;
        $estado = $request->publicado;

        $validation = Validator::make(
            $request->all(),
            [
                'actividad' => 'required',
                'categoria' => 'required',
                'sede' => 'required',
                'lugar' => 'required',
                'fechaInicio' => 'required',
                'termino' => 'required',
                'cupos' => 'required',
                'horasActividad' => 'required',
            ],
            [
                'actividad.required' => 'Porfavor selecciona una actividad',
                'categoria.required' => 'Porfavor selecciona una categoría',
                'sede.required' => 'Porfavor selecciona una sede',
                'lugar.required' => 'Porfavor selecciona un lugar',
                'fechaInicio.required' => 'Porfavor ingresa una fecha de inicio',
                'termino.required' => 'Porfavor ingresa una fecha de termino',
                'cupos.required' => 'Porfavor ingresa la cantidad de cupos',
                'horasActividad.required' => 'Porfavor indica las horas por actividad',
            ]
        );

        if ($validation->fails()) {
            $error = $validation->errors();
            return response()->json(['error' => $error]);
        }

        $servicioTenisCrear = DB::select("SELECT servicio_tenis_crear(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", [$fechaInicio, $termino, $responsable, $actividad, $sede, $lugar, $cupos, 2, $nombre_usuario, $ip, $creacion, $turno, $categoria, $horasActividad, $estado]);

        $idRespuesta = $servicioTenisCrear[0]->servicio_tenis_crear;

        $idPlantillaConvert = Str::of($idRespuesta)->after(',')->before(')');
        $idRegistroConvert = Str::of($idRespuesta)->before(',')->after('(');

        foreach ($fechasDefinidas as $fecha) {
            $dia = $fecha["dias"];
            $hInicio = Str::of($fecha["horarios"])->before(' ');
            $hFin = Str::of($fecha["horarios"])->after('- ');
            $servicioTenisHoras = DB::select("SELECT servicio_programa_horario(?,?,?,?,?,?,?);", [$idPlantillaConvert, $dia, $hInicio, $hFin, $nombre_usuario, $ip, $creacion]);
        }

        $respuestaHorarios = $servicioTenisHoras[0]->servicio_programa_horario;

        $respuesta = Str::of($respuestaHorarios)->after(',')->before(')');

        return response()->json(['idPlantilla' => $idPlantillaConvert, 'idRegistro' => $idRegistroConvert, 'respRegistro' => $respuesta]);
    }

    public function show(string $id)
    {
        $detalleNutricion = DB::select("select
                                            s.id ,ts.descripcion as tipo_servicio ,s.estado as estado ,
                                            s2.descripcion as sede,s2.direccion as direccion_sede,
                                            l.descripcion as lugar_descripcion,l.costohora as lugar_costo_hora,
                                            s.capacidad as capacidad,s.inicio as inicio,s.fin as fin,s.horas as hora,s.turno as turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) as responsable
                                        from servicios s
                                        left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                        left join sedes s2 on s.sede_id = s2.id
                                        left join lugars l on s.lugar_id = l.id
                                        left join personas p on s.responsable_id = p.id
                                        left join subtipo_servicios ss on s.subtiposervicio_id = ss.id
                                        where s.deleted_at is null
                                        and s.id = ?", [$id]);

        return response()->json($detalleNutricion);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $actividad = Servicio::find($request->id);
        $actividad->delete();
        return redirect()->back()->with('success', 'El programa de nutrición fue eliminada');
    }
}
