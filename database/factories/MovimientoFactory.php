<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/18
 * Time: 23:15
 */
$factory->define(App\Movimientos::class, function (Faker\Generator $faker) {

    return [
        'id_cuota' => 1,
        'entrada' => 100,
        'salida' => 0,
        'fecha' => \Carbon\Carbon::today()->toDateString(),
        'ganancia' => 0,
        'contabilizado_entrada' => 0,
        'contabilizado_salida' => 0


    ];
});