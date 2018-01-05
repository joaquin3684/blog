<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/01/18
 * Time: 20:30
 */
$factory->define(App\Operacion::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->firstName(),
        'entrada' => 1,
        'salida'  => 0,

    ];
});