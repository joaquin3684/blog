<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\VentasRepo;
use Illuminate\Http\Request;

class CorrerVtoServiciosController extends Controller
{
    public function index()
    {
        return view('correr_vto_servicios');
    }

    public function correrVto(Request $request)
    {
        $ventasRepo = new VentasRepo();
        $elem = $request->all();
        $id = $elem['id'];
        $dias = $elem['dias'];
        $venta = $ventasRepo->findWithCuotas($id);

        $venta->correrVto($dias);

    }
}
