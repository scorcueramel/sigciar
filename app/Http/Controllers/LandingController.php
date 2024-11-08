<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Promesa;
use App\Models\Sede;
use App\Models\Servicio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
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
    public function renderTorneos(){
        return view('pages.public.landing.torneos.torneos');
    }
    //END SECTION TORNEOS

    //SECTION ACTIVITY
    public function activities()
    {
        $actividades = DB::select("select distinct
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

    public function activitiesDetails(string $id)
    {
        // pendiente de recibir la vista detalle de actividad
    }
    //END SECTION ACTIVITY

    // SECTION PROMISES
    public function promises()
    {
        $promesas = Promesa::all();
        $noticiaPromesas = DB::select("SELECT * FROM noticias n WHERE n.categoria_id = 1 ORDER BY id DESC LIMIT 1;");
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
