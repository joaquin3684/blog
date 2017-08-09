<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/05/17
 * Time: 02:55
 */

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Repositories\Eloquent\Prioridad;

class PrioridadMapper
{
    public function map($prioridad)
    {
        return new Prioridad($prioridad->id, $prioridad->nombre, $prioridad->orden);
    }
}