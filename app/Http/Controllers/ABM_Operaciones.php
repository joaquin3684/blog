<?php

namespace App\Http\Controllers;

use App\Operacion;
use Illuminate\Http\Request;

class ABM_Operaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ABM_operaciones');
    }

    public function store(Request $request)
    {
        $op = Operacion::create($request->all());
        $op->imputaciones()->attach($request['imputacion1'], $request->all());
        $op->imputaciones()->attach($request['imputacion2'], $request->all());

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Operacion::with('imputaciones')->find($id);
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
        $op = Operacion::find($id);
        $op->fill($request->all())->save();
        $op->pivot->debe = $request['debe'];
        $op->pivot->haber = $request['haber'];
        $op->pivot->save();
    }

    public function all()
    {
        return Operacion::all();
    }

}
