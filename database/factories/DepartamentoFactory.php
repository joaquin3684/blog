<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:53
 */
use Carbon\Carbon;

$factory->define(App\Departamento::class, function (Faker\Generator $faker) {

    return [
        'id_moneda' => 1,
        'codigo' => 1,
        'nombre' => 'prueba',
        'afecta_codigo_base' => 1,

    ];
});

