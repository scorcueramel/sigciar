<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\Servicio;
use App\Models\SubtipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OtrosProgramasController extends Controller
{
    public function index()
    {
        return view("pages.private.actividades.otros-programas.index");
    }

    public function tableOtherQuery()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $tableActivity = DB::select("select
                                                s.id,ts.descripcion as tipo_servicio ,s.estado as estado ,
                                                s2.descripcion as sede,s2.direccion as direccion_sede,
                                                l.descripcion as lugar_descripcion,l.costohora as lugar_costo_hora,
                                                s.capacidad as capacidad,s.inicio as inicio,s.fin as fin,s.horas as hora,s.turno as turno,
                                                concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) as responsable,
                                                ss.titulo as titulo,ss.subtitulo as subtitulo
                                        from servicios s
                                                left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                                left join sedes s2 on s.sede_id = s2.id
                                                left join lugars l on s.lugar_id = l.id
                                                left join personas p on s.responsable_id = p.id
                                                left join subtipo_servicios ss on s.subtiposervicio_id = ss.id
                                        where s.deleted_at is null and s.tiposervicio_id = 4");
        } else {
            $tableActivity = DB::select("select
                                            s.id,ts.descripcion as tipo_servicio ,s.estado as estado ,
                                            s2.descripcion as sede,s2.direccion as direccion_sede,
                                            l.descripcion as lugar_descripcion,l.costohora as lugar_costo_hora,
                                            s.capacidad as capacidad,s.inicio as inicio,s.fin as fin,s.horas as hora,s.turno as turno,
                                            s.responsable_id as responsable_id, concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) as responsable,
                                            ss.titulo as titulo,ss.subtitulo as subtitulo
                                        from servicios s
                                                left join tipo_servicios ts on s.tiposervicio_id = ts.id
                                                left join sedes s2 on s.sede_id = s2.id
                                                left join lugars l on s.lugar_id = l.id
                                                left join personas p on s.responsable_id = p.id
                                                left join subtipo_servicios ss on s.subtiposervicio_id = ss.id
                                        where s.deleted_at is null and s.tiposervicio_id = 4 and responsable_id = ?", [$persona[0]->id]);
        }

        return datatables()->of($tableActivity)
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
        ->addColumn('titulo', function ($row) {
            return $row->titulo == "" ? "SIN TÍTULO" : $row->titulo;
        })
        ->addColumn('subtitulo', function ($row) {
            return $row->subtitulo == "" ? "SIN SUBTITULO" : $row->subtitulo;
        })
        ->addColumn('acciones', function ($row) {
            return '<div class="dropdown">
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="fa-duotone fa-gear"></i>
                        </button>
                        <div class="dropdown-menu">
                            <button data-bs-toggle="modal" data-bs-target="#modalcomponent" onclick="showDetail(' . $row->id . ')" class="dropdown-item">
                                <i class="bx bx-message-alt-detail me-1"></i> Detalle
                            </button>
                            <button class="dropdown-item delete" onclick="deleteActivity(' . $row->id . ')">
                                <i class="bx bx-trash me-1"></i> Eliminar
                            </button>
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
        ->rawColumns(['titulo', 'subtitulo', 'direccion_sede', 'sede_imagen', 'hora', 'inicio', 'estado', 'turno', 'acciones'])
        ->make(true);
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

    public function create()
    {
        // Obtener quien esta autenticado
        $responsable = Persona::where('usuario_id', Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id', '<>', 1)->where('tipocategoria_id', '<>', 2)->get();
        $sedes = Sede::where('estado', 'A')->get();
        $subtiposervicio = SubtipoServicio::where('tiposervicio_id', 4)->orderBy('id', 'desc')->get();

        return view("pages.private.actividades.otros-programas.create", compact("responsable", "responsables", "sedes", "subtiposervicio"));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        $detalleActividad = DB::select("select
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

        return response()->json($detalleActividad);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroyActivity(Request $request)
    {
        $actividad = Servicio::find($request->id);
        $actividad->delete();
        return redirect()->back()->with('success', 'El programa de tenis fue eliminado');
    }
}
