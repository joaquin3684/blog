<?php

namespace App\Http\Controllers;

use App\Imputacion;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
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

            if($request['formaCobro'] == 'banco')
            {
                GeneradorDeAsientos::crear($request['idBanco'], $request['valor'], 0, $request['codigoBanco']);
            }
            else if($request['formaCobro'] == 'caja')
            {
                $caja = Imputacion::where('nombre', 'Caja - Efectivo')->first();
                GeneradorDeAsientos::crear($caja->id, $request['valor'], 0, 111010101);
            }
            if($request['tipo'] == 'servicios')
            {
                GeneradorDeAsientos::crear($request['idDeudor'], 0, $request['valor'], $request['codigoDeudor']);
            }
            else if($request['tipo'] == 'cuotas_sociales')
            {
                GeneradorDeAsientos::crear($request['idDeudor'], 0, $request['valor'], $request['codigoDeudor']);
            }//todo: aca falta la cuenta de imputacion para las cuotas sociales
        });
    }
}
