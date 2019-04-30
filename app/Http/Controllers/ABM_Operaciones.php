<?php

namespace App\Http\Controllers;

use App\Operacion;
use App\Services\OperacionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ABM_Operaciones extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $operacionService;

    public function __construct(OperacionService $operacionService)
    {
        $this->operacionService = $operacionService;
    }

    public function index()
    {
        return view('ABM_operaciones');
    }

    public function store(Request $request)
    {
        Db::transaction(function() use ($request){
            $imputaciones = [
                ['imputacion' => $request['imputacion1'], 'debe' => $request['debe1'], 'haber' => $request['haber1']],
                ['imputacion' => $request['imputacion2'], 'debe' => $request['debe2'], 'haber' => $request['haber2']]

            ];
           $this->operacionService->crear($request['nombre'], $request['entrada'], $request['salida'], $imputaciones);
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
        return $this->operacionService->find($id);
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
        $op = Operacion::with('imputaciones')->find($id);
        $op->fill($request->all());
        $op->imputaciones()->detach();
        $op->imputaciones()->attach($request['imputacion1'], ['debe' => $request['debe1'], 'haber' => $request['haber1']]);
        $op->imputaciones()->attach($request['imputacion2'], ['debe' => $request['debe2'], 'haber' => $request['haber2']]);

        $op->save();
    }

    public function all()
    {
        return Operacion::all();
    }

    public function autocomplete(Request $request)
    {
        return DB::table('operaciones')
            ->where('nombre', 'LIKE', '%'.$request['nombre'].'%')->get();
    }
}
