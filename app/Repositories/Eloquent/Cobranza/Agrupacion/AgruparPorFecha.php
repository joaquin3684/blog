<?php

namespace App\Repositories\Eloquent\Cobranza\Agrupacion;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/08/17
 * Time: 16:07
 */
class AgruparPorFecha
{
    public static function agrupar(Collection $col)
    {
        //TODO: aca cuando agrupa, esta agrupando por mes y año entonces si el 02/04/2018 queda 42018 y el 02/11/2017 queda 112017 que es un nuemro mas grande
        return $col->groupBy(function ($cuota) {
            $fecha = Carbon::createFromFormat('Y-m-d', $cuota->getFechaInicio());
            if($fecha->month < 10){
                return $fecha->year.'0'.$fecha->month;
            } else {
                return $fecha->year.$fecha->month;
            }

        })->sortBy(function($item, $key){
            return $key;
        });
    }
}