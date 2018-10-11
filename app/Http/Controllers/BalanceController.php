<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\Contabilidad\CalculadorSaldoInicial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
        return view('balance');
    }

    public function reporte(Request $request)
    {
        $fechaDesde = $request['fecha_desde'];
        $fechaHasta = $request['fecha_hasta'];

        $saldosInicialesCuentas = CalculadorSaldoInicial::calcular($fechaDesde, 1, 999999999);
        $imputaciones = DB::table('asientos')
            ->join('imputaciones', 'imputaciones.id', '=', 'asientos.id_imputacion')
            ->where('fecha_valor', '>', $fechaDesde)
            ->where('fecha_valor', '<', $fechaHasta)
            ->groupBy('id_imputacion')
            ->select(DB::raw('ROUND(SUM(asientos.debe),2) as totalDebe, ROUND(SUM(asientos.haber),2) as totalHaber, ROUND((SUM(asientos.debe) - SUM(asientos.haber)),2) as saldo'), 'asientos.codigo', 'imputaciones.nombre')
            ->orderBy('codigo')
            ->havingRaw('ROUND(SUM(asientos.debe),2) > 0 OR ROUND(SUM(asientos.haber),2) > 0 OR ROUND((SUM(asientos.debe) - SUM(asientos.haber)),2) > 0')

            ->get();

            $col = collect();
            $saldosInicialesCuentas->map(function ($saldo) use ($imputaciones) {
                $imputacion = $imputaciones->first(function ($imputacion) use ($saldo) {
                    return $saldo->codigo == $imputacion->codigo;
                });
                $saldo->saldoAnterior = $saldo->saldo;
                if($imputacion == null)
                {
                    $saldo->totalDebe = 0;
                    $saldo->totalHaber = 0;
                } else {
                    $saldo->totalDebe = $imputacion->totalDebe;
                    $saldo->totalHaber = $imputacion->totalHaber;
                    $saldo->saldo = $imputacion->saldo + $saldo->saldo;
                }
                return $saldo;
            })->each(function($saldo) use (&$col){
                if($saldo->totalDebe > 0 || $saldo->totalHaber > 0 || $saldo->saldo > 0)
                {
                    $col->push($saldo);
                }
            });
            return $col;

    }
}
