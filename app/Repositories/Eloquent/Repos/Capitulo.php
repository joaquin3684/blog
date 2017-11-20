<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\CapituloGateway;
use App\Repositories\Eloquent\Repos\Mapper\CapituloMapper;

class Capitulo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new CapituloGateway();
        $this->mapper = new CapituloMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\Capitulo';
    }

    public function traerRelaciones($id)
    {
        $capitulo = \App\Capitulo::with('rubros.monedas.departamentos.subRubros.imputaciones')->find($id);
        return $this->mapper->map($capitulo);
    }

}