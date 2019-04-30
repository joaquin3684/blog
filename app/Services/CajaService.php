<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 22/04/19
 * Time: 15:55
 */

namespace App\Services;


use App\CajaOperaciones;

class CajaService
{
    public function crear(
                    $entrada,
                    $observacion,
                    $tipo,
                    $idOperacion,
                    $valor,
                    $fecha,
                    $idBanco = null,
                    $idChequera = null,
                    $nroCheque = null,
                    $transferencia = null
    )
    {
        if($entrada)
            CajaOperaciones::create(['observacion' => $observacion, 'operacion_type' => $tipo,'id_banco' => $idBanco, 'id_chequera' => $idChequera, 'nro_cheque' => $nroCheque, 'transferencia' => $transferencia, 'id_operacion' => $idOperacion, 'entrada' => $valor, 'salida' => 0, 'fecha' => $fecha]);
        else
            CajaOperaciones::create(['observacion' => $observacion, 'operacion_type' => $tipo,'id_banco' => $idBanco, 'id_chequera' => $idChequera, 'nro_cheque' => $nroCheque, 'transferencia' => $transferencia, 'id_operacion' => $idOperacion, 'entrada' => 0, 'salida' => $valor, 'fecha' => $fecha]);

    }
}