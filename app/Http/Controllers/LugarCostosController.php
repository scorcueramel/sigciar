<?php

namespace App\Http\Controllers;

use App\Models\Lugar;
use App\Models\LugarCosto;
use App\Models\Persona;
use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LugarCostosController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:ver.costo.lugar|crear.costo.lugar|editar.costo.lugar|eliminar.costo.lugar', ['only' => ['index']]);
        $this->middleware('permission:crear.costo.lugar', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar.costo.lugar', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estado.costo.lugar', ['only' => ['changeState']]);
        $this->middleware('permission:eliminar.costo.lugar', ['only' => ['destroy']]);
    }
    public function index()
    {
        $data = LugarCosto::where('estado','A')->get();
        if(count($data) > 0){
            $headerTable = LugarCosto::select('id', 'descripcion', 'abreviatura', 'costohora', 'estado', 'tipo', 'lugars_id', 'tiposervicios_id')->first()->toArray();
            $keysSedes = [$keys, $values] = Arr::divide($headerTable)[0];
            $endHeaders = count($keysSedes);
            $sedesHeader = Arr::add($keysSedes, $endHeaders, 'Acciones');
            $sedesBody = LugarCosto::leftJoin('lugars', 'lugars.id', '=', 'lugar_costos.lugars_id')
            ->leftJoin('tipo_servicios', 'tipo_servicios.id', '=', 'lugar_costos.tiposervicios_id')
            ->select('lugar_costos.id', 'lugar_costos.descripcion', 'lugar_costos.abreviatura', 'lugar_costos.costohora', 'lugar_costos.estado', 'lugar_costos.tipo', 'lugars.descripcion as lugar', 'tipo_servicios.descripcion as tiposervicio')
            ->orderBy('id', 'asc')
            ->paginate(10);
        }else{
            $sedesHeader = [];
            $sedesBody = null;
        }

        return view("pages.private.tipos.costo-lugar.index", compact("sedesHeader", "sedesBody"));
    }

    public function changeState(Request $request)
    {
        $noticia = LugarCosto::find($request->id);
        if ($noticia->estado == "I") {
            $noticia->estado = "A";
            $noticia->save();
            return back()->with(["success" => "El tipo de servicio fue PUBLICADO correctamente 👍"]);
        }
        if ($noticia->estado == "A") {
            $noticia->estado = "I";
            $noticia->save();
            return back()->with(["success" => "El tipo de servicio fue DESPUBLICADO correctamente 👍"]);
        }
    }

    public function create()
    {
        $tiposervicios = TipoServicio::all();
        $lugares = Lugar::all();
        return view("pages.private.tipos.costo-lugar.create", compact("tiposervicios", "lugares"));
    }

    public function store(Request $request)
    {
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = $usuario[0]->nombres . " " . $usuario[0]->apepaterno . " " . $usuario[0]->apematerno;
        $ip = $request->ip();

        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'abreviatura' => ['required'], ['max:3'],
            'estado' => ['required'],
            'costohora' => ['required'],
            'tipo' => ['required'],
            'lugares' => ['required'],
            'tiposervicios' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'abreviatura.required' => 'El campo abreviatura es obligatorio',
            'abreviatura.max' => 'El campo abreviatura solo permite 3 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
            'costohora.required' => 'El campo costo hora es obligatorio',
            'titere.required' => 'El campo titere es obligatorio',
            'lugares.required' => 'El campo lugares es obligatorio',
            'tiposervicios.required' => 'El campo tiposervicios es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $lugarcosto = LugarCosto::create([
            'descripcion' => Str::upper($request->descripcion),
            'abreviatura' => Str::upper($request->abreviatura),
            'estado' => $request->estado,
            'costohora' => $request->costohora,
            'tipo' => $request->tipo,
            'lugars_id' => $request->lugares,
            'tiposervicios_id' => $request->tiposervicios,
            'usuario_creador' => $nombre_usuario,
            'usuario_editor' => $nombre_usuario,
            'ip_usuario' => $ip
        ]);

        return redirect()->route('costos.lugares.index')->with('success', "El costo lugar $lugarcosto->descripcion fue creado exitosamente! 👍");
    }

    // public function show($id)
    // {
    //     //
    // }

    public function edit(string $id)
    {
        $costolugar = LugarCosto::findOrFail($id);
        $tiposervicios = TipoServicio::all();
        $lugares = Lugar::all();
        return view("pages.private.tipos.costo-lugar.edit", compact("costolugar", "tiposervicios", "lugares"));
    }

    public function update(Request $request, $id)
    {
        $usuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $nombre_usuario = $usuario[0]->nombres . " " . $usuario[0]->apepaterno . " " . $usuario[0]->apematerno;
        $ip = $request->ip();

        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'abreviatura' => ['required'], ['max:3'],
            'estado' => ['required'],
            'costohora' => ['required'],
            'tipo' => ['required'],
            'lugares' => ['required'],
            'tiposervicios' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'abreviatura.required' => 'El campo abreviatura es obligatorio',
            'abreviatura.max' => 'El campo abreviatura solo permite 3 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
            'costohora.required' => 'El campo costo hora es obligatorio',
            'titere.required' => 'El campo titere es obligatorio',
            'lugares.required' => 'El campo lugares es obligatorio',
            'tiposervicios.required' => 'El campo tiposervicios es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $lugarcosto = LugarCosto::findOrFail($id);
        $lugarcosto->descripcion = Str::upper($request->descripcion);
        $lugarcosto->abreviatura = Str::upper($request->abreviatura);
        $lugarcosto->estado = $request->estado;
        $lugarcosto->costohora = $request->costohora;
        $lugarcosto->tipo = $request->tipo;
        $lugarcosto->lugars_id = $request->lugares;
        $lugarcosto->tiposervicios_id = $request->tiposervicios;
        $lugarcosto->usuario_editor = $nombre_usuario;
        $lugarcosto->ip_usuario = $ip;
        $lugarcosto->save();

        return redirect()->route('costos.lugares.index')->with('success', "El costo lugar $lugarcosto->descripcion fue actualizado exitosamente! 👍");
    }

    public function destroy(Request $request)
    {
        $tiposervicio = LugarCosto::findOrFail($request->id);
        $tiposervicio->delete();
        return redirect()->route('costos.lugares.index')->with('success', 'El Lugar costo fue eleminado correctamente 👍');
    }
}
