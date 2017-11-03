<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 02/11/17
 * Time: 12:16
 */
use Carbon\Carbon;

$factory->define(App\SaldosCuentas::class, function (Faker\Generator $faker) {

    $fechaHoy = Carbon::today();

    return [
        'id_imputacion' => 1,
        'saldo' => 0,
        'year' => $fechaHoy->year,
        'month' => $fechaHoy->month,
        'codigo' => 1,
    ];
});