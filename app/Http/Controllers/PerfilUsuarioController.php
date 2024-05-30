<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PerfilUsuarioController extends Controller
{
    protected $disk = 'public';

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //
        $usuario = auth()->user();
        $persona = Persona::join('tipo_categorias', 'tipo_categorias.id', '=', 'personas.tipocategoria_id')->join('tipo_documentos', 'tipo_documentos.id', '=', 'personas.tipodocumento_id')->where('personas.estado', 'A')->where("usuario_id", $usuario->id)->select('personas.*', 'tipo_documentos.id as tipodocid', 'tipo_documentos.descripcion as tipodocdesc', 'tipo_documentos.abreviatura as tipodocabrev', 'tipo_categorias.descripcion as tcdescripcion', 'tipo_categorias.abreviatura as tcabreviatura')->first();
        $datosPersona = Arr::add($persona, 'correo', $usuario->email);
        $dirName = str_replace(' ', '-', $persona->nombres);
        $tipoDocumentos = TipoDocumento::where('estado','A')->get();

        return view("pages.public.users.userprofile.index", compact("datosPersona",'dirName','tipoDocumentos'));
    }

    public function updateImage(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|max:2048'
        ], [
            'imagen.required' => 'Debes seleccionar una foto para actualizar tu perfil',
            'imagen.max' => 'La imagen seleccionada es demasiado pesada, te sugerimos seleccionar una imagen menor o igual a 2mb',
        ]);

        $persona = Persona::find($request->idpersona);

        $dirName = str_replace(' ', '-', $persona->nombres);

        if ($imagen = $request->file('imagen')) {
            if (\File::exists(public_path('/storage/avatars/' . $dirName . '/' . $persona->imagen))) {
                \File::delete(public_path('/storage/avatars/' . $dirName . '/' . $persona->imagen));
            }
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $persona['imagen'] = "$imgRename";
            // $imagen->storeAs('/sedes/', $imgRename, $this->disk);
            $imagen->storeAs('/avatars/' . $dirName . '/', $imgRename, $this->disk);
        }

        $persona->save();

        return redirect()->back()->with('success', 'Foto Actualizado Exitosamente!');
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

    public function destroy($id)
    {
        //
    }
}
