<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 14:35
 */
use Carbon\Carbon;

$factory->define(App\Asiento::class, function (Faker\Generator $faker) {

    $fecha = Carbon::today()->toDateString();
     return [
        'id_imputacion' => 1,
         'debe' => 0,
         'haber' => 0,
         'fecha_contable' => $fecha,
         'nro_asiento' => 1,
         'id_ejercicio' => 1,
         'fecha_valor' => $fecha,
         'codigo' => 1,
    ];
});

