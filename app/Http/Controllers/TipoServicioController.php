<?php

namespace App\Http\Controllers;

use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TipoServicioController extends Controller
{
    public function index()
    {
        $headerTable = TipoServicio::select('id', 'descripcion', 'abreviatura', 'estado')->first()->toArray();
        $keysSedes = [$keys, $values] = Arr::divide($headerTable)[0];
        $endHeaders = count($keysSedes);
        $sedesHeader = Arr::add($keysSedes, $endHeaders, 'Acciones');
        $sedesBody = TipoServicio::select('id', 'descripcion', 'abreviatura', 'estado')->orderBy('id', 'asc')->paginate(5);

        return view("pages.private.tipos.tipo-servicio.index", compact("sedesHeader", "sedesBody"));
    }

    public function changeState(Request $request)
    {
        $noticia = TipoServicio::find($request->id);
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
        return view("pages.private.tipos.tipo-servicio.create");
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'abreviatura' => ['required'], ['max:3'],
            'estado' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'abreviatura.required' => 'El campo abreviatura es obligatorio',
            'abreviatura.max' => 'El campo abreviatura solo permite 3 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $tiposervicio = TipoServicio::create([
            'descripcion'=> Str::upper($request->descripcion),
            'abreviatura'=> $request->abreviatura,
            'estado' => $request->estado
        ]);

        return redirect()->route('tipo.servicio.index')->with('success', "El tipo $tiposervicio->descripcion fue creado exitosamente! 👍");
    }

    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        $tiposervicio = TipoServicio::findOrFail( $id );
        return view("pages.private.tipos.tipo-servicio.edit",compact("tiposervicio"));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'abreviatura' => ['required'], ['max:3'],
            'estado' => ['required'],
        ], [
            'descripcion.required' => 'El campo descripción es obligatorio',
            'descripcion.max' => 'El campo descripción solo permite 100 caraxteres máximo',
            'abreviatura.required' => 'El campo abreviatura es obligatorio',
            'abreviatura.max' => 'El campo abreviatura solo permite 3 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $tiposervicio = TipoServicio::findOrFail( $id );
        $tiposervicio->descripcion = $request->descripcion;
        $tiposervicio->abreviatura = $request->abreviatura;
        $tiposervicio->estado = $request->estado;
        $tiposervicio->save();

        return redirect()->route('tipo.servicio.index')->with('success', "El tipo $tiposervicio->descripcion fue actualizado exitosamente! 👍");
    }

    public function destroy(Request $request)
    {
        $tiposervicio = TipoServicio::findOrFail($request->id);
        $tiposervicio->delete();
        return redirect()->route('tipo.servicio.index')->with('success', 'El tipo de servicio fue eleminado correctamente 👍');
    }
}
