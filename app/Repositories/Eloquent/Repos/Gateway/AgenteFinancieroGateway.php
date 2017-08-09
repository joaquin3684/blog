<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\AgenteFinanciero;

class AgenteFinancieroGateway extends Gateway
{
    function model()
    {
        return 'App\AgenteFinanciero';
    }

    public function findSolicitudesByAgenteFinanciero($id)
    {
        return AgenteFinanciero::with('solicitudes')->where('usuario', $id)->get()->first();
    }

}