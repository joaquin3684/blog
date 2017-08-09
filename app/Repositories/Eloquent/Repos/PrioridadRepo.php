<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/05/17
 * Time: 01:20
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\PrioridadGateway;
use App\Repositories\Eloquent\Repos\Mapper\PrioridadMapper;

class PrioridadRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new PrioridadMapper();
        $this->gateway = new PrioridadGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\PrioridadRepo';
    }
}