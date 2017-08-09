<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/05/17
 * Time: 12:43
 */

namespace App\Repositories\Eloquent\Cobranza;
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
        $collect = collect();
        $this->socio->getVentas()->each(function ($venta) use ($collect){
            $cuotasVencidas = $venta->cuotasVencidas();
            $orden = $venta->getPrioridad();
            $cuotasVencidas->each(function($cuota) use ($orden){
                $cuota->orden = $orden;

            });


             $collect->push($cuotasVencidas);
        });

        $flaten = $collect->flatten(1);
        $p = $flaten->groupBy(function ($cuota) {
            $fecha = Carbon::createFromFormat('Y-m-d', $cuota->getFechaInicio());
            return $fecha->month.$fecha->year;
        })->sortBy(function($item, $key){
            return $key;
        });

        $p->transform(function($item){
             $p = $item->groupBy(function($item){
                return $item->orden;
            })->sortBy(function($item, $key){return $key;});
             return $p;
        });

        $p->each(function($grupoPorFecha) use (&$monto){
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
            $p = $flaten->groupBy(function ($cuota) {
                $fecha = Carbon::createFromFormat('Y-m-d', $cuota->getFechaInicio());
                return $fecha->month.$fecha->year;
            })->sortBy(function($item, $key){
                return $key;
            });

            $p->transform(function($item){
                $p = $item->groupBy(function($item){
                    return $item->ordenProovedor();
                })->sortBy(function($item, $key){return $key;});
                return $p;
            });

            $p->each(function($grupoPorFecha) use (&$monto){
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