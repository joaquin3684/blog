<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/10/17
 * Time: 20:04
 */

namespace App\Repositories\Eloquent;


use App\Ejercicio;
use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use Carbon\Carbon;

class GeneradorDeAsientos
{
    public static function crear($cuenta, $debe, $haber, $codigo, $fechaValor = null)
    {
        $debeNuevo = $debe == null ? 0 : $debe;
        $haberNuevo = $haber == null ? 0 : $haber;
        $gate = new AsientosGateway();
        $ultimoAsiento = $gate->last();
        $nroAsiento = $ultimoAsiento->nro_asiento + 1;
        $fechaVal = $fechaValor == null ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $fechaValor);
        $fecha = new ControlFechaContable();
        $fechaContable = $fecha->fechaContable;
        $asientos = new AsientosGateway();
        $ejercicio = Ejercicio::where('fecha', '<', $fechaContable)->orderBy('id', 'desc')->first();
        $asientos->create(['id_imputacion' => $cuenta, 'codigo' => $codigo, 'debe' => $debeNuevo, 'haber' => $haberNuevo, 'id_ejercicio' => $ejercicio->id, 'fecha_contable' => $fechaContable, 'fecha_valor' => $fechaVal->toDateString(), 'nro_asiento' => $nroAsiento]);
        CalcularSaldos::modificarSaldo($cuenta, $fechaVal);
    }
}