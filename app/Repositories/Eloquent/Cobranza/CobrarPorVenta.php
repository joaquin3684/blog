<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 06/05/17
 * Time: 22:41
 */

namespace App\Repositories\Eloquent\Cobranza;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\GeneradorDeAsientos;

class CobrarPorVenta
{
    public function cobrar($venta, $monto)
    {
        if($venta->montoAdeudado() < $monto)
            throw new MasPlataCobradaQueElTotalException('exceso_de_plata');


        $cuotas = $venta->cuotasImpagas()->sortBy('nro_cuota');
        $proveedor = collect(['proveedor' => $venta->getProveedor()->getId(), 'total' => 0]);
        $cuotas->each(function ($cuota) use (&$monto, &$proveedor) {
                if ($monto == 0)
                    return false;
                $cobrado = $cuota->cobrar($monto);
                $proveedor['total'] = $proveedor['total'] + $cobrado;
                $monto -= $cobrado;
            });

        $cuenta = ProveedorImputacionDeudores::where('id_proveedor', $proveedor['proveedor'])->where('tipo', 'Deudores')->first();
        GeneradorDeAsientos::crear($cuenta->imputacion, 0, $proveedor['total']);
        GeneradorDeAsientos::crear($cuenta->imputacion, $proveedor['total'], 0);
        //TODO:: preguntar donde va a estar la cuenta puente

    }

    public function calcularMontoCobradoProveedor(&$coleccion, $cobrado)
    {
        $coleccion->transform(function($prov) use ($cobrado){
            $prov['total'] = $prov['total'] + $cobrado;
            return $prov;
        });

    }

}