<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 27/08/18
 * Time: 16:06
 */

namespace App\Services;


use App\PorcentajeColocacion;
use App\Repositories\Eloquent\Repos\Gateway\ProductosGateway;

class ABM_ProductosService
{
    private $producto;
    public function __construct()
    {
        $this->producto = new ProductosGateway();
    }
    public function crearProducto($elem)
    {
        $producto = $this->producto->create($elem);
        $id_producto = $producto->id;
        $porcentajes = collect($elem['porcentajes']);
        $porcentajes->each(function ($porcentaje) use ($id_producto) {
            $porcentaje['id_producto'] = $id_producto;
            PorcentajeColocacion::create($porcentaje);
        });
    }
}