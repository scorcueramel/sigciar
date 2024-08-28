<?php

namespace App\Http\Controllers;

use App\Models\Promesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PromesasController extends Controller
{
    public $disk = "public";

    public function index(Request $request)
    {
        $buscar = Str::title($request->buscar);

        $promesas = Promesa::where('nombre', 'LIKE', "%$buscar%")
            ->orderBy('id', 'desc')
            ->paginate(6);

        return view("pages.private.promesas.index", compact("promesas", "buscar"));
    }

    public function create()
    {
        return view("pages.private.promesas.create");
    }

    // public function changeState(Request $request)
    // {
    //     $noticia = Noticia::find($request->id);
    //     if ($noticia->estado == "I") {
    //         $noticia->estado = "A";
    //         $noticia->save();
    //         return back()->with(["success" => "La noticia fue ACTIVADA"]);
    //     }
    //     if ($noticia->estado == "A") {
    //         $noticia->estado = "I";
    //         $noticia->save();
    //         return back()->with(["success" => "La noticia fue DESACTIVADA"]);
    //     }
    // }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nombre' => ['required'],
            'edad' => ['required'],
            'peso' => ['required'],
            'estatura' => ['required'],
            'mano' => ['required'],
            'academia' => ['required'],
            'preparador' => ['required'],
            'nutricionista' => ['required'],
        ], [
            'nombre.required' => 'El campo nombre es obligatorio',
            'peso.required' => 'El campo peso es obligatorio',
            'edad.required' => 'El campo edad es obligatorio',
            'estatura.required' => 'El campo estatura es obligatorio',
            'mano.required' => 'El campo mano es obligatorio',
            'academia.required' => 'El campo academia es obligatorio',
            'extracto.required' => 'El campo extracto es obligatorio',
            'preparador.required' => 'El campo preparador es obligatorio',
            'nutricionista.required' => 'El campo nutricionista es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $promesa = new Promesa();
        $promesa->nombre = Str::title($request->nombre);
        $promesa->peso = $request->peso;
        $promesa->estatura = $request->estatura;
        $promesa->mano = Str::title($request->mano);
        $promesa->academia = Str::title($request->academia);
        $promesa->preparador = Str::title($request->preparador);
        $promesa->nutricionista = Str::title($request->nutricionista);
        $promesa->detalle = $request->extracto;
        $promesa->edad = $request->edad;

        if ($imagen = $request->file('imagen')) {
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $promesa['foto'] = (string) $imgRename;
            // Storage::putFileAs('', $imagen, $imgRename);
            $imagen->storeAs('/promesas/', $imgRename, $this->disk);
        } else {
            $promesa->imagen = 'default-img.png';
        }
        $promesa->save();

        return redirect()->route('promesas.index')->with('success', "Se registro la información exitosamente!");
    }

    public function show(string $id)
    {
        $promesa = Promesa::where('id', '=', $id)->get();

        return response()->json($promesa);
    }

    // public function edit(string $id)
    // {
    //     $categorias = CategoriaNoticia::where('estado', 'A')->get();
    //     $noticiaObtenida = Noticia::leftJoin('categoria_noticias', 'categoria_noticias.id', '=', 'noticias.categoria_id')->select("noticias.id as noticia_id", "categoria_noticias.nombre as nombre", "noticias.titulo as titulo", "noticias.extracto as extracto", "noticias.cuerpo as cuerpo", "noticias.estado as estado", "noticias.categoria_id as categoria_id", "noticias.imagen_destacada as imagen_destacada", "categoria_noticias.slug as slug")->where('noticias.id', '=', $id)->get();
    //     $noticia = $noticiaObtenida[0];

    //     return view('pages.private.noticias.edit', compact('noticia', 'categorias'));
    // }

    // public function update(Request $request)
    // {
    //     $validation = Validator::make($request->all(), [
    //         'titulo' => ['required'], ['max:200'],
    //         'extracto' => ['required'], ['max:500'],
    //         'cuerpo' => ['required'],
    //         'categoria' => ['required'],
    //     ], [
    //         'titulo.required' => 'El campo titulo es obligatorio',
    //         'titulo.max' => 'El campo titulo solo permite 200 caraxteres máximo',
    //         'extracto.required' => 'El campo extracto es obligatorio',
    //         'extracto.max' => 'El campo extracto solo permite 500 caraxteres máximo',
    //         'cuerpo.required' => 'El campo cuerpo es obligatorio',
    //         'categoria.required' => 'El campo categoría es obligatorio',
    //     ]);

    //     if ($validation->fails()) {
    //         return redirect()->back()->withErrors($validation)->withInput();
    //     }

    //     $id = $request->id;
    //     $noticia = Noticia::findOrFail($id);
    //     $noticia->categoria_id = $request->categoria;
    //     $noticia->setAttribute('titulo', $request->titulo);
    //     $noticia->extracto = $request->extracto;
    //     $noticia->cuerpo = $request->cuerpo;
    //     $noticia->estado = $request->estado;
    //     if ($request->imagen != null) {
    //         if ($imagen = $request->file('imagen')) {
    //             if (\File::exists(public_path('/storage/noticias/' . $noticia->imagen_destacada))) {
    //                 \File::delete(public_path('/storage/noticias/' . $noticia->imagen_destacada));
    //             }
    //             $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
    //             $noticia['imagen_destacada'] = (string) $imgRename;
    //             $imagen->storeAs('/noticias/', $imgRename, $this->disk);
    //         }
    //     }
    //     $noticia->save();

    //     return redirect()->route('noticias.index')->with('success', "La noticia fue actualizada exitosamente!");
    // }

    // public function destroy(Request $request)
    // {
    //     $noticia = Noticia::findOrFail($request->id);
    //     if (\File::exists(public_path('/storage/noticias/' . $noticia->imagen))) {
    //         \File::delete(public_path('/storage/noticias/' . $noticia->imagen));
    //     }
    //     $noticia->delete();
    //     return redirect()->back()->with('success', 'La noticia fue eliminada');
    // }
}
