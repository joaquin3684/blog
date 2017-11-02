<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/11/17
 * Time: 12:08
 */

namespace App\Repositories\Eloquent;


use App\SaldosCuentas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CalcularSaldos
{
    public static function modificarSaldo($id_imputacion, $fechaValor)
    {
        $fecha = $fechaValor == null ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $fechaValor);
        $saldo = DB::table('asientos')
            ->where('id_imputacion', $id_imputacion)
            ->groupBy('id_imputacion')
            ->select(DB::raw('(SUM(debe) - SUM(haber)) as saldo'))->first();

        $cuenta = SaldosCuentas::where('id_imputacion', $id_imputacion)
            ->where('year', $fecha->year)
            ->where('month', $fecha->month)
            ->first();
        $cuenta->fill(['saldo' => $saldo->saldo])->save();

    }
}