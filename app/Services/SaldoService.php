<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 22/04/19
 * Time: 12:47
 */

namespace App\Services;


use App\SaldosCuentas;
use Carbon\Carbon;

class SaldoService
{
    public function modificar($cuenta, Carbon $fecha, $debe, $haber)
    {
        $saldo = SaldosCuentas::where('id_imputacion', $cuenta->id)
            ->where('year', $fecha->year)
            ->where('month', $fecha->month)
            ->first();

        if($saldo == null)
            $this->crear($cuenta, $debe, $haber);
        else
            $saldo->fill(['saldo' => $saldo->saldo + $debe - $haber])->save();

    }

    public function crear($cuenta, $debe, $haber)
    {
        $fecha = Carbon::today();
        SaldosCuentas::create(['codigo' => $cuenta->codigo, 'id_imputacion' => $cuenta->id, 'saldo' => $debe - $haber, 'year' => $fecha->year, 'month' => $fecha->month]);
    }
}