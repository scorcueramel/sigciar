<?php

namespace App\Http\Controllers;

use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

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
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        $tiposervicio = TipoServicio::findOrFail($request->id);
        $tiposervicio->delete();
        return redirect()->back()->with('success', 'El tipo de servicio fue eleminado correctamente 👍');
    }
}
