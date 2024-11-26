<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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

        $dataresponse = DB::select("SELECT * FROM grafico_inscritos(2024);");

        $datareplace = substr($dataresponse[0]->grafico_inscritos, 7, -1) . "}";

        $dataGrafico = json_decode($datareplace, true);

        return view('pages.private.dashboard.index', compact('authenticate', 'personalInfo', 'dataGrafico'));
    }

    public function detalleNotificacion(string $id)
    {
        $notificacionDetalle = DB::select("SELECT
                                                n.id as notif_id, n.servicio_id, p.nombres || ' ' || p.apepaterno || ' ' || p.apematerno as nombre_miembro,
                                                n.fecha_hora_registro, se.descripcion as sede, lu.descripcion as lugar, s.inicio, s.fin, ss.titulo
                                            FROM notificaciones n
                                            LEFT JOIN servicios s ON s.id = n.servicio_id
                                            LEFT JOIN tipo_servicios ts ON ts.id = s.tiposervicio_id
                                            LEFT JOIN subtipo_servicios ss ON ss.id = s.subtiposervicio_id
                                            LEFT JOIN users u ON n.miembro_id = u.id
                                            LEFT JOIN personas p ON p.usuario_id = u.id
                                            LEFT JOIN sedes se ON se.id = s.sede_id
                                            LEFT JOIN lugars lu ON lu.id = s.lugar_id
                                            WHERE n.id = ? AND u.id = ? AND n.leido = FALSE", [$id, Auth::id()]);
        return response()->json($notificacionDetalle);
    }

    public function quitarNotificacion(string $id)
    {
        DB::select("UPDATE notificaciones n SET leido = true WHERE n.id = ?", [$id]);
        return response()->json('ok');
    }

    public function quitarTodasNotificaciones()
    {
        $notificaciones = DB::select("SELECT
                                            n.id as notif_id, n.servicio_id, p.nombres || ' ' || p.apepaterno || ' ' || p.apematerno as nombre_miembro,
                                            n.fecha_hora_registro, se.descripcion as sede, lu.descripcion as lugar, s.inicio, s.fin, ss.titulo
                                        FROM notificaciones n
                                        LEFT JOIN servicios s ON s.id = n.servicio_id
                                        LEFT JOIN tipo_servicios ts ON ts.id = s.tiposervicio_id
                                        LEFT JOIN subtipo_servicios ss ON ss.id = s.subtiposervicio_id
                                        LEFT JOIN users u ON n.miembro_id = u.id
                                        LEFT JOIN personas p ON p.usuario_id = u.id
                                        LEFT JOIN sedes se ON se.id = s.sede_id
                                        LEFT JOIN lugars lu ON lu.id = s.lugar_id
                                        WHERE u.id = ? AND n.leido = FALSE", [Auth::id()]);

        foreach ($notificaciones as $ntf) {
            dd($ntf->id);
            DB::select("UPDATE notificaciones n SET leido = true WHERE n.id = ?", [$ntf->id]);
        }

        return response()->json('ok');
    }

    public function activities()
    {

        $activities = DB::select("select distinct s.id, ts.descripcion || ' - ' || coalesce(sts.titulo,'') || ' - ' || coalesce(l.descripcion,'') as title,
                                        sp.inicio as start,
                                        sp.fin as end
                                    from servicio_plantillas sp
                                    left join servicios s on sp.servicio_id = s.id
                                    left join tipo_servicios ts on ts.id = s.tiposervicio_id
                                    left join subtipo_servicios sts on s.subtiposervicio_id = sts.id
                                    left join lugars l on s.lugar_id= l.id");

        return response()->json($activities);
    }
}
