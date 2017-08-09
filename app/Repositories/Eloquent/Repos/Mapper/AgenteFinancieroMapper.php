<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\AgenteFinanciero;
use App\Repositories\Eloquent\AgenteFinanciero as Agente;

class AgenteFinancieroMapper
{

    public function map($objeto)
    {
        return new Agente($objeto->id, $objeto->nombre);
    }
}