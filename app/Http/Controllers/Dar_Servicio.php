<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Socios;


class Dar_Servicio extends Controller
{
    public function index()
    {
  	   return view('Dar_servicio');
    }

  public function sociosQueCumplenConFiltro(Request $request)
  {
  	
  	$socios = DB::table('socios')
  		->where('nombre', 'LIKE', '%'.$request['nombre'].'%')->get();
  	return $socios;

  }

  public function proovedoresQueCumplenConFiltro(Request $request)
  {
  	$proovedores = DB::table('proovedores')
  		->where('nombre', 'LIKE', '%'.$request['nombre'].'%')->get();
  	return $proovedores;
  }
}
