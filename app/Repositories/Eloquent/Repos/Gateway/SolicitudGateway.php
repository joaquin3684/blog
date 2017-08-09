<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/07/17
 * Time: 12:06
 */

namespace App\Repositories\Eloquent\Repos\Gateway;


use App\Solicitud;

class SolicitudGateway extends Gateway
{
    function model()
    {
        return 'App\Solicitud';
    }

    public function solicitudesSinAsignar()
    {
        return Solicitud::whereNull('agente_financiero')
                        ->orWhere('doc_endeudamiento', '')->get();
    }


}