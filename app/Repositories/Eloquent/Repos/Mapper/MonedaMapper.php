<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Moneda;

class MonedaMapper
{

    private $dptoMapper;
    public function __construct()
    {
        $this->dptoMapper = new DepartamentoMapper();
    }

    public function map($objeto)
    {
        $moneda = new \App\Repositories\Eloquent\Contabilidad\Moneda($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);

        if($objeto->relationLoaded('departamentos'))
        {
            $departamentos = $objeto->departamentos->map(function($dpto){
                return $this->dptoMapper->map($dpto);
            });
            $moneda->setDepartamentos($departamentos);
        }
        return $moneda;
    }
}