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
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NutricionController extends Controller
{
    public function index()
    {
        return view("pages.private.actividades.nutricion.index");
    }

    public function renderCalendar()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $progrmasNutricion = DB::select("SELECT
                                            s.id ,ts.descripcion AS tipo_servicio , sts.titulo AS categoria,
                                            s.estado AS estado , s2.descripcion AS sede,s2.direccion AS direccion_sede,
                                            l.descripcion AS lugar_descripcion,l.costohora AS lugar_costo_hora,
                                            s.capacidad AS capacidad,s.inicio AS inicio,s.fin AS fin,s.horas AS hora,s.turno AS turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) AS responsable,
                                            ver_horarios (cast(s.id AS INTEGER)) AS horario
                                            FROM servicios s
                                            LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
                                            LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
                                            LEFT JOIN sedes s2 ON s.sede_id = s2.id
                                            LEFT JOIN lugars l ON s.lugar_id = l.id
                                            LEFT JOIN personas p ON s.responsable_id = p.id
                                            LEFT JOIN subtipo_servicios ss ON s.subtiposervicio_id = ss.id
                                            where s.deleted_at IS NULL AND s.tiposervicio_id = 2");

        return view("pages.private.actividades.nutricion.calendar", compact("progrmasNutricion","persona"));
    }

    public function programForDays(string $idprograma)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();

        if ($user->hasRole('ADMINISTRADOR')) {
            $disponibilidad = DB::select("SELECT DISTINCT
                                            sd.inicio as startTime,
                                            sd.fin as endTime,
                                            (case when substring(sd.dia,1,2) = 'DO' then 0
                                            when substring(sd.dia,1,2) = 'LU' then 1
                                            when substring(sd.dia,1,2) = 'MA' then 2
                                            when substring(sd.dia,1,2) = 'MI' then 3
                                            when substring(sd.dia,1,2) = 'JU' then 4
                                            when substring(sd.dia,1,2) = 'VI' then 5 else 6 end) as daysOfWeek
                                            FROM public.servicio_disponibles sd
                                            left join public.servicio_plantillas sp on sd.servicioplantilla_id = sp.id
                                            left join public.servicios s on sp.servicio_id = s.id
                                            left join public.tipo_servicios ts on s.tiposervicio_id = ts.id
                                            left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                            WHERE s.id = ? and s.estado= 'A';", [$idprograma]);
        } else {
            $disponibilidad = DB::select("SELECT DISTINCT
                                            sd.inicio as startTime,
                                            sd.fin as endTime,
                                            (case when substring(sd.dia,1,2) = 'DO' then 0
                                            when substring(sd.dia,1,2) = 'LU' then 1
                                            when substring(sd.dia,1,2) = 'MA' then 2
                                            when substring(sd.dia,1,2) = 'MI' then 3
                                            when substring(sd.dia,1,2) = 'JU' then 4
                                            when substring(sd.dia,1,2) = 'VI' then 5 else 6 end) as daysOfWeek
                                            FROM public.servicio_disponibles sd
                                            left join public.servicio_plantillas sp on sd.servicioplantilla_id = sp.id
                                            left join public.servicios s on sp.servicio_id = s.id
                                            left join public.tipo_servicios ts on s.tiposervicio_id = ts.id
                                            left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                            WHERE s.id = ? and s.estado= 'A'", [$persona[0]->id]);
        }
        return response()->json($disponibilidad);
    }

    public function getReservations(string $idservicio)
    {
        $reservas = [];
        $inscritos = DB::select("select pe.apepaterno || ' ' || pe.apematerno || ' ' || pe.nombres as title,
                                    si.id as servicioinscripcion_id,pe.movil,
                                    pe.movil, us.email, sts.titulo as categoria,
                                    sr.estado as estado_pago, s.id, s.tiposervicio_id, s.sede_id, s.lugar_id,
                                    s.capacidad, sr.inicio AS start, sr.fin AS end, s.estado
                                from servicio_reservas sr
                                left join servicio_plantillas sp on sr.servicioplantilla_id = sp.id
                                left join servicios s on sp.servicio_id = s.id
                                left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                left join servicio_inscripcions si on sr.servicioinscripcion_id = si.id
                                left join personas pe on si.persona_id = pe.id
                                left join users us on pe.usuario_id = us.id
                                WHERE s.id = ? --AND sr.estado= 'CA'", [$idservicio]);

        foreach ($inscritos as $inscrito) {
            $fecha = Str::before($inscrito->start, " ");
            $inicio = Str::after($inscrito->start, " ");
            $fin = Str::after($inscrito->end, " ");

            $sede = Sede::where('id', $inscrito->sede_id)->get()[0];

            $reservas[] = [
                'id' => $inscrito->id,
                'title' => $inscrito->title,
                'start' => $inscrito->start,
                'end' => $inscrito->end,
                'extendedProps' => [
                    'sede' => $sede->descripcion,
                    'lugar' => 'CONSULTORIO',
                    'categoria' => $inscrito->categoria,
                    'fecha' => $fecha,
                    'inicio' => $inicio,
                    'fin' => $fin,
                    'correo' => $inscrito->email,
                    'movil' => $inscrito->movil,
                    'servicioinscripcion' => $inscrito->servicioinscripcion_id,
                ],
            ];
        }
        return response()->json($reservas);
    }

    public function obtenerprecio()
    {
        $costohora = DB::select("SELECT
                                    l.costohora AS lugar_costo_hora,
                                    l.tipo AS tipo
                                FROM servicios s
                                    left join tipo_servicios ts ON s.tiposervicio_id = ts.id
                                    left join sedes s2 ON s.sede_id = s2.id
                                    left join lugars l ON s.lugar_id = l.id
                                    left join personas p ON s.responsable_id = p.id
                                    left join subtipo_servicios ss ON s.subtiposervicio_id = ss.id
                                WHERE s.deleted_at IS NULL AND s.tiposervicio_id = 2");
        return response()->json($costohora);
    }

    public function tableNutricion()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $tableNutrition = DB::select("SELECT
                                            s.id ,ts.descripcion AS tipo_servicio , sts.titulo AS categoria,
                                            s.estado AS estado , s2.descripcion AS sede,s2.direccion AS direccion_sede,
                                            l.descripcion AS lugar_descripcion,l.costohora AS lugar_costo_hora,
                                            s.capacidad AS capacidad,s.inicio AS inicio,s.fin AS fin,s.horas AS hora,s.turno AS turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) AS responsable,
                                            ver_horarios (cast(s.id AS INTEGER)) AS horario
                                            FROM servicios s
                                            LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
                                            LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
                                            LEFT JOIN sedes s2 ON s.sede_id = s2.id
                                            LEFT JOIN lugars l ON s.lugar_id = l.id
                                            LEFT JOIN personas p ON s.responsable_id = p.id
                                            LEFT JOIN subtipo_servicios ss ON s.subtiposervicio_id = ss.id
                                            where s.deleted_at IS NULL AND s.tiposervicio_id = 2");
        } else {
            $tableNutrition = DB::select("SELECT
                                            s.id ,ts.descripcion AS tipo_servicio , sts.titulo AS categoria,
                                            s.estado AS estado , s2.descripcion AS sede,s2.direccion AS direccion_sede,
                                            l.descripcion AS lugar_descripcion,l.costohora AS lugar_costo_hora,
                                            s.capacidad AS capacidad,s.inicio AS inicio,s.fin AS fin,s.horas AS hora,s.turno AS turno,
                                            concat(p.nombres ,' ' ,p.apepaterno ,' ' ,p.apematerno) AS responsable,
                                            ver_horarios (cast(s.id AS INTEGER)) AS horario
                                            FROM servicios s
                                            LEFT JOIN tipo_servicios ts ON s.tiposervicio_id = ts.id
                                            LEFT JOIN subtipo_servicios sts ON s.subtiposervicio_id = sts.id
                                            LEFT JOIN sedes s2 ON s.sede_id = s2.id
                                            LEFT JOIN lugars l ON s.lugar_id = l.id
                                            LEFT JOIN personas p ON s.responsable_id = p.id
                                            LEFT JOIN subtipo_servicios ss ON s.subtiposervicio_id = ss.id
                                            where s.deleted_at IS NULL AND s.tiposervicio_id = 2 AND responsable_id = ?", [$persona[0]->id]);

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

    // store new member to program nutrition
    public function inscriptionToProgram(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = $persona[0]->nombres . " " . $persona[0]->apepaterno . " " . $persona[0]->apematerno;
        $servicioId = $request->idservicio;
        $fechaDefinida = $request->fecha;
        $horainicio = $request->hora_inicio;
        $horafin = $request->hora_fin;
        $preciocita = Str::before(Str::after($request->precio_cita, '.'), '.');
        $usuarioId = $request->id_miembro;
        $ip = $request->ip();

        DB::select("SELECT servicio_inscripcionunico(?,?,?,?,?,?,?,?)", [$servicioId, $usuarioId, $fechaDefinida, $horainicio, $horafin, $usuarioActivo, $ip, $preciocita]);

        return back()->with(['success' => 'La cita se registro exitosamente, selecciona el programa para ver los detalles.']);
    }

    public function disponibilidadDias()
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        if ($user->hasRole('ADMINISTRADOR')) {
            $dispobilidad = DB::select("SELECT
                                            sd.inicio as startTime,
                                            sd.fin as endTime,
                                            (case when substring(sd.dia,1,2) = 'DO' then 0
                                                when substring(sd.dia,1,2) = 'LU' then 1
                                                when substring(sd.dia,1,2) = 'MA' then 2
                                                when substring(sd.dia,1,2) = 'MI' then 3
                                                when substring(sd.dia,1,2) = 'JU' then 4
                                                when substring(sd.dia,1,2) = 'VI' then 5 else 6 end) as daysOfWeek
                                        FROM servicio_disponibles sd
                                            left join servicio_plantillas sp on sd.servicioplantilla_id = sp.id
                                            left join servicios s on sp.servicio_id = s.id
                                        WHERE s.tiposervicio_id = 2 and s.estado= 'A';");
        } else {
            $dispobilidad = DB::select("SELECT
                                            sd.inicio as startTime,
                                            sd.fin as endTime,
                                            (
                                                case
                                                    when substring(sd.dia, 1, 2) = 'DO' then 0
                                                    when substring(sd.dia, 1, 2) = 'LU' then 1
                                                    when substring(sd.dia, 1, 2) = 'MA' then 2
                                                    when substring(sd.dia, 1, 2) = 'MI' then 3
                                                    when substring(sd.dia, 1, 2) = 'JU' then 4
                                                    when substring(sd.dia, 1, 2) = 'VI' then 5
                                                    else 6
                                                end
                                            ) as daysOfWeek
                                        FROM servicio_disponibles sd
                                            left join servicio_plantillas sp on sd.servicioplantilla_id = sp.id
                                            left join servicios s on sp.servicio_id = s.id
                                        WHERE
                                            tiposervicio_id = 2
                                            and s.estado = 'A'
                                            and s.responsable_id = ?;", [$persona[0]->id]);
        }
        return response()->json($dispobilidad);
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
        $subtiposervicios = SubtipoServicio::where('estado', 'A')->where('tiposervicio_id',2)->get();

        return view("pages.private.actividades.nutricion.create", compact("responsable", "responsables", "sedes", "subtiposervicios"));
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
        // $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	lugar_costos
        //                         where tiposervicios_id=? and lugars_id = ?", [$idActividad, $idLugar]);
        $lugar_costo = DB::select("SELECT id,descripcion,costohora AS costo,tipo FROM 	lugar_costos
                                   WHERE tiposervicios_id=? AND lugars_id = ?", [$idActividad, $idLugar]);
        return response()->json($lugar_costo);
    }

    // store new program nutrition
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
        $actividad->estado = 'A';
        $actividad->save();
        $actividad->delete();
        return redirect()->back()->with('success', 'El programa de nutrición fue eliminada');
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

    public function getNotesMember($idService){
        $findNote = DB::select("SELECT si.id ,si.servicioinscripcion_id ,si.detalle, si.adjuntto ,p.nombres ,p.apepaterno ,p.apematerno ,p.usuario_id ,si.privado ,si.created_at
                                FROM servicio_informes si
                                LEFT JOIN servicio_inscripcions si2
                                ON si.servicioinscripcion_id = si2.id
                                LEFT JOIN personas p
                                ON si2.persona_id = p.id
                                WHERE si.servicioinscripcion_id = ?",[$idService]);
        return response()->json($findNote);
    }

    public function editNote($idNota){
        $noteById = DB::select("SELECT
                                    si.id ,si.servicioinscripcion_id ,si.detalle, si.adjuntto ,p.nombres ,p.apepaterno ,p.apematerno ,p.usuario_id
                                FROM servicio_informes si
                                LEFT JOIN servicio_inscripcions si2
                                ON si.servicioinscripcion_id = si2.id
                                LEFT JOIN personas p
                                ON si2.persona_id = p.id
                                WHERE si.id = ?",[$idNota]);
        return response()->json($noteById);
    }

    public function updateNote(Request $request){
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = "{$usuario[0]->nombres} {$usuario[0]->apepaterno} {$usuario[0]->apematerno}";
        $nota = ServicioInforme::find($request->id);

        $nota->detalle = $request->nota;
        $nota->adjuntto = $request->enlace;
        $nota->estado = 'A';
        $nota->usuario_editor = $nombre_usuario;
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
}
