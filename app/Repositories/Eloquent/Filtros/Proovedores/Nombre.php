<?php

namespace App\Repositories\Eloquent\Filtros\AgentesFinancieros;

use App\Repositories\Contracts\filtros;

class Nombre implements filtros
{
    public static function apply($builder, $value)
    {
        return $builder->where('agentes_financieros.nombre', '=', $value);
    }
}