<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/09/17
 * Time: 13:41
 */
$factory->define(App\Socios::class, function (Faker\Generator $faker) {

    return [
        'id_organismo' => $faker->numberBetween(1,3),
        'cuit' => $faker->randomNumber(8),
        'dni' => $faker->randomNumber(8),
        'fecha_nacimiento' => $faker->date(),
        'domicilio' => $faker->address,
        'localidad' => $faker->city,
        'codigo_postal' => $faker->randomNumber(4),
        'telefono' => $faker->randomNumber(8),
        'legajo' => $faker->randomNumber(3),
        'nombre' => $faker->name,
    ];
});
