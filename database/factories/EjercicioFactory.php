<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 14:13
 */

use Carbon\Carbon;

$factory->define(App\Ejercicio::class, function (Faker\Generator $faker) {

    $fecha = Carbon::today()->subMonth()->toDateString();

    return [
        'fecha_cierre' => null,
        'fecha' => $fecha,
    ];
});

$factory->state(App\Ejercicio::class, 'ejercicio cerrado', function(Faker\Generator $faker){

    $fecha = Carbon::today()->subMonth()->toDateString();
    $fechaCierre = Carbon::today()->toDateString();

    return [
        'fecha_cierre' => $fechaCierre,
        'fecha' => $fecha,
    ];
});