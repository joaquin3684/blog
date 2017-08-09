<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/06/17
 * Time: 18:23
 */

namespace App\Repositories\Eloquent\Filtros\Ventas;


use App\Repositories\Contracts\filtros;

class FechaInicioDesdeCuota implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('cuotas.fecha_inicio', '>=', $value);
    }

}