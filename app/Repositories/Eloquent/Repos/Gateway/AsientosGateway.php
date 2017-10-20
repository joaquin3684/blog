<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 19/10/17
 * Time: 19:48
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


class AsientosGateway extends Gateway
{
    function model()
    {
        return 'App\Asiento';
    }
}