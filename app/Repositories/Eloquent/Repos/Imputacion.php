<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use App\Repositories\Eloquent\Repos\Mapper\ImputacionMapper;

class Imputacion extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new ImputacionGateway();
        $this->mapper = new ImputacionMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\Imputacion';
    }

}