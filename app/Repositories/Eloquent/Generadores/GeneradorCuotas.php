<?php

namespace App\Repositories\Eloquent\Generadores;
use App\Cuotas;
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

    public static function generarCuotasVenta(\App\Ventas $venta)
    {


        $fechaInicio = Carbon::createFromFormat('Y-m-d', $venta->fecha_vencimiento)->subMonths(2);
        $fechaVto = Carbon::createFromFormat('Y-m-d', $venta->fecha_vencimiento);
        $cuotas = collect();
        for ($i = 1; $venta->nro_cuotas >= $i; $i++) {
            $cuota = [
                'cuotable_id' => $venta->id,
                'cuotable_type' => 'App\Ventas',
                'importe' => $venta->importe_cuota,
                'fecha_inicio' => $fechaInicio->toDateString(),
                'fecha_vencimiento' => $fechaVto->toDateString(),
                'nro_cuota' => $i,
            ];
            $cuotas->push($cuota);

            $aux = Carbon::create($fechaVto->year, $fechaVto->month, $fechaVto->day);
            $fechaInicio->addMonth();
            $fechaVto->addMonth();
        }
        return $cuotas;
    }

    public static function borrarCuotasVenta(\App\Ventas $venta)
    {
        Cuotas::where('id_venta', $venta->id)->delete();
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