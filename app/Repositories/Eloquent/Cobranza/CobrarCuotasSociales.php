<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 09/06/17
 * Time: 14:53
 */

namespace App\Repositories\Eloquent\Cobranza;


class CobrarCuotasSociales
{
    public function cobrar($socio, $monto)
    {
        $socio->cuotasSocialesVencidas()->each(function($cuota) use (&$monto){
            if($monto == 0)
                return false;
            $cobrado = $cuota->cobrar($monto);
            $monto -= $cobrado;
        });
    }
}