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