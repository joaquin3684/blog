<?php

namespace App\Repositories\Eloquent\Generadores;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/09/17
 * Time: 15:04
 */
class GeneradorCuotas
{

    public static function generarCuotasVenta(\App\Repositories\Eloquent\Ventas $venta)
    {
        $cuotaRepo = new CuotasRepo();
        $fechaVto = Carbon::createFromFormat('Y-m-d', $venta->getFechaVencimiento());
        $fechaInicio = Carbon::today();

        $cuotas = collect();
        for ($i = 1; $venta->getNroCuotas() >= $i; $i++) {
           $cuota = $cuotaRepo->create([
                'cuotable_id' => $venta->getId(),
                'cuotable_type' => 'App\Ventas',
                'importe' => $venta->getImporte()/$venta->getNroCuotas(),
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_vencimiento' => $fechaVto->toDateString(),
                'nro_cuota' => $i,
            ]);
           $cuotas->push($cuota);

            $aux = Carbon::create($fechaVto->year, $fechaVto->month, $fechaVto->day);
            $fechaInicio = $aux->addDay();
            $fechaVto->addMonth();
        }
        $venta->setCuotas($cuotas);
        return $venta;
    }

    public static function generarCuotaSocial($importe, $socio)
    {
        $cuotasRepo = new CuotasRepo();
        $fechaInicioCuota = Carbon::today()->toDateString();
        $fechaVencimientoCuota = Carbon::today()->addMonths(2)->toDateString();
        $cuota = $cuotasRepo->create([
            'cuotable_id' => $socio,
            'cuotable_type' => 'App\Socios',
            'fecha_inicio' => $fechaInicioCuota,
            'fecha_vencimiento' => $fechaVencimientoCuota,
            'importe' => $importe,
            'nro_cuota' => 1,
        ]);
        return $cuota;
    }
}