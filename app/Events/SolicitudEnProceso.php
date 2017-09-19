<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 18/09/17
 * Time: 14:45
 */

namespace App\Events;


class SolicitudEnProceso
{
    public $solicitud;

    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }
}