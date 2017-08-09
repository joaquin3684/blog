<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/06/17
 * Time: 14:51
 */

namespace App\Repositories\Eloquent\Filtros\Ventas;


use App\Repositories\Contracts\filtros;
use Illuminate\Database\Eloquent\Builder;

class FechaVencimientoDesdeCuota implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('cuotas.fecha_vencimiento', '>=', $value);
    }
}