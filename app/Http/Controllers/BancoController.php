<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionBanco;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\BancoGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $gateway;

    public function __construct()
    {
        $this->gateway = new BancoGateway();
    }


    public function index()
    {
        return view('ABM_bancos');
    }


    public function store(Request $request)
    {
        DB::transaction(function() use ($request){
            $this->gateway->create($request->all());
            $codigoBase = ConfigImputaciones::find(4);
            $codigo = ImputacionGateway::obtenerCodigoNuevo($codigoBase->codigo_base);
            GeneradorDeCuentas::generar('Banco '.$request['nombre'], $codigo);
        });
    }

    public function show($id)
    {
        return $this->gateway->find($id);
    }


    public function update(Request $request, $id)
    {
        return $this->gateway->update($request->all(), $id);
    }


    public function destroy($id)
    {
        $this->gateway->destroy($id);
    }

    public function all()
    {
        return $this->gateway->all();
    }
}
