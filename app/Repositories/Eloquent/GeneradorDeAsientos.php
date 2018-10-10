<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/10/17
 * Time: 20:04
 */

namespace App\Repositories\Eloquent;


use App\Ejercicio;
use App\Exceptions\EjercicioCerradoException;
use App\Repositories\Eloquent\Repos\Gateway\AsientosGateway;
use Carbon\Carbon;

class GeneradorDeAsientos
{
    public static function crear($cuenta, $debe, $haber, $fechaValor = null)
    {
        $debeNuevo = $debe == null ? 0 : $debe;
        $haberNuevo = $haber == null ? 0 : $haber;
        $gate = new AsientosGateway();
        $ultimoAsiento = $gate->last();
        $nroAsiento = $ultimoAsiento->nro_asiento + 1;
        $fecha = new ControlFechaContable();
        $fechaContable = $fecha->getFechaContable();
        $fechaVal = $fechaValor == null ? $fechaContable : Carbon::createFromFormat('Y-m-d', $fechaValor);
        $asientos = new AsientosGateway();
        $ejercicio = Ejercicio::where('fecha', '<', $fechaVal->toDateString())
                        ->where('fecha_cierre', null)
                        ->orderBy('id', 'desc')
                        ->first();

        if($ejercicio == null)
        {
            throw new EjercicioCerradoException('ejercicio_cerrado');
        }
        $asientos->create(['id_imputacion' => $cuenta->id, 'nombre' => $cuenta->nombre, 'codigo' => $cuenta->codigo, 'debe' => $debeNuevo, 'haber' => $haberNuevo, 'id_ejercicio' => $ejercicio->id, 'fecha_contable' => $fechaContable->toDateString(), 'fecha_valor' => $fechaVal->toDateString(), 'nro_asiento' => $nroAsiento]);
        CalcularSaldos::modificarSaldo($cuenta, $fechaVal, $debeNuevo, $haberNuevo);
    }
}