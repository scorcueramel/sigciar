<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\Prsona2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Polyfill\Php81\Php81;

class UsuarioDatosController extends Controller
{

    public function index()
    {
        //
        return view('pages.public.user.update_data');
    }

    public function getTipyDocument()
    {
        $tiposDocs = DB::select("SELECT tpd.id, tpd.descripcion FROM tipodocumento tpd WHERE tpd.estado = 'A'");
        return response()->json(['tipos' => $tiposDocs]);
    }

    public function dataUserUpdate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'tipodocumento' => ['required', 'string'],
            'numerodoc' => ['required', 'max:12', 'unique:numerodoc'],
            'apepaterno' => ['required'],
            'apematerno' => ['required'],
            'nomrbes' => ['required'],
            'movil' => ['required', 'max:13'],
        ]);

        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation)->withInput();
        }

        return view('pages.public.reservation.index');
    }
}
