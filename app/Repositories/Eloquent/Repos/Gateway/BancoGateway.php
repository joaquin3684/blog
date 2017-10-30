<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


class BancoGateway extends Gateway
{
    function model()
    {
        return 'App\Banco';
    }

}