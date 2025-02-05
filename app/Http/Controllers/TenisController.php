<?php

namespace App\Http\Controllers;

use App\Mail\NotasMiembro;
use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\Servicio;
use App\Models\ServicioInforme;
use App\Models\SubtipoServicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Illuminate\Support\Str;


class TenisController extends Controller
{
    // renderizar la vista
    public function index()
    {
        return view("pages.private.actividades.tenis.index");
    }

    public function renderCalendar()
    {
        return view("pages.private.actividades.tenis.calendar");
    }

    public function tableActivity()
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
                                        where s.deleted_at is null and s.tiposervicio_id = 3");
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
                                        where s.deleted_at is null and s.tiposervicio_id = 3 and responsable_id = ?", [$persona[0]->id]);
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
                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalcomponent" onclick="showDetail(' . $row->id . ')" class="dropdown-item">
                                    <i class="bx bx-message-alt-detail me-1"></i> Detalle
                                </button>
                                <button type="button" onclick="editProgram(' . $row->id . ')" class="dropdown-item">
                                    <i class="bx bx-edit-alt me-1"></i> Editar
                                </button>
                                <button type="button" class="dropdown-item delete" onclick="deleteActivity(' . $row->id . ')">
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

    public function calendarioTenis()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $tenis = DB::select("SELECT
                                    s.id, sts.titulo as programa, l.descripcion as cancha, sr.inicio as start, sr.fin as end,
                                    sr.dia, s.horas, se.descripcion as sede, s.turno, concat(pe.nombres,' ', pe.apepaterno, ' ', pe.apematerno) as title, si.id as servicioinscripcion_id
                                    from
                                        servicio_reservas sr
                                        left join servicio_plantillas sp on sr.servicioplantilla_id = sp.id
                                        left join servicios s on sp.servicio_id = s.id
                                        left join tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join lugars l on s.lugar_id = l.id
                                        left join sedes se on se.id = s.sede_id
                                        left join servicio_inscripcions si on si.servicio_id = s.id
                                        left join personas pe on pe.id = si.persona_id
                                    where
                                        s.estado = 'A'
                                        and s.tiposervicio_id = 3");
        } else {
            $tenis = DB::select("SELECT
                                    s.id, sts.titulo as programa, l.descripcion as cancha, sr.inicio as start, sr.fin as end,
                                    sr.dia, s.horas, se.descripcion as sede, s.turno, concat(pe.nombres,' ', pe.apepaterno, ' ', pe.apematerno) as title, si.id as servicioinscripcion_id
                                    from
                                        servicio_reservas sr
                                        left join servicio_plantillas sp on sr.servicioplantilla_id = sp.id
                                        left join servicios s on sp.servicio_id = s.id
                                        left join tipo_servicios ts on ts.id = s.tiposervicio_id
                                        left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                        left join lugars l on s.lugar_id = l.id
                                        left join sedes se on se.id = s.sede_id
                                        left join servicio_inscripcions si on si.servicio_id = s.id
                                        left join personas pe on pe.id = si.persona_id
                                    where
                                        s.estado = 'A'
                                        and s.tiposervicio_id = 3 and s.responsable_id= ?;", [$persona[0]->id]);
        }

        return response()->json($tenis);
    }

    // cambiar los estados
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

