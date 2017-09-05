<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/09/17
 * Time: 13:40
 */
$factory->define(App\Organismos::class, function (Faker\Generator $faker) {

    return [
        'nombre' => $faker->company,
        'cuit' => $faker->randomNumber(8),
        'cuota_social' => 100,

    ];
});
