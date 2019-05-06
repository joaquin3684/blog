<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\CalcularSaldos;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Services\AsientoService;
use App\Services\ImputacionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsientosController extends Controller
{

    private $gateway;
    private $imputacionService;
    private $asientoService;

    public function __construct(ImputacionService $imputacionService, AsientoService $asientoService)
    {
        $this->imputacionService = $imputacionService;
        $this->asientoService = $asientoService;
    }

    public function index()
    {
        return view('asientosManuales');
    }

    public function store(Request $request)
    {
         DB::transaction(function() use ($request){
            $this->asientoService->crear($request['asientos'], $request['observacion'], $request['fecha_valor']);
        });
    }

    public function show($id)
    {
        return $this->asientoService->find($id);
    }

    public function update(Request $request)
    {
        DB::transaction(function() use ($request){
           $this->asientoService->modificar($request['asientos'], $request['observacion'], $request['nro_asiento'], $request['fecha_valor']);
        });
    }

    public function delete(Request $request)
    {
        DB::transaction(function() use ($request){
            $this->asientoService->borrar($request['nro_asiento']);
        });
    }

    public function renumerar(Request $request)
    {
        DB::transaction(function() use ($request){
            $this->asientoService->renumerar($request['fecha']);
        });
    }

    public function findFromNumero($nroAsiento)
    {
        return $this->asientoService->findFromNumero($nroAsiento);
    }

}
