<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/17
 * Time: 19:48
 */
$factory->define(App\Prioridades::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'nombre' => 'Alta',
        'orden' => 1
    ];
});

$factory->state(App\Prioridades::class, 'baja', function(Faker\Generator $faker){
    return [
        'nombre' => 'Baja',
        'orden' => 2
    ];
});