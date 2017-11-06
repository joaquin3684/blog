<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidacionImputacion;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\SaldosCuentas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Imputacion extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $gateway;

    public function __construct()
    {
        $this->gateway = new ImputacionGateway();
    }


    public function index()
    {
        return view('ABM_Imputacion');
    }


    public function store(ValidacionImputacion $request)
    {
        DB::transaction(function() use ($request){
            $cuenta = $this->gateway->create($request->all());
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
    public function update(ValidacionImputacion $request, $id)
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
