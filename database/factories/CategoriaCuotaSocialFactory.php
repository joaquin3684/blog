<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 13/04/18
 * Time: 18:58
 */
$factory->define(App\CategoriaCuotaSocial::class, function (Faker\Generator $faker) {

    return [
        'id_organismo' => 1,
        'categoria' => 0,
        'valor' => 100
    ];
});