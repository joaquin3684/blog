<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/08/17
 * Time: 02:08
 */
$factory->define(App\Productos::class, function (Faker\Generator $faker) {

    return [
        'id_proovedor' => $faker->numberBetween(1,10),
        'nombre' => $faker->name,
        'ganancia' => 10,
        'tasa' => $faker->numberBetween(0, 100),
        'tipo' => 'Producto'
    ];
});

$factory->state(App\Productos::class, 'Credito', function(Faker\Generator $faker){

    return [
        'id_proovedor' => $faker->numberBetween(1,10),
        'nombre' => $faker->name,
        'ganancia' => 10,
        'tasa' => $faker->numberBetween(0, 100),
        'tipo' => 'Credito'
    ];
});