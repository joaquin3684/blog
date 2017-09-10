<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/17
 * Time: 16:21
 */

namespace App\Repositories\Eloquent\Generadores;


use App\Repositories\Eloquent\Repos\VentasRepo;

class GeneradorNumeroCredito
{
    public static function generar($venta)
    {
        $ventasRepo = new VentasRepo();
        $nro_credito = $ventasRepo->findLastCredito();
        $nro_creditoFinal = $nro_credito + 1;
        $ventasRepo->update(['nro_credito' => $nro_creditoFinal], $venta->getId());
        $venta->setNroCredito($nro_creditoFinal);
    }
}