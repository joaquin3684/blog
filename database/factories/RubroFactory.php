<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:51
 */
$factory->define(App\Rubro::class, function (Faker\Generator $faker) {

    return [
        'id_capitulo' => 1,
        'codigo' => 1,
        'nombre' => 'prueba',
    ];
});