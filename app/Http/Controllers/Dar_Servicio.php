<?php

namespace App\Http\Controllers;

use App\Proovedores;
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

  	$socios = Socios::where('nombre', 'LIKE', '%'.$request['nombre'].'%')
        ->with('organismo')
        ->get();
  	return $socios;

  }

  public function proovedoresQueCumplenConFiltro(Request $request)
  {
      return Proovedores::where('razon_social', 'LIKE', '%'.$request['nombre'].'%' )->get();
  }
}
