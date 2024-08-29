<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Lugar;
use App\Models\Persona;
use App\Models\Sede;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LugaresController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:ver.lugares|crear.lugares|editar.lugares|eliminar.lugares', ['only' => ['index']]);
        $this->middleware('permission:crear.lugares', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar.lugares', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estado.lugares', ['only' => ['changeState']]);
        $this->middleware('permission:eliminar.lugares', ['only' => ['destroy']]);
    }
    protected function getUserLoginData(){
        $userData = Persona::where('usuario_id',Auth::user()->id)->first();
        $nombres = $userData->nombres." ".$userData->apepaterno." ".$userData->apematerno;
        return $nombres;
    }

    public function index()
    {
        //
        $headerTable = Lugar::select('id', 'descripcion', 'abreviatura', 'costohora', 'estado', 'tipo', 'sede_id')->first()->toArray();
        $keysLugar = [$keys, $values] = Arr::divide($headerTable)[0];
        $endHeaders = count($keysLugar);
        $lugaresHeader = Arr::add($keysLugar, $endHeaders, 'Acciones');
        $lugaresBody = Lugar::join('sedes','sedes.id','=','lugars.sede_id')->select('lugars.id', 'lugars.descripcion', 'lugars.abreviatura', 'lugars.costohora', 'lugars.estado', 'lugars.tipo', 'lugars.sede_id as sedeid','sedes.descripcion as sede')->orderBy('sedeid','asc')->paginate(5);

        return view("pages.private.espacios.lugares.index", compact("lugaresHeader", "lugaresBody"));
    }

    public function create()
    {
        //
        $sedes = Sede::where('estado','A')->get();
        return view("pages.private.espacios.lugares.create", compact('sedes'));
    }

    public function store(Request $request)
    {
        //
        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'costohora' => ['required'],
            'tipo' => ['required'],
            'estado' => ['required'],
            'sede_id' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'costohora.required' => 'El campo costo hora es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'estado.required' => 'El campo estado es obligatorio',
            'sede_id.required' => 'El campo sede es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $lugar = new Lugar();
        $lugar->descripcion = Str::upper($request->descripcion);
        $abreviatura = Str::upper(Str::of($request->descripcion)->substr(0, 2));
        $lugar->abreviatura = Str::upper($abreviatura);
        $lugar->costohora = Str::upper($request->costohora);
        $lugar->tipo = Str::upper($request->tipo);
        $lugar->estado = Str::upper($request->estado);
        $lugar->usuario_creador = $this->getUserLoginData();
        $lugar->usuario_editor = $this->getUserLoginData();
        $lugar->ip_usuario = \request()->ip();
        $lugar->sede_id = $request->sede_id;

        $lugar->save();

        $nombrelugar = $lugar->descripcion;

        return redirect()->route('lugares.index')->with('success', "El lugar $nombrelugar fue registrada exitosamente!");
    }

    public function show($id)
    {
        //
    }

    public function changeState(Request $request)
    {
        $lugar = Lugar::find($request->id);
        if ($lugar->estado == "I") {
            $lugar->estado = "A";
            $nombreLugar = $lugar->descripcion;
            $lugar->save();
            return back()->with(["success" => "La sede $nombreLugar fue ACTIVADA"]);
        }
        if ($lugar->estado == "A") {
            $lugar->estado = "I";
            $nombreLugar = $lugar->descripcion;
            $lugar->save();
            return back()->with(["success" => "La sede $nombreLugar fue DESACTIVADA"]);
        }
    }

    public function edit($id)
    {
        //
        $lugar = Lugar::find($id);
        $sedes = Sede::where('estado','A')->get();
        return view('pages.private.espacios.lugares.edit', compact('lugar','sedes'));
    }

    public function update(Request $request, $id)
    {
        //
        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'costohora' => ['required'],
            'tipo' => ['required'],
            'estado' => ['required'],
            'sede_id' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'costohora.required' => 'El campo costo hora es obligatorio',
            'tipo.required' => 'El campo tipo es obligatorio',
            'estado.required' => 'El campo estado es obligatorio',
            'sede_id.required' => 'El campo sede es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $lugar = Lugar::find($id);
        $lugar->descripcion = Str::upper($request->descripcion);
        $abreviatura = Str::upper(Str::of($request->descripcion)->substr(0, 2));
        $lugar->abreviatura = Str::upper($abreviatura);
        $lugar->costohora = Str::upper($request->costohora);
        $lugar->tipo = Str::upper($request->tipo);
        $lugar->estado = Str::upper($request->estado);
        $lugar->usuario_creador = $this->getUserLoginData();
        $lugar->usuario_editor = $this->getUserLoginData();
        $lugar->ip_usuario = \request()->ip();
        $lugar->sede_id = $request->sede_id;

        $lugar->save();

        $nombrelugar = $lugar->descripcion;

        return redirect()->route('lugares.index')->with('success', "El lugar $nombrelugar fue actualizado exitosamente!");
    }

    public function destroy(Request $request)
    {
        //
        $lugar = Lugar::findOrFail($request->id);
        $lugar->estado = 'I';
        $lugar->save();
        $lugar->delete();

        return redirect()->back()->with('success', 'La sede fue eliminada');
    }
}
