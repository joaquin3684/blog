<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/11/17
 * Time: 18:13
 */

namespace App\Repositories\Eloquent\Contabilidad;


use App\Imputacion;
use App\Repositories\Eloquent\ControlFechaContable;
use App\SaldosCuentas;
use App\SubRubro;

class GeneradorDeCuentas
{
    public static function generar($nombre, $codigo)
    {
        $fechaOperativa = new ControlFechaContable();
        $fecha = $fechaOperativa->getFechaContable();
        $codigoSubRubro = substr((string) $codigo, 0, -2);
        $subRubro = SubRubro::where('codigo', $codigoSubRubro)->first();
        $imputacion = Imputacion::create(['nombre' => $nombre, 'codigo' => $codigo, 'id_subrubro' => $subRubro->id]);
        SaldosCuentas::create(['saldo' => 0, 'year' => $fecha->year, 'month' => $fecha->month, 'codigo' => $imputacion->codigo, 'id_imputacion' => $imputacion->id, 'nombre' => $imputacion->nombre]);
        return $imputacion;
    }
}