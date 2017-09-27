<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\MonedaGateway;
use App\Repositories\Eloquent\Repos\Mapper\MonedaMapper;

class Moneda extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new MonedaGateway();
        $this->mapper = new MonedaMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\Moneda';
    }

}