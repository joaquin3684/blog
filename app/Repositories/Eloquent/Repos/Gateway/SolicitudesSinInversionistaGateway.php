<?php

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\SolicitudesSinInversionista;

class SolicitudesSinInversionistaGateway extends Gateway
{
    function model()
    {
        return 'App\SolicitudesSinInversionista';
    }

    public function solicitudesSinAsignar()
    {
        return SolicitudesSinInversionista::with('solicitud.socio', 'agentes_financieros')
                                ->whereHas('solicitud', function($query){
                                    $query->where('estado', 'Procesando Solicitud');
                                })->get();
    }
}