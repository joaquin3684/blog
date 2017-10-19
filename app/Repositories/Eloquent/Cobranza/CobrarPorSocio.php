<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/05/17
 * Time: 12:43
 */

namespace App\Repositories\Eloquent\Cobranza;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Repositories\Eloquent\Cobranza\Agrupacion\AgruparPorFecha;
use App\Repositories\Eloquent\Cobranza\Agrupacion\AgruparPorOrdenDePrioridad;
use App\Repositories\Eloquent\ConsultasCuotas;
use App\Repositories\Eloquent\ConsultasMovimientos;
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
        if ($this->socio->montoAdeudado() < $monto)
            throw new MasPlataCobradaQueElTotalException('exceso_de_plata');

            $collect = collect();
            $this->socio->getVentas()->each(function ($venta) use ($collect) {
                $cuotas = $venta->cuotasImpagas();
                $orden = $venta->getPrioridad();
                $cuotas->each(function ($cuota) use ($orden) {
                    $cuota->orden = $orden;

                });

                $collect->push($cuotas);
            });
            $flaten = $collect->flatten(1);
            $cuotasAgrupadas = AgruparPorFecha::agrupar($flaten);
            $cuotasAgrupadas->transform(function ($cuotas) {
                return AgruparPorOrdenDePrioridad::agrupar($cuotas);
            });

            $cuotasAgrupadas->each(function ($grupoPorFecha) use (&$monto) {
                if ($monto > 0) {
                    $grupoPorFecha->each(function ($grupoPorOrden) use (&$monto) {
                        if ($monto > 0) {
                            $cantidad = $grupoPorOrden->count();
                            $montoPorCuota = $monto / $cantidad;
                            $grupoPorOrden->each(function ($cuota) use ($montoPorCuota, &$monto) {
                                $cobrado = $cuota->cobrar($montoPorCuota);
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
            $cuotasAgrupadas2->each(function($grupoPorFecha) use (&$monto){
                if($monto > 0)
                {
                    $grupoPorFecha->each(function ($grupoPorOrden) use (&$monto){
                        if($monto > 0)
                        {
                            $cantidad = $grupoPorOrden->count();
                            $montoPorCuota = $monto / $cantidad;
                            $grupoPorOrden->each(function($cuota) use ($montoPorCuota, &$monto) {
                                $cobrado =  $cuota->cobrar($montoPorCuota);
                                $monto -= $cobrado;
                            });
                        }
                    });
                } else { return false; }
            });
        }
    }

}