    // render view create new activity
    public function create()
    {
        // Obtener quien esta autenticado
        $responsable = Persona::where('usuario_id', Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id', '<>', 1)->where('tipocategoria_id', '<>', 2)->get();
        $sedes = Sede::where('estado', 'A')->get();
        $subtiposervicio = SubtipoServicio::where('tiposervicio_id', 3)->orderBy('id', 'desc')->get();

        return view("pages.private.actividades.tenis.create", compact("responsable", "responsables", "sedes", "subtiposervicio"));
    }

    // get category by idPlaces
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
        // $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	lugar_costos
        //                         where tiposervicios_id=? and lugars_id = ?", [$idActividad, $idLugar]);
        $lugar_costo = DB::select("SELECT id,descripcion,costohora AS costo,tipo FROM 	lugar_costos
                                   WHERE tiposervicios_id=? AND lugars_id = ?", [$idActividad, $idLugar]);
        return response()->json($lugar_costo);
    }

    // get member by document
    public function searchMember(string $document)
    {
        if ($document != '' || $document != null) {
            $findMember = Persona::where('documento', $document)->where('tipocategoria_id', '=', 2)->get();
            if (count($findMember) <= 0) {
                $findMember = "Parece que el documento: $document no es de un miembro o no se encuentra registrado, favor de verificar que el documento ingresado sea correcto y corresponda a un miembro, luego volver a itentar";
                return response()->json($findMember);
            } else {
                return response()->json($findMember);
            }
        } else {
            $findMember = "Parece que no ingresaste ningun documento para realizar una búsqueda.";
            return response()->json($findMember);
        }
    }

    // render image for category
    public function renderImageForCategory(string $id)
    {
        $imagen = SubtipoServicio::where('id', $id)->select("imagen")->get();
        return response()->json($imagen[0]);
    }

    // store new activity
    public function storeNewActivity(Request $request)
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

        $servicioTenisCrear = DB::select(
            "SELECT servicio_tenis_crear(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [$fechaInicio, $termino, $responsable, $actividad, $sede, $lugar, $cupos, 2, $nombre_usuario, $ip, $creacion, $turno, $categoria, $horasActividad, $estado]
        );

        $idRespuesta = $servicioTenisCrear[0]->servicio_tenis_crear;

        $idPlantillaConvert = Str::of($idRespuesta)->after(',')->before(')');
        $idRegistroConvert = Str::of($idRespuesta)->before(',')->after('(');

        foreach ($fechasDefinidas as $fecha) {
            $dia = $fecha["dias"];
            $hInicio = Str::of($fecha["horarios"])->before(' ');
            $hFin = Str::of($fecha["horarios"])->after('- ');
            $servicioTenisHoras = DB::select("SELECT servicio_tenis_horario(?,?,?,?,?,?,?);", [$idPlantillaConvert, $dia, $hInicio, $hFin, $nombre_usuario, $ip, $creacion]);
        }

        $respuestaHorarios = $servicioTenisHoras[0]->servicio_tenis_horario;
        $respuesta = Str::of($respuestaHorarios)->after(',')->before(')');

        return response()->json(['idPlantilla' => $idPlantillaConvert, 'idRegistro' => $idRegistroConvert, 'respRegistro' => $respuesta]);
    }

    // redirect after create activity
    public function redirectAfterCreateActivity(string $plantilla, string $registro)
    {
        $plantillaId = $plantilla;
        $registroId = $registro;

        $diasPorActividad = DB::select("select dia FROM servicioinscripcion_listardias(?);", [$registroId]);
        return view('pages.private.actividades.inscripciones.create-to-activity', compact('diasPorActividad', 'registro', 'plantillaId'));
    }

    // get hour for day
    public function getHoursForDay(string $idRegister, string $day)
    {
        $hours = DB::select("select horarios FROM servicioinscripcion_listarhora(?,?)", [$idRegister, $day]);
        return response()->json($hours);
    }

