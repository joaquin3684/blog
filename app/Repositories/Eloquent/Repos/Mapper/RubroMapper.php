<?php

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Rubro;

class RubroMapper
{
    private $monedaMapper;
    public function __construct()
    {
        $this->monedaMapper = new MonedaMapper();
    }

    public function map($objeto)
    {
        $rubro = new \App\Repositories\Eloquent\Contabilidad\Rubro($objeto->id, $objeto->codigo, $objeto->nombre, $objeto->afecta_codigo_base);

        if($objeto->relationLoaded('monedas'))
        {
            $monedas = $objeto->monedas->map(function($moneda){
                return $this->monedaMapper->map($moneda);
            });
            $rubro->setMonedas($monedas);
        }
        return $rubro;
    }
}