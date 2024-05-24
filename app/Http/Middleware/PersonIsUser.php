<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class PersonIsUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user()->id;

        $query = DB::select('SELECT tc.abreviatura FROM personas p
                              INNER JOIN tipo_categorias tc
                              ON tc.id = p.tipocategoria_id
                              WHERE p.usuario_id = ?',[$user]);

        $person = $query[0]->abreviatura;

        if(auth()->check() && $person != 'US')
            return $next($request);

        return redirect('/ciar/reserva')->with('warning','No puede acceder a esa sección por ser solo para personal autorizado de CIAR por lo tanto se encuentra restringida.
        Si eres miembro del STAFF de CIAR y no puedes acceder con tu usuario, te sugerimos contactar con el administrador para solucionar el inconveniente');
    }
}
