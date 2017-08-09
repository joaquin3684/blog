<?php namespace App\Repositories\Eloquent\Repos;
use App\Repositories\Eloquent\Repos\Gateway\SociosGateway;
use App\Repositories\Eloquent\Repos\Mapper\SociosMapper;

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 19:03
 */
class SociosRepo extends Repositorio
{
    public $mapper;
    public $gateway;

    public function __construct()
    {
        $this->mapper = new SociosMapper();
        $this->gateway = new SociosGateway();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\SociosRepo';
    }

    public function ventasConCuotasVencidas($id)
    {
        $socio = $this->gateway->ventasConCuotasVencidas($id);
        return $this->mapper->map($socio);
    }

    public function cuotasFuturas($id)
    {
        $socio = $this->gateway->cuotasFuturas($id);
        return $this->mapper->map($socio);
    }

    public function cuotasSocialesVencidas($id)
    {
        $socio = $this->gateway->cuotasSocialesVencidas($id);
        return $this->mapper->map($socio);
    }

}