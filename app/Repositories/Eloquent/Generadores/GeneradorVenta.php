<?php

namespace App\Repositories\Eloquent\Generadores;

use App\Repositories\Eloquent\Generadores\GeneradorNumeroCredito;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/09/17
 * Time: 14:25
 * @property VentasRepo ventaRepo
 */
class GeneradorVenta
{



    public static function generarVenta($socio, $producto, $cuotas, $montoPorCuota)
    {
        $ventaRepo = new VentasRepo();
        $fechaVto = Carbon::today()->addMonths(2);
        $venta = $ventaRepo->create([
            'id_asociado' => $socio,
            'id_producto' => $producto->getId(),
            'nro_cuotas' => $cuotas,
            'importe' => $montoPorCuota * $cuotas,
            'fecha_vencimiento' => $fechaVto->toDateString(),
        ]);
        GeneradorNumeroCredito::generar($venta);
        return GeneradorCuotas::generarCuotasVenta($venta);

    }

}