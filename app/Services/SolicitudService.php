<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 09/10/18
 * Time: 11:34
 */

namespace App\Services;


use App\Solicitud;

class SolicitudService
{
    public function modificarSolicitud($elem)
    {
        $solicitud = $elem['id'];
        $solicitud = Solicitud::find($solicitud);
        $solicitud->fill($elem);
        $solicitud->save();
        return $solicitud;
    }
}