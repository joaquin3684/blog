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
       return Solicitud::where('doc_endeudamiento', null)->orWhere('agente_financiero', null)->with('socio')->get();
    }

    public function buscarPorAgente($id)
    {
        return Solicitud::where('agente_financiero', $id)->get();
    }

    public function solicitudesConCapitalOtorgado()
    {
        return Solicitud::where('estado', 'Capital Otorgado')->with('socio')->get();
    }

    public function solicitudWithComer($id)
    {
        return Solicitud::with('comercializador')->find($id);
    }
}