<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 26/05/17
 * Time: 19:37
 */

namespace App\Repositories\Eloquent\Repos\Mapper;
use App\Repositories\Eloquent\EstadoVenta;


class EstadoVentaMapper
{
    public function map($estado)
    {
        return new EstadoVenta($estado->id, $estado->id_venta, $estado->id_responsable, $estado->estado, $estado->observacion);
    }
}