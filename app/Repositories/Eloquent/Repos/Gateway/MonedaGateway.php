<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


class MonedaGateway extends Gateway
{
    function model()
    {
        return 'App\Moneda';
    }

}