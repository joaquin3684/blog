<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Departamento;

class DepartamentoMapper
{

    private $subRubroMapper;
    public function __construct()
    {
        $this->subRubroMapper = new SubRubroMapper();
    }

    public function map($objeto)
    {
        $dpto = new \App\Repositories\Eloquent\Contabilidad\Departamento($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);

        if($objeto->relationLoaded('subRubros'))
        {
            $subRubros = $objeto->subRubros->map(function($subRubro){
                return $this->subRubroMapper->map($subRubro);
            });
            $dpto->setSubRubros($subRubros);
        }
        return $dpto;
    }
}