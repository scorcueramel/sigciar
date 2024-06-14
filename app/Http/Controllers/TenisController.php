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

class TenisController extends Controller
{
    // render view create new activity
    public function create(){
        $responsable = Persona::where('usuario_id',Auth::user()->id)->get()[0];
        $responsables = Persona::where('tipocategoria_id','<>',1)->where('tipocategoria_id','<>',2)->get();
        $actividades = TipoServicio::where('id','<>',1)->orderBy('descripcion','asc')->get();
        $sedes = Sede::where('estado','A')->get();

        $lastId = DB::select("SELECT MAX(id) FROM servicios");

        return view("pages.private.actividades.tenis.create",compact("responsable","responsables", "lastId","actividades","sedes"));
    }
    // get categories by id activity
    public function categoryCharge($id){
        $subtiposervicio = SubtipoServicio::where('tiposervicios_id',$id)->orderBy('id','desc')->get();

        if (count($subtiposervicio)==0){
            $subtiposervicio = "No existen categorías asocidas a la actividad seleccionada, favor comunicarse con el administrador del sistema";
            return response()->json($subtiposervicio);
        }else{
            return response()->json($subtiposervicio);
        }
    }
    // get category by idPlaces
    public function placesCharge($id){
        $lugares = Lugar::where('sede_id',$id)->get();

        if(count($lugares)==0){
            $lugares = "No existen lugares asocidas a la sede seleccionada, favor comunicarse con el administrador del sistema";
            return response()->json($lugares);
        }else{
            return response()->json($lugares);
        }
    }
    // get member by document
    public function searchMember($document){
        $findMember = Persona::where('documento',$document)->where('tipocategoria_id',2)->get();
        if(count($findMember)==0){
            $findMember = "Parece que el documento: $document no es de un miembro o no existe, favor de verificar que el documento ingresado sea correcto y corresponda a un miembro, luego volver a itentar";
            return response()->json($findMember);
        }else{
            return response()->json($findMember);
        }
    }
}
