<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:30
 */

namespace App\Repositories\Eloquent\Repos\Mapper;
use App\Repositories\Eloquent\Cuota;
use App\Cuotas;

class CuotasMapper
{
    private $movimientoMapper;

    public function __construct()
    {
        $this->movimientoMapper = new MovimientoMapper();
    }

    public function map($cuota)
    {
        $cuotaNuevo = new Cuota($cuota->id, $cuota->importe, $cuota->fecha_vencimiento, $cuota->fecha_inicio, $cuota->nro_cuota, $cuota->estado);
        if($cuota->relationLoaded('movimientos'))
        {
            $movimientos = $cuota->movimientos->map(function($movimiento){
                return $this->movimientoMapper->map($movimiento);
            });
            $cuotaNuevo->setMovimientos($movimientos);
        }
        return $cuotaNuevo;
    }



}