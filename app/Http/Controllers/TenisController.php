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
use Illuminate\Support\Str;

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
    public function categoryCharge(string $id)
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
    public function placesCharge(string $id)
    {
        $lugares = Lugar::where('sede_id', $id)->get();
        if (count($lugares) == 0) {
            $lugares = "No existen lugares asocidas a la sede seleccionada, favor comunicarse con el administrador del sistema";
            return response()->json($lugares);
        } else {
            return response()->json($lugares);
        }
    }

    public function coastPlaces(string $idActividad, string $idLugar)
    {
        // $lugar_costo = DB::select("select id,descripcion,costohora as costo,tipo from 	public.lugar_costos
        //                         where tiposervicios_id=? and lugars_id = ?", [$idActividad, $idLugar]);
        $lugar_costo = DB::select("SELECT id,descripcion,costohora AS costo,tipo FROM 	public.lugar_costos
                                   WHERE tiposervicios_id=? AND lugars_id = ?
                                   UNION SELECT 0 AS id, 'AMBOS' AS descripcion,0 AS costo, 'V' AS tipo", [$idActividad, $idLugar]);
        return response()->json($lugar_costo);
    }

    // get member by document
    public function searchMember(string $document)
    {
        $findMember = Persona::where('documento', $document)->where('tipocategoria_id','<>',3)->where('tipocategoria_id','<>',4)->where('tipocategoria_id','<>',5)->get();
        if (count($findMember) <= 0) {
            $findMember = "Parece que el documento: $document no es de un miembro o no se encuentra registrado, favor de verificar que el documento ingresado sea correcto y corresponda a un miembro, luego volver a itentar";
            return response()->json($findMember);
        } else {
            return response()->json($findMember);
        }
    }

    public function renderImageForCategory(string $id)
    {
        $imagen = SubtipoServicio::where('id', $id)->select("imagen")->get();
        return response()->json($imagen[0]);
    }

    public function storeNewActivity(Request $request)
    {
        $responsable = $request->responsable;
        $actividad = $request->actividad;
        $categoria = $request->categoria;
        $sede = $request->sede;
        $lugar = $request->lugar;
        $fechaInicio = $request->fechaInicio." 00:00:00";
        $termino = $request->termino." 00:00:00";
        $cupos = $request->cupos;
        $horasActividad = $request->horasActividad;
        $turno = $request->turno;
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = $usuario[0]->nombres . " " . $usuario[0]->apepaterno . " " . $usuario[0]->apematerno;
        $ip = $request->ip();
        $created_at = new DateTime();
        $creacion = $created_at->format('Y-m-d H:i:s');
        $fechasDefinidas = $request->fechasDefinidas;

        $validation = Validator::make($request->all(),
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
            ]);

        if ($validation->fails()) {
            $error = $validation->errors();
            return response()->json(['error' => $error]);
        }

        $servicioTenisCrear = DB::select("SELECT servicio_tenis_crear(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",[$fechaInicio,$termino,$responsable,$actividad,$sede,$lugar,$cupos,2,$nombre_usuario,$ip,$creacion,$turno,$categoria,$horasActividad]);

        $idRespuesta = $servicioTenisCrear[0]->servicio_tenis_crear;

        $idPlantillaConvert = Str::of($idRespuesta)->after(',')->before(')');
        $idRegistroConvert = Str::of($idRespuesta)->before(',')->after('(');

        foreach ($fechasDefinidas as $fecha) {
            $dia = $fecha["dias"];
            $hInicio = Str::of($fecha["horarios"])->before(' ');
            $hFin = Str::of($fecha["horarios"])->after('- ');
            $servicioTenisHoras = DB::select("SELECT servicio_tenis_horario(?,?,?,?,?,?,?);",[$idPlantillaConvert,$dia,$hInicio,$hFin,$nombre_usuario,$ip,$creacion]);
        }

        $respuestaHorarios = $servicioTenisHoras[0]->servicio_tenis_horario;
        $respuesta = Str::of($respuestaHorarios)->after(',')->before(')');

        return response()->json(['idPlantilla'=>$idPlantillaConvert,'idRegistro'=>$idRegistroConvert,'respRegistro'=>$respuesta]);
    }

    public function redirectAfterCreateActivity(string $plantilla, string $registro)
    {
        $plantillaId = $plantilla;
        $registroId = $registro;

        $diasPorActividad = DB::select("select dia FROM servicioinscripcion_listardias(?);",[$registroId]);
        return view('pages.private.actividades.inscripciones.create-to-activity', compact('diasPorActividad','registro'));
    }

    public function getHoursForDay(string $idRegister,string $day){
        $hours = DB::select("select horarios FROM servicioinscripcion_listarhora(?,?)",[$idRegister,$day]);

        return response()->json($hours);
    }
}
