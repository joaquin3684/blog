<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\SubRubroGateway;
use App\Repositories\Eloquent\Repos\Mapper\SubRubroMapper;

class SubRubro extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new SubRubroGateway();
        $this->mapper = new SubRubroMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\SubRubro';
    }

    public function traerRelaciones($id)
    {
        $capitulo = Capitulo::with('imputaciones')->find($id);
        return $this->mapper->map($capitulo);
    }
}