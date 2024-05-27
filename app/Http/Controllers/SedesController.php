<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SedesController extends Controller
{
    protected $disk = 'public';
    public function index()
    {
        //
        $headerTable = Sede::select('id', 'descripcion', 'abreviatura', 'direccion', 'imagen', 'estado')->first()->toArray();
        $keysSeded = [$keys, $values] = Arr::divide($headerTable)[0];
        $endHeaders = count($keysSeded);
        $sedesHeader = Arr::add($keysSeded, $endHeaders, 'Acciones');
        // dd($sedesHeader);
        $sedesBody = Sede::select('id', 'descripcion', 'abreviatura', 'direccion', 'imagen', 'estado')->orderBy('id', 'asc')->get();

        return view("pages.private.admin.sedes.index", compact("sedesHeader", "sedesBody"));
    }

    public function create()
    {
        //
        // return view("pages.private.admin.sedes.create");
        return view("pages.private.admin.sedes.create");
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'descripcion' => ['required'], ['max:100'],
            'direccion' => ['required'], ['max:250'],
            'estado' => ['required'],
        ],[
            'descripcion.required'=>'El campo descripción es obligatorio',
            'descripcion.max'=>'El campo descripción solo permite 100 caraxteres máximo',
            'direccion.required'=>'El campo dirección es obligatorio',
            'direccion.max'=>'El campo dirección solo permite 250 caraxteres máximo',
            'estado.required'=>'El campo estado es obligatorio',
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $sede = new Sede();
        $sede->descripcion = Str::upper($request->descripcion);
        $abreviatura = Str::upper(Str::of($request->descripcion)->substr(0,3));
        $sede->abreviatura = Str::upper($abreviatura);
        $sede->direccion = $request->direccion;
         if ($imagen = $request->file('imagen')) {
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $sede['imagen'] = "$imgRename";
            // Storage::putFileAs('', $imagen, $imgRename);
            $imagen->storeAs('/sedes/', $imgRename, $this->disk);
        } else {
            $sede->imagen = 'default-img.png';
        }
        $sede->estado = $request->estado;
        $sede->save();

        $nombreSede = $sede->descripcion;

        return redirect()->route('sedes.index')->with('success', "La sede $nombreSede fue registrada exitosamente!");
    }

    public function changeState($id){
        $sede = Sede::find($id);
        if ($sede->estado == "I") {
            $sede->estado = "A";
            $nombreSede = $sede->descripcion;
            $sede->save();
            return redirect()->route('sedes.index')->with("success","La sede $nombreSede fue ACTIVADA exitosamente");
        }
        if ($sede->estado == "A") {
            $sede->estado = "I";
            $nombreSede = $sede->descripcion;
            $sede->save();
            return redirect()->route('sedes.index')->with("success","La sede $nombreSede fue DESACTIVADA exitosamente");
        }
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
