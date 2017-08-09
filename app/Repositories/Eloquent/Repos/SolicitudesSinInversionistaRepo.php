<?php

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\SolicitudesSinInversionistaGateway;
use App\Repositories\Eloquent\Repos\Mapper\SolicitudesSinInversionistaMapper;

class SolicitudesSinInversionistaRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new SolicitudesSinInversionistaGateway();
        $this->mapper = new SolicitudesSinInversionistaMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\SolicitudesSinInversionista';
    }

}