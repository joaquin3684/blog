<?php

namespace App\Http\Controllers;

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
            $ejercicio = DB::table('ejercicios')->where('fecha_cierre', null)->first();
            foreach($request['asientos'] as $elem){
                $elem['fecha_valor'] = $request['fecha_valor'];
                $elem['fecha_contable'] = Carbon::today()->toDateString();
                $ultimoAsiento = $this->gateway->last();
                $elem['nro_asiento'] = $ultimoAsiento->nro_asiento + 1;
                $elem['id_ejercicio'] = $ejercicio->id;
                $this->gateway->create($elem);
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
