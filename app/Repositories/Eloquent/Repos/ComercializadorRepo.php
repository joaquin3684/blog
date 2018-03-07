<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 19:05
 */

namespace App\Repositories\Eloquent\Repos;


use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Mapper\ComercializadorMapper;
use App\Repositories\Eloquent\Solicitud;

class ComercializadorRepo extends Repositorio
{
    public function __construct()
    {
        $this->gateway = new ComercializadorGateway();
        $this->mapper = new ComercializadorMapper();
    }

    function model()
    {
        return 'App\Repositories\Eloquent\Repos\ComercializadorRepo';
    }

    public function solicitudesPendientesDeCobro($id)
    {
        return Solicitud::where('comercializador', $id)->where('estado', 'Solicitud Aprobada')->get();
    }

}