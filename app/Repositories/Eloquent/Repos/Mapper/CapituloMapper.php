<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Capitulo;

class CapituloMapper
{

    private $rubrosMapper;
    public function __construct()
    {
        $this->rubrosMapper = new RubroMapper();
    }

    public function map($objeto)
    {
        $cap = new \App\Repositories\Eloquent\Contabilidad\Capitulo($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);

        if($objeto->relationLoaded('rubros'))
        {
            $rubros = $objeto->rubros->map(function($rubro){
                return $this->rubrosMapper->map($rubro);
            });
            $cap->setRubros($rubros);
        }
        return $cap;
    }
}