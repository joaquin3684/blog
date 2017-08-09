<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 21:04
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\EstadoVenta;

class EstadoVentaGateway extends Gateway
{
    function model()
    {
        return 'App\EstadoVenta';
    }
}