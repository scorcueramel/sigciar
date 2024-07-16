<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginMemberController extends Controller
{
    public function login(Request $request){
        $validate = $this->validate($request, [
            "email"=> "required",
            "password"=> "required",
        ]);

        $credentials = [
            "email"=>$request->email,
            "password"=>$request->password
        ];

        $remember = ($request->has('remember') ? true : false);

        if(Auth::attempt($credentials,$remember)){
            return redirect()->route('prfole.user');
        }else{
            return redirect()->back()->withErrors($validate)->withInput();
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('landing.index');
    }
}
