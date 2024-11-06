<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    protected $disk = 'public';

    public function index()
    {
        $personas = Persona::leftJoin('tipo_documentos', 'tipo_documentos.id', '=', 'personas.tipodocumento_id')
            ->leftJoin('users', 'users.id', '=', 'personas.usuario_id')
            ->select('personas.*', 'tipo_documentos.abreviatura', 'users.*')->get();
        $usuarios = User::all();

        return view("pages.private.accesos.usuarios.index", compact('personas', 'usuarios'));
    }

    public function create()
    {
        $tipodocumentos = TipoDocumento::all();
        $roles = Role::pluck('name', 'name')->all();
        return view("pages.private.accesos.usuarios.create", compact('roles', 'tipodocumentos'));
    }

    public function store(Request $request)
    {
        $datosUsuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $usuarioActual = $datosUsuario[0]->nombres . " " . $datosUsuario[0]->apepaterno . " " . $datosUsuario[0]->apematerno;
        $validation = Validator::make($request->all(), [
            'tipodocumento' => 'required',
            'numerodocumento' => 'required',
            'nombres' => 'required',
            'apepaterno' => 'required',
            'apematerno' => 'required',
            'movil' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ],[
            'tipodocumento.required'=>'Debes seleccionar un tipo de documento',
            'numerodocumento.required'=>'No debes dejar el numero de documento en blanco',
            'nombres.required' => 'No debes dejar en blando el nombre',
            'nombres.max' => 'El nombre solo permite 50 caracteres como máximo',
            'apepaterno.required' => 'No debes dejar en blanco el apellido parterno',
            'apepaterno.max' => 'El apellido paterno solo permite 50 caracteres como máximo',
            'apematerno.required' => 'No debes dejar en blanco el apellido marterno',
            'apematerno.max' => 'El apellido materno solo permite 50 caracteres como máximo',
            'email.required' => 'No debes dejar en blanco el correo',
            'tipo_documento.required' => 'Debes seleccionar un tipo de documento',
            'documento' => 'No debes dejar en blanco el número de documento',
            'documento.max' => 'El documento solo permite 12 caracteres como máximo',
            'movil' => 'No debes dejar en blanco el número de movil',
            'movil.max' => 'Solo se permite 15 caracteres como máximo para el campo movil',
            'password.required'=>'No debes deja la contraseña en blanco',
            'password.same' => 'Las contraseñas ingresadas no coinciden',
            'roles'=> "Debes seleccionar como minimo un rol para el usuario {$request->nombres} {$request->apepaterno} {$request->apematerno}",
        ]);

        if($validation->fails()){
            return redirect()->back()->withErrors($validation)->withInput();
        }

        $user = new User();
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $usuarioid = $user->id;
        $persona = new Persona();
        $persona->fecharegistro = date('Y-m-d H:i:s');
        $persona->tipodocumento_id = $request->tipodocumento;
        $persona->documento = $request->numerodocumento;
        $persona->tipocategoria_id = 3;
        $persona->nombres = Str::upper($request->nombres);
        $persona->apepaterno = Str::upper($request->apepaterno);
        $persona->apematerno = Str::upper($request->apematerno);
        $persona->movil = $request->movil;
        $persona->estado = $request->estado;
        $persona->usuario_creador = $usuarioActual;
        $persona->usuario_editor = $usuarioActual;
        $persona->ip_usuario = $request->ip();
        $persona->usuario_id = $usuarioid;

        $dirName = ($persona->directorio != null || $persona->directorio != '') ? $persona->directorio : Str::random(20);

        if ($imagen = $request->file('imagen')) {
            if (\File::exists(public_path("/storage/avatars/$dirName/{$persona->imagen}"))) {
                \File::delete(public_path("/storage/avatars/$dirName/{$persona->imagen}"));
            }
            $imgRename = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $persona['imagen'] = (string) $imgRename;
            // $imagen->storeAs('/sedes/', $imgRename, $this->disk);
            $imagen->storeAs("/avatars/$dirName/", $imgRename, $this->disk);
        }

        $persona->directorio = $dirName;

        $user->assignRole($request->input('roles'));
        $msn = "Usuario Registrado Correctamente";

        $persona->save();

        return redirect()->route('usuarios.index')->with('success', $msn);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $encontrarUsuario = DB::select('select * from personas p
                                left join users u
                                on u.id = p.usuario_id
                                where p.id = ?', [$id]);
        $user = User::find($id);
        $usuario = $encontrarUsuario[0];
        $tipodocumentos = TipoDocumento::all();

        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');

        return view("pages.private.accesos.usuarios.edit", compact('roles', 'tipodocumentos', 'usuario', 'user'));
    }

    public function update(Request $request, $id)
    {

        // dd($request->input('roles'));

        $persona = Persona::find($id);
        $user = User::find($persona->id);

        $datosUsuario = Persona::where('usuario_id', Auth::user()->id)->get();
        $usuarioActual = $datosUsuario[0]->nombres . " " . $datosUsuario[0]->apepaterno . " " . $datosUsuario[0]->apematerno;
        $this->validate($request, [
            'tipodocumento' => 'required',
            'numerodocumento' => 'required',
            'nombres' => 'required',
            'apepaterno' => 'required',
            'apematerno' => 'required',
            'movil' => 'required',
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ],[
            'nombres.required' => 'No debes dejar en blando el nombre',
            'nombres.max' => 'El nombre solo permite 50 caracteres como máximo',
            'apepaterno.required' => 'No debes dejar en blanco el apellido parterno',
            'apepaterno.max' => 'El apellido paterno solo permite 50 caracteres como máximo',
            'apematerno.required' => 'No debes dejar en blanco el apellido marterno',
            'apematerno.max' => 'El apellido materno solo permite 50 caracteres como máximo',
            'correo.required' => 'No debes dejar en blanco el correo',
            'tipo_documento.required' => 'Debes seleccionar un tipo de documento',
            'documento' => 'No debes dejar en blanco el número de documento',
            'documento.max' => 'El documento solo permite 12 caracteres como máximo',
            'movil' => 'No debes dejar en blanco el número de movil',
            'movil.max' => 'Solo se permite 15 caracteres como máximo para el campo movil',
            'password.same' => 'Las contraseñas ingresadas no coinciden',
            'roles'=>'Debes seleccionar como minimo un rol para el usuario '. $persona->nombres ." ".$persona->apepaterno ." ".$persona->apematerno,
        ]);

        $user->email = $request->email;
        if ($request->password != null){
            $user->password = Hash::make($request->password);
        }
        $user->save();


        $usuarioid = $user->id;
        $persona->tipodocumento_id = $request->tipodocumento;
        $persona->documento = $request->numerodocumento;
        $persona->tipocategoria_id = 3;
        $persona->nombres = Str::upper($request->nombres);
        $persona->apepaterno = Str::upper($request->apepaterno);
        $persona->apematerno = Str::upper($request->apematerno);
        $persona->movil = $request->movil;
        $persona->estado = $request->estado;
        $persona->usuario_editor = $usuarioActual;
        $persona->ip_usuario = $request->ip();
        $persona->usuario_id = $usuarioid;

        $dirName = ($persona->directorio != null || $persona->directorio != '') ? $persona->directorio : Str::random(20);

        if ($request->imagen != null) {
            if (\File::exists(public_path("/storage/avatars/$dirName/{$persona->imagen}"))) {
                \File::delete(public_path("/storage/avatars/$dirName/{$persona->imagen}"));
            }
            $imgRename = date('YmdHis') . "." . $request->imagen->getClientOriginalExtension();
            $persona['imagen'] = "$imgRename";
            $request->imagen->storeAs("/avatars/$dirName/", $imgRename, $this->disk);
        }

        $persona->directorio = $dirName;
        $persona->save();

        DB::table('model_has_roles')->where('model_id',$usuarioid)->delete();

        $user->assignRole($request->input('roles'));
        $msn = "Usuario Actualizado Correctamente";


        return redirect()->route('usuarios.index')->with('success', $msn);
    }

    public function destroy(string $id)
    {
        if(auth()->user()->id == $id){
            return back()->with('error','No puedes auto bloquear tu usuario 😅😝');
        }

        $persona = Persona::find($id);
        $usuario = User::find($persona->usuario_id);
        if($persona->estado == 'A'){
            $persona->update(['estado'=>'I']);
            $serialKey = Str::random(100, 'alphaNum');
            $usuario->update(['password' => $serialKey]);
            return redirect()->route('usuarios.index')->with('success', 'Usuario se bloqueo correctamente');
        }else{
            $persona->update(['estado'=>'A']);
            return redirect()->route('usuarios.index')->with('success', 'Usuario activado correctament, no olvides colocarle una nueva clave');
        }
    }
}
