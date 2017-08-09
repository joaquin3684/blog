<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/07/17
 * Time: 12:05
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\SolicitudMapper;

class SolicitudRepo extends Repositorio
{
    public function __construct()
    {
        $this->mapper = new SolicitudMapper();
        $this->gateway = new SolicitudGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\SolicitudRepo';
    }
}