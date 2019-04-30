<?php

namespace App\Http\Controllers;

use App\ConfigImputaciones;
use App\Http\Requests\ValidacionBanco;
use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\BancoGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;

use App\Services\BancoService;
use App\Services\ImputacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BancoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $bancoService, $imputacionService;

    public function __construct()
    {
        $this->bancoService = new BancoService();
        $this->imputacionService = new ImputacionService();
    }


    public function index()
    {
        return view('ABM_bancos');
    }


    public function store(Request $request)
    {
        DB::transaction(function() use ($request){
            $this->bancoService->crear($request['nombre'], $request['sucursal'], $request['direccion'], $request['nro_cuenta']);
            $codigo = $this->imputacionService->obtenerCodigoNuevo('1110102');
            $this->imputacionService->crear($codigo, 'Banco '.$request['nombre'], 1);
        });
    }

    public function show($id)
    {
        return $this->bancoService->find($id);
    }


    public function update(Request $request, $id)
    {
        return $this->bancoService->update($request->all(), $id);
    }


    public function destroy($id)
    {
        $this->bancoService->destroy($id);
    }

    public function all()
    {
        return $this->bancoService->all();
    }
}
