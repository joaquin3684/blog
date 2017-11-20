<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\Capitulo;

class CapituloGateway extends Gateway
{
    function model()
    {
        return 'App\Capitulo';
    }

    public function traerRelaciones($id)
    {
        return Capitulo::with('rubros.monedas.departametos.subRubros.imputaciones')->find($id);
    }


}