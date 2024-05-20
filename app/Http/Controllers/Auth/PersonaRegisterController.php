<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PersonaRegisterController extends Controller
{
    public function index()
    {
        $tipoDocs = TipoDocumento::where('estado', 'A')->get();
        return view('auth.register', compact('tipoDocs'));
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'documento' => ['required','unique:personas'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }


        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Persona::create([
            'fecharegistro' => Carbon::now()->toDateTimeString(),
            'tipodocumento_id' => $request->tipodocumento_id,
            'documento' => $request->documento,
            'tipocategoria_id' => 1,
            'apepaterno' => Str::upper($request->apepaterno),
            'apematerno' => Str::upper($request->apematerno),
            'nombres' => Str::upper($request->nombres),
            'movil' => $request->movil,
            'estado' => 'A',
            'usuario_creado' => 'AUTOREGISTRO',
            'usuario_editor' => 'AUTOREGISTRO',
            'usuario_ip' => $request->ip(),
            'usuario_id' => $user->id,
        ]);

        $this->guard()->login($user);

        return redirect()->route('reservation');
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
