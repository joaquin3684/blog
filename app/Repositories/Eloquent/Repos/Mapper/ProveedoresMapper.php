<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/05/17
 * Time: 22:09
 */

namespace App\Repositories\Eloquent\Repos\Mapper;


use App\Proovedores;
use App\Repositories\Eloquent\Repos\Mapper\PrioridadMapper;
use App\Repositories\Eloquent\Proveedor;
class ProveedoresMapper
{
    public function __construct()
    {
        $this->prioridadMapper = new PrioridadMapper();
    }

    public function map(Proovedores $proveedor)
    {
        $proveedorNuevo = new Proveedor($proveedor->id, $proveedor->nombre, $proveedor->descripcion);
        if($proveedor->relationLoaded('prioridad'))
        {
            $prioridad = $this->prioridadMapper->map($proveedor->prioridad);
            $proveedorNuevo->setPrioridad($prioridad);
        }
        return $proveedorNuevo;
    }
}