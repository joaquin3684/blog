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

    }

    public function map(Productos $producto)
    {
        $productoNuevo = new Producto($producto->id, $producto->nombre, $producto->ganancia, $producto->tipo, $producto->porcentaje_capital);
        if($producto->relationLoaded('proovedor'))
        {
            $mapper = new ProveedoresMapper();
            $proveedor = $mapper->map($producto->proovedor);
            $productoNuevo->setProveedor($proveedor);
        }
        if($producto->relationLoaded('ventas'))
        {
            $mapper = new VentasMapper();
            $ventas = $producto->ventas->map(function($venta) use ($mapper){
                return $mapper->map($venta);
            });
            $productoNuevo->setVentas($ventas);
        }
        return $productoNuevo;
    }
}