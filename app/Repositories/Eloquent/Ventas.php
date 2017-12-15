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
use App\Repositories\Eloquent\Repos\MovimientosRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas as ModelVentas;
use App\Traits\Conversion;
use Carbon\Carbon;

class Ventas
{
    use Conversion;
    private $cuotas;
    private $id;
    private $producto;
    private $descripcion;
    private $nro_cuotas;
    private $estados;
    private $importe;
    private $fecha_vencimiento;
    private $ventaRepo;
    private $nro_credito;


    public function __construct($id, $descripcion, $nro_cuotas, $importe, $fecha_vencimiento, $nro_credito)
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->nro_cuotas = $nro_cuotas;
        $this->importe = $importe;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->nro_credito = $nro_credito;
        $this->ventaRepo = new VentasRepo();
    }

    public function cuotasVencidas()
    {
        return $this->cuotas->filter(function ($cuota){
            return $cuota->estaVencida();
        });
    }

    public function cuotasImpagas()
    {
        return $this->cuotas->filter(function($cuota){
            return $cuota->estaImpaga();
        });
    }

    public function cancelar($motivo)
    {
        $cuotasImpagas = $this->getCuotas()->filter(function($cuota){
            return $cuota->estaImpaga();
        })->sortBy('nro_cuota');
        
        $cuotasImpagas->each(function($cuota) use ($motivo){
            $cuota->cancelar($motivo);
        });
    }

    public function contabilizarPago()
    {
        $this->cuotas->each(function($cuota){
            $cuota->contabilizarPago();
        });
    }
    /**
     * @return mixed
     */
    public function getNroCredito()
    {
        return $this->nro_credito;
    }

    /**
     * @param mixed $nro_credito
     */
    public function setNroCredito($nro_credito)
    {
        $this->nro_credito = $nro_credito;
    }

    public function montoAdeudado()
    {
        return $this->getCuotas()->sum(function($cuota){
           return $cuota->montoAdeudado();
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
        $porcenta_capital = $this->getPorcentajeCapital();
        $ganancia = $this->getPorcentajeGanancia();
        $this->cuotas->each(function ($cuota) use ($ganancia, $porcenta_capital) {
           $cuota->pagarProovedor($ganancia, $porcenta_capital);
        });
    }

    public function correrVto($dias)
    {
        $fecha = Carbon::createFromFormat('Y-m-d', $this->fecha_vencimiento)->addDays($dias)->toDateString();
        $this->setFechaVencimiento($fecha);
        $this->ventaRepo->update(['fecha_vencimiento' => $fecha], $this->id);
        $this->getCuotas()->each(function($cuota) use ($dias){
            $cuota->correrVto($dias);
        });
    }

    public function sistemaFrances()
    {
        $col = collect();
        //$formula = $this->importe * ( (1 + ))
    }

    /**
     * @param mixed $descripcion
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    /**
     * @param mixed $nro_cuotas
     */
    public function setNroCuotas($nro_cuotas)
    {
        $this->nro_cuotas = $nro_cuotas;
    }

    /**
     * @param mixed $importe
     */
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    /**
     * @param mixed $fecha_vencimiento
     */
    public function setFechaVencimiento($fecha_vencimiento)
    {
        $this->fecha_vencimiento = $fecha_vencimiento;
    }

    public function setProducto($producto)
    {
        $this->producto = $producto;
    }

    /**
     * @return mixed
     */
    public function getProducto()
    {
        return $this->producto;
    }

    public function getProveedor()
    {
        return $this->producto->getProveedor();
    }

    public function getPrioridad()
    {
        return $this->producto->getPrioridad();
    }

    public function getPorcentajeGanancia()
    {
        return $this->producto->getGanancia();
    }

    public function getPorcentajeCapital()
    {
        return $this->producto->getPorcentajeCapital();
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