<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 31/07/17
 * Time: 18:22
 */

namespace App\Repositories\Eloquent;


class DesignadorDeEstado
{
    private $solicitud;
    public function __construct($solicitud)
    {
        $this->solicitud = $solicitud;
    }

    public function buscarEstado($agente)
    {
        if($agente == null && empty($this->solicitud->doc_endeudamiento))
        {
            return 'Procesando Solicitud';

        } else
        {
            return 'Inversionista Asignado';
        }
    }
}