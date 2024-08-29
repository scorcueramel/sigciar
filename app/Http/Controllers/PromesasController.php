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
    //     $promesa = Noticia::find($request->id);
    //     if ($promesa->estado == "I") {
    //         $promesa->estado = "A";
    //         $promesa->save();
    //         return back()->with(["success" => "La noticia fue ACTIVADA"]);
    //     }
    //     if ($promesa->estado == "A") {
    //         $promesa->estado = "I";
    //         $promesa->save();
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

    public function edit(string $id)
    {
        $promesa = Promesa::find($id);
        return view('pages.private.promesas.edit', compact('promesa'));
    }

    public function update(Request $request,$id)
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

        $promesa = Promesa::findOrFail($id);
        $promesa->nombre = Str::title($request->nombre);
        $promesa->peso = $request->peso;
        $promesa->estatura = $request->estatura;
        $promesa->mano = Str::title($request->mano);
        $promesa->academia = Str::title($request->academia);
        $promesa->preparador = Str::title($request->preparador);
        $promesa->nutricionista = Str::title($request->nutricionista);
        $promesa->detalle = $request->extracto;
        $promesa->edad = $request->edad;
        if ($request->imagen != null) {
            if ($imagen = $request->file('imagen')) {
                if (\File::exists(public_path("/storage/promesas/{$promesa->foto}"))) {
                    \File::delete(public_path("/storage/promesas/{$promesa->foto}"));
                }
                $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
                $promesa['foto'] = (string) $imgRename;
                // Storage::putFileAs('', $imagen, $imgRename);
                $imagen->storeAs('/promesas/', $imgRename, $this->disk);
            }
        }

        $promesa->save();

        return redirect()->route('promesas.index')->with('success', "El registro fue actualizado exitosamente!");
    }

    public function destroy(Request $request)
    {
        $promesa = Promesa::findOrFail($request->id);
        if (\File::exists(public_path('/storage/promesas/' . $promesa->foto))) {
            \File::delete(public_path('/storage/promesas/' . $promesa->foto));
        }
        $promesa->delete();
        return redirect()->back()->with('success', 'El registro fue eliminado exitosamente!');
    }
}
