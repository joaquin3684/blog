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
    public function buscarEstado($agente)
    {
        if($agente == null)
        {
            return 'Buscando Inversionista';

        } else
        {
            return 'Inversionista Asignado';
        }
    }
}