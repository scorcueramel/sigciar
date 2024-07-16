<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PersonIsUser
{
    public function handle(Request $request, Closure $next)
    {
        $isLogin = Auth::check();
        if ($isLogin) {

            $user = auth()->user()->id;

            $query = DB::select('SELECT tc.abreviatura FROM personas p
                              INNER JOIN tipo_categorias tc
                              ON tc.id = p.tipocategoria_id
                              WHERE p.usuario_id = ?', [$user]);

            $person = $query[0]->abreviatura;

            if (auth()->check() && $person != 'US' && $person != 'MB' && $person != 'DN')
                return $next($request);

            return redirect('/ciar/reserva')->with('warning', 'No puede acceder a esa sección por ser solo para personal autorizado de CIAR por lo tanto se encuentra restringida.
            Si eres miembro del STAFF de CIAR y no puedes acceder con tu usuario, te sugerimos contactar con el administrador para solucionar el inconveniente');
        }else{
            return redirect('/login-staff')->with('warning','Debes iniciar sesión para ingresar al apartado que deseas.');
        }
    }
}
