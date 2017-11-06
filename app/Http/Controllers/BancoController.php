<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionBanco;
use App\Imputacion;
use App\Repositories\Eloquent\Repos\Gateway\BancoGateway;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\SaldosCuentas;
use Carbon\Carbon;
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


    public function store(ValidacionBanco $request)
    {
        DB::transaction(function() use ($request){
            $this->gateway->create($request->all());
            $codigo = ImputacionGateway::obtenerCodigoNuevo('1110102');
            $cuenta = Imputacion::create(['nombre' => 'Banco '.$request['nombre'], 'codigo' => $codigo]);
            $fecha = Carbon::today();
            SaldosCuentas::create(['codigo' => $cuenta->codigo, 'id_imputacion' => $cuenta->id, 'saldo' => 0, 'year' =>$fecha->year, 'month' => $fecha->month]);

        });
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->gateway->find($id);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ValidacionBanco $request, $id)
    {
        return $this->gateway->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->gateway->destroy($id);
    }

    public function all()
    {
        return $this->gateway->all();
    }
}
