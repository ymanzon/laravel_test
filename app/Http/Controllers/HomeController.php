<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function __construct()
    {
        //echo "cargando";
        $this->middleware('auth:api', ['except' => ['home']]);
        //$this->middleware('auth:api');
    }
    

    public function home()
    {
        //return response()->json(['message' => 'Has iniciado sesión de manera segura sure'], 200);
        return view('home.home');
    }
}
