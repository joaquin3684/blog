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

    public function map($proveedor)
    {
        $proveedorNuevo = new Proveedor($proveedor->id, $proveedor->razon_social, $proveedor->descripcion);
        if($proveedor->relationLoaded('prioridad'))
        {
            $prioridad = $this->prioridadMapper->map($proveedor->prioridad);
            $proveedorNuevo->setPrioridad($prioridad);
        }
        if($proveedor->relationLoaded('productos'))
        {
            $mapper = new ProductosMapper();
            $productos = $proveedor->productos->map(function($producto) use($mapper){
                return  $mapper->map($producto);
            });
            $proveedorNuevo->setProductos($productos);
        }
        return $proveedorNuevo;
    }
}