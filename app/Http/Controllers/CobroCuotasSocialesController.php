<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Cobranza\CobrarCuotasSociales;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Illuminate\Http\Request;

class CobroCuotasSocialesController extends Controller
{
    public function index()
    {
        return view('cobro_cuotas_sociales');
    }

    public function cobrar(Request $request)
    {
        foreach ($request->all() as $elem)
        {
            $id_socio = $elem['id'];
            $monto = $elem['cobro'];
            $socioRepo = new SociosRepo();
            $socio = $socioRepo->cuotasSocialesVencidas($id_socio);
            $cobrarObj = new CobrarCuotasSociales();
            $cobrarObj->cobrar($socio, $monto);
        }
    }
}
