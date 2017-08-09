<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 21:05
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


class PrioridadGateway extends Gateway
{
    function model()
    {
        return 'App\Prioridades';
    }
}