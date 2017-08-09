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
        return new \App\Repositories\Eloquent\Solicitud($solicitud->id, $solicitud->nombre, $solicitud->apellido, $solicitud->cuit, $solicitud->domicilio, $solicitud->telefono, $solicitud->codigo_postal, $solicitud->doc_documento, $solicitud->doc_recibo, $solicitud->doc_domicilio, $solicitud->doc_cbu, $solicitud->doc_endeudamiento, $solicitud->estado);
    }
}