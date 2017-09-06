<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 09/06/17
 * Time: 14:53
 */

namespace App\Repositories\Eloquent\Cobranza;


use App\Exceptions\MasPlataCobradaQueElTotalException;

class CobrarCuotasSociales
{
    public function cobrar($socio, $monto)
    {
        if($socio->montoAdeudadoCuotasSociales() < $monto)
            throw new MasPlataCobradaQueElTotalException('exceso_de_plata');

        $socio->getCuotasSociales()->each(function($cuota) use (&$monto){
            if($monto == 0)
                return false;
            $cobrado = $cuota->cobrar($monto);
            $monto -= $cobrado;
        });
    }
}