<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;

class LandingController extends Controller
{
    //
    public function index(){
        $sedes = Sede::where('estado','A')->orderBy('id','asc')->get();
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

        return view("pages.public.landing.index",compact("sedes","actividades"));
    }

    //SECTION ACTIVITY
    public function activities(){
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

        return view("pages.public.landing.activities",compact("actividades"));
    }
    //END SECTION ACTIVITY

    public function promises(){
        return view("pages.public.landing.promises");
    }

    public function news(){
        return view("pages.public.landing.news");
    }
}
