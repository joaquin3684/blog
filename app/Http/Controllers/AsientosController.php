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

            foreach($request['asientos'] as $elem){
                $cuenta = $this->imputacionService->find($elem['id_imputacion']);
                $elem['cuenta'] = $cuenta->codigo;
                $this->asientoService->crear($elem);
            }
        });
    }

    public function show($id)
    {
        return $this->gateway->find($id);
    }

    public function all()
    {
        return $this->gateway->all();
    }
}
