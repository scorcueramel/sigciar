<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Obtener el rol del usuario para mostrar en el navbar
    public function index()
    {
        $authenticate = false;
        $personalInfo = null;

        if (Auth::check()) {
            $authenticate = true;
            $personalInfo = Persona::where('usuario_id', Auth::user()->id)->select('id', 'nombres', 'apepaterno', 'apematerno')->get();
        }

        return view('pages.private.dashboard.index', compact('authenticate','personalInfo'));
    }

    public function activities(){

            $activities = DB::select("select s.id, ts.descripcion || ' - ' || coalesce(sts.titulo,'') || ' - ' || coalesce(l.descripcion,'') as title,
                                        sp.inicio as start,
                                        sp.fin as end
                                      from public.servicio_plantillas sp
                                      left join public.servicios s on sp.servicio_id = s.id
                                      left join public.tipo_servicios ts on ts.id = s.tiposervicio_id
                                      left join public.subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                      left join public.lugars l on s.lugar_id= l.id");

        return response()->json($activities);
    }
}
