<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/11/17
 * Time: 14:21
 */

namespace App\Repositories\Eloquent\Contabilidad;


use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalculadorSaldoInicial
{
    public static function calcular($fechaInicio, $cuentaDesde, $cuentaHasta)
    {
        $fecha = Carbon::createFromFormat('Y-m-d', $fechaInicio);

        $saldo = DB::table('imputaciones')
            ->where('codigo','>=', $cuentaDesde)
            ->where('codigo', '<=', $cuentaHasta)
            ->select(DB::raw('0 as saldo'), 'codigo');

        $saldoCuentas = DB::table('saldos_cuentas')
            ->where('year', '<=', $fecha->year)
            ->where('month', '<', $fecha->month)
            ->where('codigo','>=', $cuentaDesde)
            ->where('codigo', '<=', $cuentaHasta)
            ->unionAll($saldo)
            ->groupBy('id_imputacion')
            ->select(DB::raw('SUM(saldo) as saldo'), 'codigo')
            ->get()->unique('codigo');

        $fecha2 = Carbon::createFromFormat('Y-m-d', $fechaInicio);
        $fecha2->day = 0;

        $saldoCuentasDiasRestantes = DB::table('asientos')
            ->where('fecha_valor', '<=', $fecha->toDateString())
            ->where('fecha_valor', '>=', $fecha2->toDateString())
            ->where('codigo','>=', $cuentaDesde)
            ->where('codigo', '<=', $cuentaHasta)
            ->unionAll($saldo)
            ->groupBy('id_imputacion')
            ->select(DB::raw('(SUM(debe) - SUM(haber)) as saldo'), 'codigo')
            ->get()->unique('codigo');


      return  $saldoInicialFinal = $saldoCuentas->map(function($item) use ($saldoCuentasDiasRestantes){
             $item->saldo = $saldoCuentasDiasRestantes->first(function($i) use ($item){
                return $i->codigo == $item->codigo;
            })->saldo + $item->saldo;
             return $item;
        });

    }

    public function calcularEnCaja($fechaInicio)
    {
        $fecha = Carbon::createFromFormat('Y-m-d', $fechaInicio);

        $saldoCuentas = DB::table('saldos_operaciones_caja')
            ->where('year', '<=', $fecha->year)
            ->where('month', '<', $fecha->month)
            ->groupBy('id_imputacion')
            ->select(DB::raw('SUM(saldo) as saldo'), 'codigo')
            ->get()->unique('codigo');

        $fecha2 = Carbon::createFromFormat('Y-m-d', $fechaInicio);
        $fecha2->day = 0;

        $saldoCuentasDiasRestantes = DB::table('asientos')
            ->where('fecha_valor', '<=', $fecha->toDateString())
            ->where('fecha_valor', '>=', $fecha2->toDateString())
            ->where('codigo','>=', $cuentaDesde)
            ->where('codigo', '<=', $cuentaHasta)
            ->unionAll($saldo)
            ->groupBy('id_imputacion')
            ->select(DB::raw('(SUM(debe) - SUM(haber)) as saldo'), 'codigo')
            ->get()->unique('codigo');
    }
}