<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 29/08/18
 * Time: 15:56
 */

namespace App\Services;


use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;

class VentasService
{
    public function crearVenta($elem){


        $venta = new Ventas($elem);
        $venta->crear();
    }

    public function cobrar($elem)
    {
        foreach($elem as $venta)
        {
            $ven = Ventas::with(['cuotas' => function($q) {

                    $q->with('movimientos')
                    ->orderBy('nro_cuota');
            }], 'producto')->find($venta['id']);

            $ven->cobrar($venta['monto']);

        }
    }
}