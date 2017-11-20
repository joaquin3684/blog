<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\SubRubro;

class SubRubroMapper
{

    private $imputacionMapper;
    public function __construct()
    {
        $this->imputacionMapper = new ImputacionMapper();
    }

    public function map($objeto)
    {
        $subRubro = new \App\Repositories\Eloquent\Contabilidad\SubRubro($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);

        if($objeto->relationLoaded('imputaciones'))
        {
            $imputaciones = $objeto->imputaciones->map(function($imputacion){
                return $this->imputacionMapper->map($imputacion);
            });
            $subRubro->setImputaciones($imputaciones);
        }
        return $subRubro;
    }
}