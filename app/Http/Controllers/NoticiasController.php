<?php

namespace App\Http\Controllers;

use App\Models\CategoriaNoticia;
use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class NoticiasController extends Controller
{
    public $disk = "public";
    public function index(Request $request)
    {
        $buscar = Str::lower($request->buscar);
        $noticias = Noticia::leftJoin('categoria_noticias','categoria_noticias.id','=','noticias.categoria_id')->select("noticias.id as noticia_id","categoria_noticias.nombre as nombre","noticias.titulo as titulo","noticias.extracto as extracto","noticias.cuerpo as cuerpo","noticias.estado as estado","noticias.imagen_destacada as imagen_destacada","categoria_noticias.slug as slug")->where('noticias.titulo','LIKE','%'.$buscar.'%')
        ->orderBy('noticia_id','desc')
        ->paginate(3);
        return view("pages.private.noticias.index", compact("noticias","buscar"));
    }

    public function create()
    {
        $categorias = CategoriaNoticia::where('estado', 'A')->get();
        return view("pages.private.noticias.create", compact("categorias"));
    }

    public function changeState(Request $request)
    {
        $noticia = Noticia::find($request->id);
        if ($noticia->estado == "I") {
            $noticia->estado = "A";
            $noticia->save();
            return back()->with(["success" => "La noticia fue ACTIVADA"]);
        }
        if ($noticia->estado == "A") {
            $noticia->estado = "I";
            $noticia->save();
            return back()->with(["success" => "La noticia fue DESACTIVADA"]);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo' => ['required'], ['max:200'],
            'extracto' => ['required'], ['max:500'],
            'cuerpo' => ['required'],
            'categoria' => ['required'],
        ], [
            'titulo.required' => 'El campo titulo es obligatorio',
            'titulo.max' => 'El campo titulo solo permite 200 caraxteres máximo',
            'extracto.required' => 'El campo extracto es obligatorio',
            'extracto.max' => 'El campo extracto solo permite 500 caraxteres máximo',
            'cuerpo.required' => 'El campo cuerpo es obligatorio',
            'categoria.required' => 'El campo categoría es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $noticia = new Noticia();
        $noticia->categoria_id = $request->categoria;
        $noticia->setAttribute('titulo',$request->titulo);
        $noticia->extracto = $request->extracto;
        $noticia->cuerpo = $request->cuerpo;
        $noticia->estado = $request->estado;
        if ($imagen = $request->file('imagen')) {
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $noticia['imagen_destacada'] = "$imgRename";
            // Storage::putFileAs('', $imagen, $imgRename);
            $imagen->storeAs('/noticias/', $imgRename, $this->disk);
        } else {
            $noticia->imagen = 'default-img.png';
        }
        $noticia->save();

        return redirect()->route('noticias.index')->with('success', "La noticia fue creada exitosamente!");
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

    public function destroy($id)
    {
        //
    }
}
