<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\BancoGateway;
use App\Repositories\Eloquent\Repos\Mapper\BancoMapper;

class BancoRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new BancoGateway();
        $this->mapper = new BancoMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\BancoRepo';
    }

}