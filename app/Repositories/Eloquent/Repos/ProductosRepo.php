<?php namespace App\Repositories\Eloquent\Repos;
use App\Repositories\Eloquent\Repos\Gateway\ProductosGateway;
use App\Repositories\Eloquent\Repos\Mapper\ProductosMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:04
 */
class ProductosRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new ProductosMapper();
        $this->gateway = new ProductosGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\ProductosRepo';
    }
}