<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\DepartamentoGateway;
use App\Repositories\Eloquent\Repos\Mapper\DepartamentoMapper;

class Departamento extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new DepartamentoGateway();
        $this->mapper = new DepartamentoMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\Departamento';
    }

}