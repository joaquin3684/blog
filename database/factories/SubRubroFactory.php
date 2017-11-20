<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:53
 */
$factory->define(App\SubRubro::class, function (Faker\Generator $faker) {

    return [
        'id_departamento' => 1,
        'codigo' => 1,
        'nombre' => 'prueba',
        'afecta_codigo_base' => 1,

    ];
});