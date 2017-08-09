<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 22:41
 */

namespace App\Repositories\Eloquent\Cobranza;

class CobrarPorVenta
{
    public function cobrar($venta, $monto)
    {

        $cuotas = $venta->cuotasVencidas();
        $cuotas->each(function ($cuota) use (&$monto){
            if($monto == 0)
                return false;
          $cobrado = $cuota->cobrar($monto);
          $monto -= $cobrado;
        });
    }
}