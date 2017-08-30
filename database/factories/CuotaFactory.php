<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/08/17
 * Time: 01:46
 */
use Carbon\Carbon;

$factory->define(App\Cuotas::class, function (Faker\Generator $faker) {

    $vto = Carbon::today()->addMonth();
    $hoy = Carbon::today();
    return [
        'cuotable_id' => 1,
        'cuotable_type' => 'App\Ventas',
        'fecha_inicio' => $hoy->toDateString(),
        'fecha_vencimiento' => $vto->toDateString(),
        'nro_cuota' => 1,
        'importe' => 100,
    ];
});

$factory->state(App\Cuotas::class, 'cuotas sociales', function(Faker\Generator $faker){

    $vto = Carbon::today()->addMonth();
    $hoy = Carbon::today();

    return [
        'cuotable_id' => 1,
        'cuotable_type' => 'App\Socios',
        'fecha_inicio' => $hoy->toDateString(),
        'fecha_vencimiento' => $vto->toDateString(),
        'nro_cuota' => 1,
        'importe' => 100,
    ];
});