    public function storeInscripcion(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = "{$persona[0]->nombres} {$persona[0]->apepaterno} {$persona[0]->apematerno}";
        $servicioId = $request->idplantilla;
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

    // destroy by activity
    public function destroyActivity(Request $request)
    {
        $actividad = Servicio::find($request->id);
        $actividad->delete();
        return redirect()->back()->with('success', 'El programa de tenis fue eliminado');
    }

    // edti activity
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

    public function sendNote(Request $request){
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = "{$usuario[0]->nombres} {$usuario[0]->apepaterno} {$usuario[0]->apematerno}";
        $nota = new ServicioInforme();
        $nota->servicioinscripcion_id = $request->servinscid;
        $nota->detalle = $request->nota;
        $nota->adjuntto = $request->enlace;
        $nota->estado = 'A';
        $nota->usuario_creador = $nombre_usuario;
        $nota->ip_usuario = $request->ip();
        $nota->save();

        $resultNota = DB::select("SELECT si.* ,p.nombres ,p.apepaterno ,p.apematerno , p.usuario_id
                                    FROM servicio_informes si
                                    LEFT JOIN servicio_inscripcions si2
                                    ON si.servicioinscripcion_id = si2.id
                                    LEFT JOIN personas p
                                    ON si2.persona_id = p.id
                                    WHERE si.id = ?",[$nota->id]);

        $correo = User::where('id',$resultNota[0]->usuario_id)->select('email')->get()[0]->email;

        Mail::to($correo)->send(new NotasMiembro($resultNota[0]));

        return response()->json("ok");
    }

    public function getNotesMember(string $idService){
        $findNote = DB::select("SELECT si.id ,si.servicioinscripcion_id ,si.detalle, si.adjuntto ,p.nombres ,p.apepaterno ,p.apematerno ,p.usuario_id,si.privado ,si.created_at
                                FROM servicio_informes si
                                LEFT JOIN servicio_inscripcions si2
                                ON si.servicioinscripcion_id = si2.id
                                LEFT JOIN personas p
                                ON si2.persona_id = p.id
                                WHERE si.servicioinscripcion_id = ?",[$idService]);
        return response()->json($findNote);
    }

    public function edit(string $idServicio){

        $responsable = Persona::where('usuario_id', Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id', '<>', 1)->where('tipocategoria_id', '<>', 2)->get();
        $sedes = Sede::where('estado', 'A')->get();
        $lugares = Lugar::where('estado', 'A')->get();
        $subtiposervicio = SubtipoServicio::where('tiposervicio_id', 3)->orderBy('id', 'desc')->get();

        $getProgram = DB::select("SELECT
                                s.id , s.responsable_id,
                                s.subtiposervicio_id AS categoria_id,
                                s.sede_id , s.lugar_id,l.descripcion AS lugar_descripcion, s.turno,
                                s.inicio AS inicio,s.fin AS fin, s.capacidad as cupos, s.horas as duracion, s.estado, sts.imagen
                                FROM servicios s
                                LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
                                LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
                                LEFT JOIN sedes s2 ON s.sede_id = s2.id
                                LEFT JOIN lugars l ON s.lugar_id = l.id
                                LEFT JOIN personas p ON s.responsable_id = p.id
                                LEFT JOIN subtipo_servicios ss ON s.subtiposervicio_id = ss.id
                                WHERE s.id = ?", [$idServicio]);

        $getDaysToProgram = DB::select("SELECT
                                        sp.servicio_id, sh.servicioplantilla_id, sh.dia, sh.horainicio, sh.horafin,  sh.estado
                                        FROM servicio_horarios sh
                                        LEFT JOIN servicio_plantillas sp ON sh.servicioplantilla_id = sp.id
                                        WHERE sp.servicio_id = ?",[$idServicio]);

        return view('pages.private.actividades.tenis.edit', compact("getProgram","getDaysToProgram","responsable", "responsables", "sedes", "lugares","subtiposervicio"));
    }

    public function getDaysForUpdate(string $idService){
        $getDaysToProgram = DB::select("SELECT
        sp.servicio_id, sh.servicioplantilla_id, sh.dia, sh.horainicio, sh.horafin,  sh.estado
        FROM servicio_horarios sh
        LEFT JOIN servicio_plantillas sp ON sh.servicioplantilla_id = sp.id
        WHERE sp.servicio_id = ?",[$idService]);
        return response()->json($getDaysToProgram);
    }

    public function update(Request $request){
        $idprograma = $request->idPrograma;
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

        // dd($request->all());

        $servicioTenisCrear = DB::select(
            "SELECT servicio_tenis_update(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [
                $fechaInicio, $termino, $responsable, $actividad, $sede, $lugar, $cupos, 2, $nombre_usuario, $ip, $creacion, $turno, $categoria, $horasActividad, $estado, $idprograma]
        );

        $idRespuesta = $servicioTenisCrear[0]->servicio_tenis_update;

        $idPlantillaConvert = Str::of($idRespuesta)->after(',')->before(')');
        $idRegistroConvert = Str::of($idRespuesta)->before(',')->after('(');

        DB::select("DELETE FROM public.servicio_horarios where servicioplantilla_id = $idPlantillaConvert");
        DB::select("DELETE FROM public.servicio_disponibles WHERE servicioplantilla_id = $idPlantillaConvert");

        foreach ($fechasDefinidas as $fecha) {
            $dia = $fecha["dias"];
            $hInicio = Str::of($fecha["horarios"])->before(' ');
            $hFin = Str::of($fecha["horarios"])->after('- ');
            $servicioTenisHoras = DB::select("SELECT servicio_tenis_horario_update(?,?,?,?,?,?,?);", [$idPlantillaConvert, $dia, $hInicio, $hFin, $nombre_usuario, $ip, $creacion]);
        }

        $respuestaHorarios = $servicioTenisHoras[0]->servicio_tenis_horario_update;
        $respuesta = Str::of($respuestaHorarios)->after(',')->before(')');

        return response()->json(['idPlantilla' => $idPlantillaConvert, 'idRegistro' => $idRegistroConvert, 'respRegistro' => $respuesta]);
    }
}
