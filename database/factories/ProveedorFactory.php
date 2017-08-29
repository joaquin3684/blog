<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/08/17
 * Time: 13:26
 */
$factory->define(App\Proovedores::class, function (Faker\Generator $faker) {

    return [
        'razon_social' => $faker->company,
        'cuit' => $faker->randomNumber(8),
        'domicilio' => $faker->address,
        'telefono' => $faker->randomNumber(8),
        'descripcion' => $faker->realText(100, 3),
        'id_prioridad' => 1,
        'usuario' => 1,
    ];
});

$factory->state(App\Proovedores::class, 'prioridad 2', function(Faker\Generator $faker){

    return [
        'razon_social' => $faker->company,
        'cuit' => $faker->randomNumber(8),
        'domicilio' => $faker->address,
        'telefono' => $faker->randomNumber(8),
        'descripcion' => $faker->realText(100, 3),
        'id_prioridad' => 2,
        'usuario' => 1,
    ];
});