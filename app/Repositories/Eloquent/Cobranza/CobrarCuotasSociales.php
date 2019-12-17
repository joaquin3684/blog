<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 09/06/17
 * Time: 14:53
 */

namespace App\Repositories\Eloquent\Cobranza;


use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Repositories\Eloquent\Cuota;

class CobrarCuotasSociales
{
    public function cobrar($socio, $monto)
    {
        if($socio->montoAdeudadoCuotasSociales() < $monto)
            throw new MasPlataCobradaQueElTotalException('exceso_de_plata');

        // aca no llegan cutas sociales
        $socio->getCuotasSociales()->each(function(Cuota $cuota) use (&$monto){
            if($monto == 0)
                return false;
            $cobrado = $cuota->cobrar($monto);
            $monto -= $cobrado;
        });
    }
}