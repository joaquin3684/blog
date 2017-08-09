<?php namespace App\Repositories\Eloquent\Repos;
use App\Repositories\Eloquent\Repos\Gateway\OrganismosGateway;
use App\Repositories\Eloquent\Repos\Mapper\OrganismosMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:04
 */
class OrganismosRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new OrganismosMapper();
        $this->gateway = new OrganismosGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\OrganismosRepo';
    }
}