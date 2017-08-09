<?php namespace App\Repositories\Eloquent\Repos;

use App\Repositories\Eloquent\Repos\Gateway\VentasGateway;
use App\Repositories\Eloquent\Repos\Mapper\VentasMapper;


/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:03
 */
class VentasRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new VentasMapper();
        $this->gateway = new VentasGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\VentasRepo';
    }

    public function cuotas($id)
    {
        $this->gateway->cuotas($id);
    }

    public function cuotasVencidas($id)
    {
        $cuotasVentas = $this->gateway->cuotasVencidas($id);
        return $this->mapper->map($cuotasVentas);
    }

    public function cuotasAPagarProovedor($id_proovedor)
    {
        $cuotas = $this->gateway->cuotasAPagarProovedor($id_proovedor);
        $colleccionNueva = $cuotas->map(function($venta){
            return $this->mapper->map($venta);
        });
        return $colleccionNueva;
    }


}