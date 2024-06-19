<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use App\Models\SubtipoServicio;
use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DateTime;

class TenisController extends Controller
{
    // render view create new activity
    public function create()
    {
        // Obtener quien esta autenticado
        $responsable = Persona::where('usuario_id', Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id', '<>', 1)->where('tipocategoria_id', '<>', 2)->get();
        $actividades = TipoServicio::where('id', '<>', 1)->orderBy('descripcion', 'asc')->get();
        $sedes = Sede::where('estado', 'A')->get();

        return view("pages.private.actividades.tenis.create", compact("responsable", "responsables", "actividades", "sedes"));
    }

    // get categories by id activity
    public function categoryCharge($id)
    {
        $subtiposervicio = SubtipoServicio::where('tiposervicios_id', $id)->orderBy('id', 'desc')->get();

        if (count($subtiposervicio) == 0) {
            $subtiposervicio = "No existen categorías asocidas a la actividad seleccionada, favor comunicarse con el administrador del sistema";
            return response()->json($subtiposervicio);
        } else {
            return response()->json($subtiposervicio);
        }
    }
    // get category by idPlaces
    public function placesCharge($id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
        if (count($lugares) == 0) {
            $lugares = "No existen lugares asocidas a la sede seleccionada, favor comunicarse con el administrador del sistema";
            return response()->json($lugares);
        } else {
            return response()->json($lugares);
        }
    }

    public function coastPlaces($idActividad, $idLugar)
    {
        // $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	public.lugar_costos
        //                         where tiposervicios_id=? and lugars_id = ?", [$idActividad, $idLugar]);
        $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	public.lugar_costos
                                   where tiposervicios_id=? and lugars_id = ?
                                   union
                                   select 0 as id, 'AMBOS' as descripcion,0 as costo, 'V' as tipo", [$idActividad, $idLugar]);
        return response()->json($lugar_costo);
    }

    // get member by document
    public function searchMember($document)
    {
        $findMember = Persona::where('documento', $document)->where('tipocategoria_id', 2)->get();
        if (count($findMember) <= 0) {
            $findMember = "Parece que el documento: $document no es de un miembro o no se encuentra registrado, favor de verificar que el documento ingresado sea correcto y corresponda a un miembro, luego volver a itentar";
            return response()->json($findMember);
        } else {
            return response()->json($findMember);
        }
    }

    public function renderImageForCategory($id){
        $imagen = SubtipoServicio::where('id',$id)->select("imagen")->get();
        return response()->json($imagen[0]);
    }

    public function storeNewActivity(Request $request)
    {
        $responsable = $request->responsable;
        $actividad = $request->actividad;
        $categoria = $request->categoria;
        $sede = $request->sede;
        $lugar = $request->lugar;
        $fechaInicio = $request->fechaInicio;
        $termino = $request->termino;
        $cupos = $request->cupos;
        $horasActividad = $request->horasActividad;
        $turno = $request->turno;
        $usuario = Persona::where('usuario_id',Auth::user()->id)->get();
        $usuario_creador = $usuario[0]->nombres." ".$usuario[0]->apepaterno." ".$usuario[0]->apematerno;
        $ip = $request->ip();
        $created_at = new DateTime();
        $creacion = $created_at->format('Y-m-d H:i:s');

        $validation = Validator::make($request->all(), [
            'actividad' => 'required',
            'categoria' => 'required',
            'sede' => 'required',
            'lugar' => 'required',
            'fechaInicio' => 'required',
            'termino' => 'required',
            'cupos' => 'required',
            'horasActividad' => 'required',
        ], [
            'actividad.required' => 'Porfavor selecciona una actividad',
            'categoria.required' => 'Porfavor selecciona una categoría',
            'sede.required' => 'Porfavor selecciona una sede',
            'lugar.required' => 'Porfavor selecciona un lugar',
            'fechaInicio.required' => 'Porfavor ingresa una fecha de inicio',
            'termino.required' => 'Porfavor ingresa una fecha de termino',
            'cupos.required' => 'Porfavor ingresa la cantidad de cupos',
            'horasActividad.required' => 'Porfavor indica las horas por actividad',
        ]);

        if ($validation->fails()) {
            $error = $validation->errors();
            return response()->json(['error' => $error]);
        }

        return response()->json($resp = 'ok');

        // $servicioTenisCrear = DB::select("SELECT servicio_tenis_crear($fechaInicio,$termino,$responsable,$actividad,$sede,$lugar,$cupos,2,$usuario_creador,$ip,$creacion,$turno)");

        // dd($servicioTenisCrear);

        // $servicioTenisHoras = DB::select("SELECT servicio_tenis_horario(:p_servicioplantilla_id, :p_dia, :p_horas, :p_desde, :p_hasta, :p_usuario_creador, :p_ip_usuario, :p_created_at);");

    }

    public function redirectAfterCreateActivity(){
        return view('pages.private.actividades.inscripciones.create-to-activity');
    }
}
