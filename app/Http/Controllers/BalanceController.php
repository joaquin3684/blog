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
            ->select(DB::raw('SUM(asientos.debe) as totalDebe, SUM(asientos.haber) as totalHaber, (SUM(asientos.debe) - SUM(asientos.haber)) as saldo'), 'asientos.codigo', 'imputaciones.nombre')
            ->orderBy('codigo')
            ->get();


            return $saldosInicialesCuentas->map(function ($saldo) use ($imputaciones) {
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
            });

    }
}
