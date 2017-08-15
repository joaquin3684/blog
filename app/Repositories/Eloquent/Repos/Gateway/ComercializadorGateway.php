<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/07/17
 * Time: 20:07
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\Comercializador;

class ComercializadorGateway extends Gateway
{
    function model()
    {
        return 'App\Comercializador';
    }

    public function findSolicitudesFromUser($id)
    {
        return Comercializador::with('solicitudes.socio')->where('usuario', $id)->get()->first();
    }

}