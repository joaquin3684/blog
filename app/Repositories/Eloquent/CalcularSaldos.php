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
    public static function modificarSaldo($cuenta, Carbon $fecha, $debeNuevo, $haberNuevo)
    {

        $saldo = SaldosCuentas::where('id_imputacion', $cuenta->id)
            ->where('year', $fecha->year)
            ->where('month', $fecha->month)
            ->first();

        if($saldo == null)
        {
            $fecha = Carbon::today();
            SaldosCuentas::create(['codigo' => $cuenta->codigo, 'id_imputacion' => $cuenta->id, 'saldo' => $debeNuevo - $haberNuevo, 'year' =>$fecha->year, 'month' => $fecha->month]);
        } else  {
            $saldo->fill(['saldo' => $saldo->saldo + $debeNuevo - $haberNuevo])->save();
        }

    }
}