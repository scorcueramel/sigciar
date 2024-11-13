<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginMemberController extends Controller
{
    public function login(Request $request)
    {
        $validate = $this->validate($request, [
            "email" => "required",
            "password" => "required",
        ]);

        $credentials = [
            "email" => $request->email,
            "password" => $request->password
        ];

        $remember = ($request->has('remember') ? true : false);

        if (Auth::attempt($credentials, $remember)) {
            $usuario = Persona::where('usuario_id', Auth::id())->get()[0];

            if ($request->inscripcion == '1') {
                $nombreUsuario = "$usuario->nombres $usuario->apepaterno  $usuario->apematerno";
                return redirect()->back()->with('success', "Bienvenido $nombreUsuario");
            }

            return redirect()->route('prfole.user');
        } else {
            return redirect()->back()->withErrors($validate)->withInput();
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing.index');
    }
}
