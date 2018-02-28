<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/05/17
 * Time: 12:43
 */

namespace App\Repositories\Eloquent\Cobranza;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\ProveedorImputacionDeudores;
use App\Repositories\Eloquent\Cobranza\Agrupacion\AgruparPorFecha;
use App\Repositories\Eloquent\Cobranza\Agrupacion\AgruparPorOrdenDePrioridad;
use App\Repositories\Eloquent\ConsultasCuotas;
use App\Repositories\Eloquent\ConsultasMovimientos;
use App\Repositories\Eloquent\GeneradorDeAsientos;
use App\Repositories\Eloquent\Repos\SociosRepo;
use App\Repositories\Eloquent\Socio;
use App\Repositories\Eloquent\Ventas;
use Carbon\Carbon;

class CobrarPorSocio
{

    private $socio;
    public function __construct(Socio $socio)
    {
        $this->socio = $socio;
    }

    public function cobrar($monto)
    {

            $collect = collect();
            $this->socio->getVentas()->each(function ($venta) use ($collect) {
                $cuotas = $venta->cuotasImpagas();
                $orden = $venta->getPrioridad();
                $proveedor = $venta->getProveedor();
                $cuotas->each(function ($cuota) use ($orden, $proveedor) {
                    $cuota->orden = $orden;
                    $cuota->proveedor = $proveedor;
                });

                $collect->push($cuotas);
            });
            $flaten = $collect->flatten(1);
            $cuotasAgrupadas = AgruparPorFecha::agrupar($flaten);
            $cuotasAgrupadas->transform(function ($cuotas) {
                return AgruparPorOrdenDePrioridad::agrupar($cuotas);
            });
            $cobroPorProveedor = collect();
            $cuotasAgrupadas->each(function ($grupoPorFecha) use (&$monto, $cobroPorProveedor) {
                if ($monto > 0) {
                    $grupoPorFecha->each(function ($grupoPorOrden) use (&$monto, $cobroPorProveedor) {
                        if ($monto > 0) {
                            $cantidad = $grupoPorOrden->count();
                            $montoPorCuota = $monto / $cantidad;
                            $grupoPorOrden->each(function ($cuota) use ($montoPorCuota, &$monto, $cobroPorProveedor) {
                                $cobrado = $cuota->cobrar($montoPorCuota);
                                $this->calcularMontoCobradoProveedor($cuota, $cobroPorProveedor, $cobrado);
                                $monto -= $cobrado;
                            });
                        }
                    });
                } else {
                    return false;
                }
            });

        if($monto > 0)
        {
            $repo = new SociosRepo();
            $socio = $repo->cuotasFuturas($this->socio->getId());
            $collect = collect();
            $socio->getVentas()->each(function ($venta) use ($collect){
                // $orden = $venta->getOrdenPrioridad();
                $cuotasVencidas = $venta->cuotasVencidas();
                $cantidadCuotas = $venta->cuotasVencidas()->count();
                $collect->push($cuotasVencidas);
            });
            $flaten = $collect->flatten(1);
            $cuotasAgrupadas2 = AgruparPorFecha::agrupar($flaten);
            $cuotasAgrupadas2->transform(function ($cuotas) {
                return AgruparPorOrdenDePrioridad::agrupar($cuotas);
            });
            $cuotasAgrupadas2->each(function($grupoPorFecha) use (&$monto, $cobroPorProveedor){
                if($monto > 0)
                {
                    $grupoPorFecha->each(function ($grupoPorOrden) use (&$monto, $cobroPorProveedor){
                        if($monto > 0)
                        {
                            $cantidad = $grupoPorOrden->count();
                            $montoPorCuota = $monto / $cantidad;
                            $grupoPorOrden->each(function($cuota) use ($montoPorCuota, &$monto, $cobroPorProveedor) {
                                $cobrado =  $cuota->cobrar($montoPorCuota);
                                $this->calcularMontoCobradoProveedor($cuota, $cobroPorProveedor, $cobrado);
                                $monto -= $cobrado;
                            });
                        }
                    });
                } else { return false; }
            });
        }

        $cobroPorProveedor->each(function ($proveedor) {
            $cuenta = ProveedorImputacionDeudores::with('imputacion')->where('id_proveedor', $proveedor['proveedor'])->where('tipo', 'Deudores')->first();
            GeneradorDeAsientos::crear($cuenta->imputacion, 0, $proveedor['total']);
            GeneradorDeAsientos::crear($cuenta->imputacion, $proveedor['total'], 0);
            //TODO:: preguntar donde va a estar la cuenta puente
            //TODO:: esto no va a funcionar porque el proveedorImputacionesDeudores no tiene nombre para poner en el asiento hay que ponerle un nombre a la tabla y ver en la creacion y modificacion que no se cague nada

        });
    }

    public function calcularMontoCobradoProveedor($cuota, &$coleccion, $cobrado)
    {
        if($coleccion->contains('proveedor', $cuota->proveedor->getId()))
        {
            $coleccion->transform(function($prov) use ($cuota, $cobrado){
                if($prov['proveedor'] == $cuota->proveedor->getId())
                {
                    $prov['total'] = $prov['total'] + $cobrado;
                }
                return $prov;
            });
        }
        else
        {
            $aux = collect();
            $aux->put('proveedor', $cuota->proveedor->getId());
            $aux->put('total', $cobrado);
            $coleccion->push($aux);
        }
    }

}