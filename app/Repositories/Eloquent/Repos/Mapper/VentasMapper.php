<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 19:14
 */

namespace App\Repositories\Eloquent\Repos\Mapper;
use App\Repositories\Eloquent\Fechas;
use App\Repositories\Eloquent\Cuota;
use App\Ventas as VentasModel;
use App\Repositories\Eloquent\Ventas;


class VentasMapper
{
    private $cuotasMapper;
    private $productosMapper;

    public function __construct()
    {
        $this->cuotasMapper = new CuotasMapper();
        $this->productosMapper = new ProductosMapper();
        $this->estadoMapper = new EstadoVentaMapper();
    }

    public function map(VentasModel $venta)
    {
        $ventaNueva = new Ventas($venta->id,  $venta->descripcion, $venta->nro_cuotas, $venta->fecha, $venta->importe, $venta->fecha_vencimiento);
        if($venta->relationLoaded('cuotas'))
        {
            $cuotas = $venta->cuotas->map(function($cuota){
                return $this->cuotasMapper->map($cuota);
            });
            $ventaNueva->setCuotas($cuotas);
        }
        if($venta->relationLoaded('producto'))
        {
            $producto = $this->productosMapper->map($venta->producto);
            $ventaNueva->setProducto($producto);
        }
        if($venta->relationLoaded('estado'))
        {
            $estados = $venta->estados->map(function($estado){
                return $this->estadoMapper->map($estado);
            });
            $ventaNueva->setEstados($estados);
        }
        return $ventaNueva;
    }


}