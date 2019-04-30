<?php

namespace App\Http\Controllers;

use App\CajaOperaciones;
use App\Operacion;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Services\AsientoService;
use App\Services\CajaService;
use App\Services\OperacionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CajaController extends Controller
{
    private $asientoService, $cajaService, $operacionService;

    public function __construct(AsientoService $asientoService, CajaService $cajaService, OperacionService $operacionService)
    {
        $this->asientoService = $asientoService;
        $this->cajaService = $cajaService;
        $this->operacionService = $operacionService;
    }

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
            $tipo = $request['tipoOperacion'];
            $valor = $request['valor'];
            $operacion = $this->operacionService->find($id_operacion);

            $cuentas = array();
            foreach ($operacion->imputaciones as $imputacion){

                if($imputacion->pivot->debe)
                {
                    $a = ['cuenta' => $imputacion->codigo, 'debe' => $valor, 'haber' => 0];
                    array_push($cuentas, $a);
                } else {
                    $a = ['cuenta' => $imputacion->codigo, 'debe' => 0, 'haber' => $valor];
                    array_push($cuentas, $a);
                }
            }

            $this->asientoService->crear($cuentas);
            $this->cajaService->crear($operacion->entrada, $request['observacion'], $tipo, $id_operacion, $valor, Carbon::today()->toDateString(), $request['id_banco'], $request['id_chequera'], $request['nro_cheque'], $request['transferencia']);




        });
    }


    public function all(Request $request)
    {

        // data { banco: 1 si lo elijio sino nada, caja: igual que banco, fecha_desde: 2017-03-02, fecha_hasta: 2017-02-05}
        if(!empty($request['banco']) && empty($request['caja']))
        {
            $operaciones = CajaOperaciones::with('operacion')
                ->where('fecha', '>=', $request['fecha_desde'])
                ->where('fecha', '<=', $request['fecha_hasta'])
                ->where('operacion_type', 'banco')
                ->get()->groupBy('fecha');
        }
        else if(!empty($request['caja']) && empty($request['banco']))
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
