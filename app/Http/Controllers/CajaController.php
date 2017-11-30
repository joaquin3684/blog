<?php

namespace App\Http\Controllers;

use App\CajaOperaciones;
use App\Operacion;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('caja');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::transaction(function() use ($request){

            $id_operacion = $request['id_operacion'];
            $valor = $request['valor'];
            $operacion = Operacion::with('imputaciones')->find($id_operacion);
            $operacion->imputaciones->each(function($imputacion) use ($valor){

                if($imputacion->pivot->debe)
                {
                    GeneradorDeAsientos::crear($imputacion, $valor, 0);
                } else {
                    GeneradorDeAsientos::crear($imputacion, 0, $valor);
                }
            });
            if($operacion->entrada)
            {
                CajaOperaciones::create(['id_operacion' => $id_operacion, 'entrada' => $valor, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);
            } else {
                CajaOperaciones::create(['id_operacion' => $id_operacion, 'entrada' => 0, 'salida' => $valor, 'fecha' => Carbon::today()->toDateString()]);

            }
        });
    }


    public function all(Request $request)
    {
        return CajaOperaciones::with('operacion')
            ->where('fecha', '>=', $request['fecha_desde'])
            ->where('fecha', '>=', $request['fecha_hasta'])
            ->get()->groupBy('fecha');
    }
}
