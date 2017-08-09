<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;

class AgenteFinancieroRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new AgenteFinancieroGateway();
        $this->mapper = new AgenteFinancieroMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\AgenteFinancieroRepo';
    }

}