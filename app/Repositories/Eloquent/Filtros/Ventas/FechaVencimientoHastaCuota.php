<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 11/06/17
 * Time: 20:52
 */

namespace App\Repositories\Eloquent\Filtros\Ventas;


use App\Repositories\Contracts\filtros;

class FechaVencimientoHastaCuota implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('cuotas.fecha_vencimiento', '<=', $value);
    }

}