<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Articulo;
use App\Models\Empresa_datos;



class WelcomeController extends Controller
{
    //

    public function index(Request $request )
    {
  
   return view('auth.login');
    }

}
