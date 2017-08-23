<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 23/08/17
 * Time: 14:17
 */

$factory->define(App\Solicitud::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'id_socio' => 1,
        'comercializador' => 1,
        'agente_financiero' => 1,
        'estado' => 'Inversionista Asignado',
        'total' => null,
        'monto_por_cuota' => null,
        'cuotas' => null,
        'doc_endeudamiento' => '1',
    ];
});

$factory->state(App\Solicitud::class, 'Modificada por Comercializador', function(Faker\Generator $faker){
   return [
       'total' => 100,
       'monto_por_cuota' => 120,
       'cuotas' => 5,
       'estado' => 'Modificada por Comercializador',

   ];
});