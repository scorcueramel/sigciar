<?php

namespace App\Http\Controllers;

use App\Models\SubtipoServicio;
use App\Models\TipoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SubtipoServicioController extends Controller
{
    protected $disk = "public";
    public function index()
    {
        $headerTable = SubtipoServicio::select('id', 'titulo', 'subtitulo', 'estado', 'imagen', 'medicion', 'tiposervicio_id')->first()->toArray();
        $keysSedes = [$keys, $values] = Arr::divide($headerTable)[0];
        $endHeaders = count($keysSedes);
        $sedesHeader = Arr::add($keysSedes, $endHeaders, 'Acciones');
        $sedesBody = SubtipoServicio::leftJoin('tipo_servicios','tipo_servicios.id','=','subtipo_servicios.tiposervicio_id')->select('subtipo_servicios.*', 'tipo_servicios.descripcion as descripciontiposervicio')->orderBy('id', 'asc')->paginate(5);

        return view("pages.private.tipos.subtipo-servicio.index", compact("sedesHeader", "sedesBody"));
    }

    public function changeState(Request $request)
    {
        $noticia = SubtipoServicio::find($request->id);
        if ($noticia->estado == "I") {
            $noticia->estado = "A";
            $noticia->save();
            return back()->with(["success" => "El subtipo de servicio fue PUBLICADO correctamente 👍"]);
        }
        if ($noticia->estado == "A") {
            $noticia->estado = "I";
            $noticia->save();
            return back()->with(["success" => "El subtipo de servicio fue DESPUBLICADO correctamente 👍"]);
        }
    }

    public function create()
    {
        $tiposervicios = TipoServicio::all();
        return view("pages.private.tipos.subtipo-servicio.create", compact("tiposervicios"));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'titulo' => ['required'], ['max:100'],
            'subtitulo' => ['required'], ['max:100'],
            'medicion' => ['required'], ['max:20'],
            'estado' => ['required'],
            'tiposervicio' => ['required'],
        ], [
            'titulo.required' => 'El campo titulo es obligatorio',
            'titulo.max' => 'El campo titulo solo permite 100 caraxteres máximo',
            'subtitulo.required' => 'El campo subtitulo es obligatorio',
            'subtitulo.max' => 'El campo subtitulo solo permite 100 caraxteres máximo',
            'medicion.required' => 'El campo medicion es obligatorio',
            'medicion.max' => 'El campo medicion solo permite 20 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
            'tiposervicio.required' => 'El campo tipo servicio es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $subtiposervicio = new SubtipoServicio();
        $subtiposervicio->titulo = Str::upper($request->input('titulo'));
        $subtiposervicio->subtitulo = Str::upper($request->input('subtitulo'));
        $subtiposervicio->estado = $request->input('estado');
        $subtiposervicio->medicion = Str::upper($request->input('medicion'));
        $subtiposervicio->tiposervicio_id = Str::upper($request->input('tiposervicio'));
        if ($imagen = $request->file('imagen')) {
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $subtiposervicio['imagen'] = (string) $imgRename;
            // Storage::putFileAs('', $imagen, $imgRename);
            $imagen->storeAs('/subtipos/', $imgRename, $this->disk);
        } else {
            $subtiposervicio->imagen = 'default-img.png';
        }
        $subtiposervicio->save();

        return redirect()->route('subtipos.servicio.index')->with('success', "El subtipo $subtiposervicio->titulo fue creado exitosamente! 👍");
    }

    public function show($id)
    {
        //
    }

    public function edit(string $id)
    {
        $subtiposervicio = SubtipoServicio::findOrFail($id);
        $tiposervicios = TipoServicio::all();
        return view("pages.private.tipos.subtipo-servicio.edit",compact("subtiposervicio","tiposervicios"));
    }

    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            'titulo' => ['required'], ['max:100'],
            'subtitulo' => ['required'], ['max:100'],
            'medicion' => ['required'], ['max:20'],
            'estado' => ['required'],
            'tiposervicio' => ['required'],
        ], [
            'titulo.required' => 'El campo titulo es obligatorio',
            'titulo.max' => 'El campo titulo solo permite 100 caraxteres máximo',
            'subtitulo.required' => 'El campo subtitulo es obligatorio',
            'subtitulo.max' => 'El campo subtitulo solo permite 100 caraxteres máximo',
            'medicion.required' => 'El campo medicion es obligatorio',
            'medicion.max' => 'El campo medicion solo permite 20 caraxteres máximo',
            'estado.required' => 'El campo estado es obligatorio',
            'tiposervicio.required' => 'El campo tipo servicio es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $subtiposervicio = SubtipoServicio::findOrFail($id);
        $subtiposervicio->titulo = Str::upper($request->input('titulo'));
        $subtiposervicio->subtitulo = Str::upper($request->input('subtitulo'));
        $subtiposervicio->estado = $request->input('estado');
        $subtiposervicio->medicion = Str::upper($request->input('medicion'));
        $subtiposervicio->tiposervicio_id = Str::upper($request->input('tiposervicio'));
        if ($request->imagen != null) {
            if ($imagen = $request->file('imagen')) {
                if (\File::exists(public_path("/storage/subtipos/{$subtiposervicio->imagen}"))) {
                    \File::delete(public_path("/storage/subtipos/{$subtiposervicio->imagen}"));
                }
                $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
                $subtiposervicio['imagen'] = (string) $imgRename;
                $imagen->storeAs('/subtipos/', $imgRename, $this->disk);
            }
        }
        $subtiposervicio->save();

        return redirect()->route('subtipos.servicio.index')->with('success', "El subtipo $subtiposervicio->titulo fue actualizado exitosamente! 👍");
    }

    public function destroy(Request $request)
    {
        $subtiposervicio= SubtipoServicio::findOrFail($request->id);
        if (\File::exists(public_path('/storage/subtipos/' . $subtiposervicio->imagen))) {
            \File::delete(public_path('/storage/subtipos/' . $subtiposervicio->imagen));
        }
        $subtiposervicio->delete();
        return redirect()->back()->with('success', 'El subtipo fue eliminada exitosamente! 👍');
    }
}
