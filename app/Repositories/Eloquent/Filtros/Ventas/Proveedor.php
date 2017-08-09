<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 05/06/17
 * Time: 11:21
 */

namespace App\Repositories\Eloquent\Filtros\Ventas;

use Illuminate\Database\Eloquent\Builder;
use App\Repositories\Contracts\filtros;

class Proveedor implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('proovedores.id', $value);
    }
}