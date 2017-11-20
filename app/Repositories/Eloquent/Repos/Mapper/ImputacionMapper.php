<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Imputacion;

class ImputacionMapper
{


    public function map($objeto)
    {
        return new \App\Repositories\Eloquent\Contabilidad\Imputacion($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);


    }
}