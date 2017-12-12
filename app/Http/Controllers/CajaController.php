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
        // data { tipoOperacion: caja o banco, valor: 12, id_operacion: 1, observacion: laskjdf, transferencia: 1 si es transferencia 0 si es cheque, id_banco: 1516 o null, id_chequera: 65 o null, nro_cheque: 1 }

        DB::transaction(function() use ($request){

            $id_operacion = $request['id_operacion'];
            $tipo = $request['tipoOperacion'];
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
            if($tipo == "caja")
            {
                if($operacion->entrada)
                {
                    CajaOperaciones::create(['observacion' => $request['observacion'], 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => $valor, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);
                } else {
                    CajaOperaciones::create(['observacion' => $request['observacion'], 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => 0, 'salida' => $valor, 'fecha' => Carbon::today()->toDateString()]);

                }
            }
            else if($tipo == "banco")
            {
                if($operacion->entrada)
                {
                    if(!$request['transferencia'])
                    {
                        CajaOperaciones::create(['observacion' => $request['observacion'], 'operacion_type' => $tipo,'id_banco' => $request['id_banco'], 'id_chequera' => $request['id_chequera'], 'nro_cheque' => $request['nro_cheque'], 'transferencia' => 0, 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => $valor, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);
                    } else {
                        CajaOperaciones::create(['observacion' => $request['observacion'],'transferencia' => 1, 'id_banco' => $request['id_banco'], 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => $valor, 'salida' => 0, 'fecha' => Carbon::today()->toDateString()]);

                    }
                } else {
                    if(!$request['transferencia'])
                    {
                        CajaOperaciones::create(['observacion' => $request['observacion'],'operacion_type' => $tipo,'id_banco' => $request['id_banco'], 'id_chequera' => $request['id_chequera'], 'nro_cheque' => $request['nro_cheque'], 'transferencia' => 0, 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => 0, 'salida' => $valor, 'fecha' => Carbon::today()->toDateString()]);
                    } else {
                        CajaOperaciones::create(['observacion' => $request['observacion'],'transferencia' => 1, 'id_banco' => $request['id_banco'], 'operacion_type' =>  $tipo, 'id_operacion' => $id_operacion, 'entrada' => 0, 'salida' => $valor, 'fecha' => Carbon::today()->toDateString()]);

                    }
                }
            }


        });
    }


    public function all(Request $request)
    {

        // data { banco: 1 si lo elijio sino nada, caja: igual que banco, fecha_desde: 2017-03-02, fecha_hasta: 2017-02-05}
        if(!isEmpty($request['banco']) && isEmpty($request['caja']))
        {
            $operaciones = CajaOperaciones::with('operacion')
                ->where('fecha', '>=', $request['fecha_desde'])
                ->where('fecha', '<=', $request['fecha_hasta'])
                ->where('operacion_type', 'banco')
                ->get()->groupBy('fecha');
        }
        else if(!isEmpty($request['caja']) && isEmpty($request['banco']))
        {
            $operaciones = CajaOperaciones::with('operacion')
                ->where('fecha', '>=', $request['fecha_desde'])
                ->where('fecha', '<=', $request['fecha_hasta'])
                ->where('operacion_type', 'caja')
                ->get()->groupBy('fecha');
        }
        else
        {
            $operaciones = CajaOperaciones::with('operacion')
                ->where('fecha', '>=', $request['fecha_desde'])
                ->where('fecha', '<=', $request['fecha_hasta'])
                ->get()->groupBy('fecha');
        }

        $op = collect();
        $operaciones->each(function($operacion, $key) use (&$op){
            $opAux = collect();
            $opAux->put('fecha', $key);
            $opAux->put('cajaOperacion',$operacion);
            $op->push($opAux);
        });
        return $op;

    }
}
