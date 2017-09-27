<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Repos\Gateway\DepartamentoGateway;
use Illuminate\Http\Request;

class ABM_Departamento extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $gateway;

    public function __construct()
    {
        $this->gateway = new DepartamentoGateway();
    }


    public function index()
    {
        return view('ABM_departamentos');
    }


    public function store(Request $request)
    {
        return $this->gateway->create($request->all());
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
    public function update(Request $request, $id)
    {
        return $this->gateway->find($id);
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
