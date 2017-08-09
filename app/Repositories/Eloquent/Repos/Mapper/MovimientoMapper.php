<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 21:15
 */

namespace App\Repositories\Eloquent\Repos\Mapper;
use App\Movimientos;
use App\Repositories\Eloquent\Movimiento;

class MovimientoMapper
{
    
    public function map($movimiento)
    {
        return new Movimiento($movimiento->id, $movimiento->entrada, $movimiento->salida, $movimiento->fecha, $movimiento->ganancia);
    }
}