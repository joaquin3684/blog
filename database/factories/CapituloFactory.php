<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:51
 */
$factory->define(App\Capitulo::class, function (Faker\Generator $faker) {

    return [
        'codigo' => 1,
        'nombre' => 'prueba',
        'afecta_codigo_base' => 1,
    ];
});