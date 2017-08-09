<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 10/05/17
 * Time: 22:09
 */

namespace App\Repositories\Eloquent\Repos\Mapper;

use App\Productos;
use App\Repositories\Eloquent\Producto;
use App\Repositories\Eloquent\Repos\Mapper\ProveedoresMapper;

class ProductosMapper
{
    /**
     * ProductosMapper constructor.
     */
    public function __construct()
    {
        $this->proveedorMapper = new ProveedoresMapper();
    }

    public function map(Productos $producto)
    {
        $productoNuevo = new Producto($producto->id, $producto->nombre, $producto->ganancia, $producto->tipo);
        if($producto->relationLoaded('proovedor'))
        {
            $proveedor = $this->proveedorMapper->map($producto->proovedor);
            $productoNuevo->setProveedor($proveedor);
        }
        return $productoNuevo;
    }
}