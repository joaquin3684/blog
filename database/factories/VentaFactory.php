<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/08/17
 * Time: 01:40
 */
use Carbon\Carbon;

$factory->define(App\Ventas::class, function (Faker\Generator $faker) {

    $vto = Carbon::today()->addMonths(5);
    return [
        'id_asociado' => 1,
        'id_producto' => 1,
        'nro_cuotas' => 5,
        'importe_total' => 1250,
        'importe_otorgado' => 1000,
        'importe_cuota' => 250,
        'fecha_vencimiento' => $vto->toDateString(),
    ];
});

$factory->state(App\Ventas::class, 'vencida 3 meses', function(Faker\Generator $faker){

    $vto = Carbon::today()->subMonths(3);
    return [
        'id_asociado' => 1,
        'id_producto' => 1,
        'nro_cuotas' => 5,
        'importe_total' => 500,
        'importe_otorgado' => 500,
        'importe_cuota' => 500,
        'fecha_vencimiento' => $vto->toDateString(),
    ];

});

$factory->state(App\Ventas::class, 'vencida 2 meses', function(Faker\Generator $faker){

    $vto = Carbon::today()->subMonths(2);
    return [
        'id_asociado' => 1,
        'id_producto' => 1,
        'nro_cuotas' => 5,
        'importe_total' => 500,
        'importe_otorgado' => 500,
        'importe_cuota' => 500,
        'fecha_vencimiento' => $vto->toDateString(),
    ];

});