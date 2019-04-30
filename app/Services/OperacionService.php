<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 23/04/19
 * Time: 10:45
 */

namespace App\Services;


use App\Operacion;

class OperacionService
{

    public function crear($nombre, $entrada, $salida, $imputaciones)
    {
        $op = Operacion::create(['nombre' => $nombre, 'entrada' => $entrada, 'salida' => $salida]);
        $op->imputaciones()->attach($imputaciones[0]['imputacion'], ['debe' => $imputaciones[0]['debe'], 'haber' => $imputaciones[0]['haber']]);
        $op->imputaciones()->attach($imputaciones[1]['imputacion'], ['debe' => $imputaciones[1]['debe'], 'haber' => $imputaciones[1]['haber']]);
    }

    public function find($id)
    {
        return Operacion::with('imputaciones')->find($id);
    }
}