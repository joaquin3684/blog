<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 16:10
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;
use App\Repositories\Eloquent\Mapper\CuotasMapper;
use App\Repositories\Eloquent\Mapper\VentasMapper;
use App\Ventas as ModelVentas;
use App\Traits\Conversion;
class Ventas
{
    use Conversion;
    private $cuotas;
    private $id;
    private $producto;
    private $descripcion;
    private $nro_cuotas;
    private $fecha;
    private $estados;
    private $importe;
    private $fecha_vencimiento;



    public function __construct($id, $descripcion, $nro_cuotas, $fecha, $importe, $fecha_vencimiento)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->nro_cuotas = $nro_cuotas;
        $this->fecha = $fecha;
        $this->importe = $importe;
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    public function cuotasVencidas()
    {
        return $this->cuotas->filter(function ($cuota){
            return $cuota->estaVencida();
        });
    }

    public function setCuotas($cuotas)
    {
        $this->cuotas = $cuotas;
    }

    public function getCuotas()
    {
        return $this->cuotas;
    }

    public function pagarProovedor()
    {

        $ganancia = $this->getPorcentajeGanancia();
        $this->cuotas->each(function ($cuota) use ($ganancia) {
           $cuota->pagarProovedor($ganancia);
        });
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    public function getPrioridad()
    {
        return $this->producto->getPrioridad();
    }

    public function getPorcentajeGanancia()
    {
        return $this->producto->getGanancia();
    }

    public function setEstados($estados)
    {
        $this->estados = $estados;
    }
    public function getNroCuotas()
    {
        return $this->nro_cuotas;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getImporte()
    {
        return $this->importe;
    }
    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }
}