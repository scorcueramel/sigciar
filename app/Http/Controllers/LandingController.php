<?php

namespace App\Http\Controllers;

use App\Models\Sede;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    //
    public function index(){
        $sedes = Sede::where('estado','A')->orderBy('id','asc')->get();
        return view("pages.public.landing.index",compact("sedes"));
    }
    public function activities(){
        return view("pages.public.landing.activities");
    }
    public function promises(){
        return view("pages.public.landing.promises");
    }

    public function news(){
        return view("pages.public.landing.news");
    }
}
