<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CobrarContablemente extends Controller
{
    public function index()
    {
        return view('cobrar_contablemente');
    }

    public function traerBancos()
    {
        return ImputacionGateway::traerBancos();
    }

    public function traerProveedores()
    {
        return ImputacionGateway::traerDeudores();
    }

    public function cobrar(Request $request)
    {
        DB::transaction(function() use ($request){
            $asientos = new AsientosGateway();
            if($request['formaCobro'] == 'Banco')
            {
                $asientos->create(['id_imputacion' => $request['codigo'], 'debe' => $request['valor']]);
            }
            else if($request['formaCobro'] == 'Caja')
            {
                $asientos->create(['id_imputacion' => '111010101', 'debe' => $request['valor']]);
            }
            if($request['tipo'] == 'Servicios')
            {
                $asientos->create(['id_imputacion' => $request['codigoDeudor'], 'haber' => $request['valor']]);
            }
            else if($request['tipo'] == 'Cuotas sociales')
            {
                $asientos->create(['id_imputacion' => $request['codigoDeudor'], 'haber' => $request['valor']]);
            }
        });
    }
}
