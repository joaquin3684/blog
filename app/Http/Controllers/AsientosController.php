<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\CalcularSaldos;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsientosController extends Controller
{

    private $gateway;

    public function __construct()
    {
        $this->gateway = new AsientosGateway();
    }

    public function index()
    {
        return view('asientosManuales');
    }

    public function store(Request $request)
    {
        DB::transaction(function() use ($request){
            foreach($request['asientos'] as $elem){
               GeneradorDeAsientos::crear($elem['id_imputacion'], $elem['debe'], $elem['haber'], $elem['codigo'], $request['fecha_valor']);
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
