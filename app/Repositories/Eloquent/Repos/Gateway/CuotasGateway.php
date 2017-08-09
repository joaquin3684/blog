<?php namespace App\Repositories\Eloquent\Repos\Gateway;

use App\Cuotas;
use App\Repositories\Eloquent\Repos\Gateway\Gateway;
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/05/17
 * Time: 20:33
 */
class CuotasGateway extends Gateway
{
    function model()
    {
        return 'App\Cuotas';
    }

}