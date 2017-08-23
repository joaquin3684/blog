<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 28/07/17
 * Time: 12:06
 */

namespace App\Repositories\Eloquent\Repos\Mapper;


use App\Solicitud;

class SolicitudMapper
{
    public function map(Solicitud $solicitud)
    {
        return new \App\Repositories\Eloquent\Solicitud($solicitud->id, $solicitud->total, $solicitud->monto_por_cuota, $solicitud->cuotas, $solicitud->doc_endeudamiento, $solicitud->estado);
    }
}