<?php

namespace App\Http\Controllers;

use App\Jobs\SendTestMail;
use App\Models\Noticia;
use App\Models\Persona;
use App\Models\Promesa;
use App\Models\Sede;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    //
    public function index()
    {
        $sedes = Sede::where('estado', 'A')->orderBy('id', 'asc')->get();
        $actividades = DB::select("select distinct
                                    tipo_servicios.id as tiposervicios_id,
                                    subtipo_servicios.id as subtiposervicios_id,
                                    subtipo_servicios.medicion,
                                    subtipo_servicios.titulo,
                                    subtipo_servicios.subtitulo,
                                    subtipo_servicios.imagen,
                                    (lugar_costos.costohora * 4) as desde
                                    from servicios
                                    left join public.tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
                                    left join public.subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
                                    left join public.sedes on servicios.sede_id = sedes.id
                                    left join public.lugars on servicios.lugar_id = lugars.id
                                    left join public.lugar_costos on lugar_costos.lugars_id = lugars.id
                                    left join public.servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
                                    where subtipo_servicios.titulo is not null
                                    and tipo_servicios.id = 3
                                    and servicios.estado = 'A'");


        $noticias = Noticia::leftJoin('categoria_noticias', 'categoria_noticias.id', '=', 'noticias.categoria_id')
            ->select(
                "noticias.id as noticia_id",
                "categoria_noticias.nombre as nombre",
                "categoria_noticias.id as categoria_id",
                "noticias.titulo as titulo",
                "noticias.extracto as extracto",
                "noticias.cuerpo as cuerpo",
                "noticias.estado as estado",
                "noticias.imagen_destacada as imagen_destacada",
                "noticias.slug as slug"
            )
            ->where('noticias.estado', '=', 'A')
            ->get();
        $activitystarts = DB::select("SELECT DISTINCT
                                        servicios.id AS servicios_id,
                                        subtipo_servicios.medicion,
                                        subtipo_servicios.titulo,
                                        subtipo_servicios.subtitulo,
                                        subtipo_servicios.imagen,
                                        lugar_costos.costohora AS desde
                                        FROM servicios
                                        LEFT JOIN public.tipo_servicios ON servicios.tiposervicio_id = tipo_servicios.id
                                        LEFT JOIN public.subtipo_servicios ON servicios.subtiposervicio_id = subtipo_servicios.id
                                        LEFT JOIN public.sedes ON servicios.sede_id = sedes.id
                                        LEFT JOIN public.lugars ON servicios.lugar_id = lugars.id
                                        LEFT JOIN public.lugar_costos ON lugar_costos.lugars_id = lugars.id AND lugar_costos.descripcion = 'DIURNO'
                                        LEFT JOIN public.servicio_plantillas ON servicios.id = servicio_plantillas.servicio_id
                                        WHERE subtipo_servicios.titulo IS NOT NULL
                                        AND tipo_servicios.id NOT IN (1,3)
                                        AND servicios.estado= 'A'");

        $entrenadores = DB::select("SELECT
                                    CONCAT(p.nombres,' ',p.apepaterno,' ',p.apematerno) AS nombres,
                                    p.directorio ,p.imagen
                                    FROM model_has_roles mhr
                                    LEFT JOIN users u
                                    ON u.id = mhr.model_id
                                    LEFT JOIN personas p
                                    ON p.usuario_id = u.id
                                    WHERE mhr.role_id = 4");
        $promesas = Promesa::all();

        return view("pages.public.landing.index", compact("sedes", "actividades", "noticias", "activitystarts", "entrenadores", "promesas"));
    }

    //SECTION TORNEOS
    public function renderTorneos()
    {
        return view('pages.public.landing.torneos.torneos');
    }
    //END SECTION TORNEOS

    //SECTION PROGRAM INSCRIPTONS

    public function generatePreInscriptcion(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = $persona[0]->nombres . " " . $persona[0]->apepaterno . " " . $persona[0]->apematerno;
        $servicioId = $request->idservicio;
        $fechasDefinias = json_encode($request->fechasDefinidas);
        $usuarioId = $request->idmiembro;
        $ip = $request->ip();
        $montoTotal = $request->montoTotal;
        $nombrePrograma = $request->nombrePrograma;

        $request->validate([
            'idplantilla',
            'idmiembro',
            'fechasDefinidas'
        ]);

        $codigo = Str::random(20);

        DB::select("INSERT INTO inscripcion_temporal
                    (usuario_activo, servicio_id, fechas_definidas, usuario_id, ip_cliente, monto_total, nombre_programa, codigo)
                    VALUES(?,?,?,?,?,?,?,?);", [$usuarioActivo, $servicioId, $fechasDefinias, $usuarioId, $ip, $montoTotal, $nombrePrograma, $codigo]);

//        return response()->json($codigo);
        $this->redirectToPagePayment($codigo);
    }

    public function redirectToPagePayment(string $codigo)
    {
        $registroPayment = DB::select("SELECT * FROM inscripcion_temporal WHERE codigo = ?;",[$codigo]);

        $auth = base64_encode(config("services.izipay.client_id") . ":" . config("services.izipay.client_secret"));

        $response = Http::withHeaders([
            "Authorization" => "Basic $auth",
            "Content-Type" => "application/json"
        ])->post(config('services.izipay.url'), [
            'amount' => "{$registroPayment[0]->monto_total}00",
            'currency' => 'USD',
            'orderId' => "Inscripcion a programa",
            'customer' => [
                'email' => Auth::user()->email
            ]
        ])->json();

        $formToken = $response['answer']['formToken'];

        return view('pages.public.inscription.inscription-payment',compact('registroPayment','formToken'));
    }

    private function authenticateToken()
    {
        return base64_encode(config("services.niubiz.user") . ':' . config("services.niubiz.password"));
    }

    public function generateTokenProgramsNiubiz(Request $request)
    {
        $user = Auth::user();
        $persona = Persona::where('usuario_id', $user->id)->get();
        $usuarioActivo = $persona[0]->nombres . " " . $persona[0]->apepaterno . " " . $persona[0]->apematerno;
        $servicioId = $request->idservicio;
        $fechasDefinias = json_encode($request->fechasDefinidas);
        $usuarioId = $request->idmiembro;
        $ip = $request->ip();
        $montoTotal = $request->montoTotal;
        $nombrePrograma = $request->nombrePrograma;

        $request->validate([
            'idplantilla',
            'idmiembro',
            'fechasDefinidas'
        ]);

        $codigo = Str::random(10);

        $auth = $this->authenticateToken();

        $accessToken = Http::withHeaders([
            'Authorization' => "Basic $auth"
        ])->get(config("services.niubiz.url_api") . '/api.security/v1/security')->body();

        $sessionTonken = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $accessToken
        ])->post(config("services.niubiz.url_api") . "/api.ecommerce/v2/ecommerce/token/session/" . config('services.niubiz.merchant_id'), [
                "channel" => "web",
                "amount" => $montoTotal,
                "antifraud" => [
                    "clientIp" => $request->ip(),
                    "merchantDefineData" => [
                        "MDD4" => Auth::user()->email,
                        "MDD21" => 0,
                        "MDD32" => Auth::user()->email, //puedo utilizarl el correo siempre y cuando no se repita o el dni o el id
                        "MDD75" => "Registrado",
                        "MDD77" => now()->diffInDays(auth()->user()->created_at) + 1
                    ]
                ],
                "dataMap" => [
                    "cardholderCity" => "Lima",
                    "cardholderCountry" => "PE",
                    "cardholderAddress" => "Av Jose Pardo 831",
                    "cardholderPostalCode" => "12345",
                    "cardholderState" => "LIM",
                    "cardholderPhoneNumber" => "987654321"
                ]
            ])->json();

        $tokenSession = $sessionTonken["sessionKey"];

        $obtenerResponsable = DB::select("SELECT usr.email, per.nombres || ' ' || per.apepaterno || ' ' || per.apematerno as nombre_persona FROM servicios ser LEFT JOIN personas per ON per.id = ser.responsable_id LEFT JOIN users usr ON usr.id = per.usuario_id WHERE ser.id = ?;",[$servicioId])[0];


        DB::select("INSERT INTO inscripcion_temporal
                    (usuario_activo, servicio_id, fechas_definidas, usuario_id, ip_cliente, monto_total, nombre_programa, codigo, email_responsable_programa, nombre_responsable)
                    VALUES(?,?,?,?,?,?,?,?,?,?);", [$usuarioActivo, $servicioId, $fechasDefinias, $usuarioId, $ip, $montoTotal, $nombrePrograma, $codigo, $obtenerResponsable->email, $obtenerResponsable->nombre_persona]);

        return response()->json(['tokenSession'=>$tokenSession,'codigo'=>$codigo]);
    }

    public function inscribirProgramaMiembro(int $programaid, string $programatitulo)
    {
        $tipoDocs = TipoDocumento::where('estado', 'A')->get();

        $programaResponse = DB::select("SELECT DISTINCT
                                            servicios.id AS servicios_id,
                                            subtipo_servicios.medicion,
                                            subtipo_servicios.titulo,
                                            subtipo_servicios.subtitulo,
                                            subtipo_servicios.imagen,
                                            sedes.descripcion as sede,
                                            lugars.descripcion,
                                            ver_horarios (cast(servicios.id as integer)) as horario,
                                            lugar_costos.costohora
                                        FROM servicios
                                                 LEFT JOIN public.tipo_servicios ON servicios.tiposervicio_id = tipo_servicios.id
                                                 LEFT JOIN public.subtipo_servicios ON servicios.subtiposervicio_id = subtipo_servicios.id
                                                 LEFT JOIN public.sedes ON servicios.sede_id = sedes.id
                                                 LEFT JOIN public.lugars ON servicios.lugar_id = lugars.id
                                                 LEFT JOIN public.lugar_costos ON lugar_costos.lugars_id = lugars.id --AND lugar_costos.descripcion = 'DIURNO'
                                                 LEFT JOIN public.servicio_plantillas ON servicios.id = servicio_plantillas.servicio_id
                                        WHERE tipo_servicios.id = ? and titulo = ?", [$programaid, $programatitulo]);

        return view('pages.public.inscription.programa-inscripcion', compact('programaResponse', 'tipoDocs'));
    }
    //END SECTION PROGRAM INSCRIPTONS

    //SECTION ACTIVITY
    public function activities()
    {
        $actividades = DB::select("select distinct
                                            tipo_servicios.id as tiposervicio_id,
                                            subtipo_servicios.medicion,
                                            subtipo_servicios.titulo,
                                            subtipo_servicios.subtitulo,
                                            subtipo_servicios.imagen,
                                            case when tipo_servicios.id=3 then (lugar_costos.costohora * 4) else lugar_costos.costohora end as desde
                                            from servicios
                                            left join public.tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
                                            left join public.subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
                                            left join public.sedes on servicios.sede_id = sedes.id
                                            left join public.lugars on servicios.lugar_id = lugars.id
                                            left join public.lugar_costos on lugar_costos.lugars_id = lugars.id and lugar_costos.estado= 'A'
                                            left join public.servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
                                            where subtipo_servicios.titulo  is not null
                                            and tipo_servicios.id <> 1
                                            and servicios.estado= 'A'
                                            order by subtipo_servicios.medicion;");

        return view("pages.public.landing.actividades.activities", compact("actividades"));
    }

    public function getHoursForDay(string $idServicio, string $day)
    {
        $hours = DB::select("SELECT horarios FROM servicioinscripcion_listarhora(?,?);", [$idServicio, $day]);
        return response()->json($hours);
    }

    //get days by activities, IN THIS FUNCTION GETTER THE SUBCATEGORIA, PREPARETE QUERY FOR DAYS IS REGISTERED ON THIS CATEGORY
    public function getDaysActivity(string $idactivity)
    {
        $diasPorActividad = DB::select("SELECT dia FROM servicioinscripcion_listardias(?);", [$idactivity]);
        return response()->json($diasPorActividad);
    }

    public function activitiesDetails(string $id)
    {
        // pendiente de recibir la vista detalle de actividad
    }
    //END SECTION ACTIVITY

    // SECTION PROMISES
    public function promises()
    {
        $promesas = Promesa::all();
        $noticiaPromesas = DB::select("SELECT * FROM noticias n WHERE n.categoria_id = 1 AND n.estado = 'A' ORDER BY id DESC LIMIT 1;");
        return view("pages.public.landing.promises", compact('promesas', 'noticiaPromesas'));
    }

    public function promisesDetails(string $id)
    {
        $promesa = Promesa::find($id);
        return view("pages.public.landing.promesas.promesa-detalle", compact("promesa"));
    }
    // END SECTION PROMISES

    // SECTION NEWS
    public function news(Request $request)
    {
        $buscar = Str::lower($request->buscar);
        $noticias = Noticia::leftJoin('categoria_noticias', 'categoria_noticias.id', '=', 'noticias.categoria_id')
            ->select(
                "noticias.id as noticia_id",
                "categoria_noticias.nombre as nombre",
                "categoria_noticias.id as categoria_id",
                "noticias.titulo as titulo",
                "noticias.extracto as extracto",
                "noticias.cuerpo as cuerpo",
                "noticias.estado as estado",
                "noticias.imagen_destacada as imagen_destacada",
                "noticias.slug as slug"
            )
            ->where('noticias.estado', '=', 'A')
            ->where('noticias.titulo', 'LIKE', '%' . $buscar . '%')
            ->orderBy('estado', 'asc')
            ->paginate(9);
        return view("pages.public.landing.news", compact("noticias", "buscar"));
    }

    public function newsDetails(string $slug)
    {
        $noticiaObtenida = Noticia::leftJoin('categoria_noticias', 'categoria_noticias.id', '=', 'noticias.categoria_id')
            ->select(
                "noticias.id as noticia_id",
                "categoria_noticias.nombre as nombre",
                "categoria_noticias.id as categoria_id",
                "noticias.titulo as titulo",
                "noticias.extracto as extracto",
                "noticias.cuerpo as cuerpo",
                "noticias.estado as estado",
                "noticias.imagen_destacada as imagen_destacada",
                "noticias.slug as slug"
            )
            ->where('noticias.slug', '=', $slug)
            ->get();

        $noticia = $noticiaObtenida[0];
        $catNoti = $noticia->categoria_id;

        $noticiasCategoria = Noticia::where('categoria_id', $catNoti)->where('estado', 'A')->where('id', '<>', $noticia->noticia_id)->select("imagen_destacada", "titulo", "slug")->take(8)->get();

        return view("pages.public.landing.noticias.new-datail", compact("noticia", "noticiasCategoria"));
    }
    // END SECTION NEW

    // SECTION ACTIVITY-STARTS

    // END SECTION ACTIVITY-STARTS
}
