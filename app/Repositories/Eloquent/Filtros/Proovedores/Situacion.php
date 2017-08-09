<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 09/08/17
 * Time: 15:34
 */

namespace App\Repositories\Eloquent\Filtros\AgentesFinancieros;


use App\Repositories\Contracts\filtros;

class Situacion implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('proovedores.situacion', '>=', $value);
    }
}