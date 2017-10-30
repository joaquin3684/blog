<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/10/17
 * Time: 21:54
 */
$factory->define(App\Imputacion::class, function (Faker\Generator $faker) {

    return [
        'id_subrubro' => 1,
        'codigo' => 1,
        'nombre' => 'prueba',
    ];
});