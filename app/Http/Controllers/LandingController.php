<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use App\Models\Sede;
use App\Models\Servicio;
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
                                    servicios.id as servicios_id,
                                    servicios.created_at as created_at,
                                    subtipo_servicios.medicion,
                                    subtipo_servicios.titulo,
                                    subtipo_servicios.subtitulo,
                                    subtipo_servicios.imagen,
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
                                    and servicios.estado= 'A'
                                    order by created_at
                                    limit 5");
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

        return view("pages.public.landing.index", compact("sedes", "actividades", "noticias"));
    }

    //SECTION ACTIVITY
    public function activities()
    {
        $actividades = DB::select("select distinct
                    servicios.id as servicios_id,
                    servicios.created_at as created_at,
                    subtipo_servicios.medicion,
                    subtipo_servicios.titulo,
                    subtipo_servicios.subtitulo,
                    subtipo_servicios.imagen,
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
        return view("pages.public.landing.promises");
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
    public function activityStarts()
    {
        $activitystarts = DB::select("select distinct
        servicios.id as servicios_id,
        servicios.created_at as created_at,
        subtipo_servicios.medicion,
        subtipo_servicios.titulo,
        subtipo_servicios.subtitulo,
        subtipo_servicios.imagen,
        lugar_costos.costohora as desde
        from servicios
        left join public.tipo_servicios  on servicios.tiposervicio_id = tipo_servicios.id
        left join public.subtipo_servicios on servicios.subtiposervicio_id = subtipo_servicios.id
        left join public.sedes on servicios.sede_id = sedes.id
        left join public.lugars on servicios.lugar_id = lugars.id
        left join public.lugar_costos on lugar_costos.lugars_id = lugars.id  and lugar_costos.descripcion = 'DIURNO'
        left join public.servicio_plantillas on servicios.id = servicio_plantillas.servicio_id
        where subtipo_servicios.titulo  is not null
        and tipo_servicios.id = 2
        and servicios.estado= 'A'");

        return view("pages.public.landing.actividades.", compact("activitystarts"));
    }
    // END SECTION ACTIVITY-STARTS
}
