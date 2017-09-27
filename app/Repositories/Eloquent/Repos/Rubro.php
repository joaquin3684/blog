<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\RubroGateway;
use App\Repositories\Eloquent\Repos\Mapper\RubroMapper;

class Rubro extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new RubroGateway();
        $this->mapper = new RubroMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\Rubro';
    }

}