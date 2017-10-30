<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:51
 */
$factory->define(App\Moneda::class, function (Faker\Generator $faker) {

    return [
        'id_rubro' => 1,
        'codigo' => 1,
        'nombre' => 'prueba',
    ];
});