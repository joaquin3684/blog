<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 07/05/17
 * Time: 17:39
 */

namespace App\Repositories\Eloquent;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\MovimientosRepo;
use App\Traits\Conversion;
use Carbon\Carbon;

class Cuota
{
    use Conversion;

    private $movimientos;
    private $id;
    private $importe;
    private $fecha_vencimiento;
    private $fecha_inicio;
    private $nro_cuota;
    private $estado;
    private $cuotasRepo;

    public function __construct($id, $importe, $fecha_vencimiento, $fecha_inicio, $nro_cuota, $estado)
    {
        $this->id = $id;
        $this->importe = $importe;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->fecha_inicio = $fecha_inicio;
        $this->nro_cuota = $nro_cuota;
        $this->estado = $estado;
        $this->cuotasRepo = new CuotasRepo();
    }


    public function cobrar($monto)
    {
        $cobrado = $this->montoACobrar($monto);
        $this->determinarEstado($cobrado);
        $fecha = Fechas::getFechaHoy();
        $array = array('identificadores_id' => $this->id, 'identificadores_type' => 'App\Cuotas', 'entrada' => $cobrado, 'fecha' => $fecha);
        $this->addMovimiento($array);
        $data = $this->toArray($this);
        $this->cuotasRepo->update($data, $this->id);
        return $cobrado;
    }

    public function determinarEstado($cobrado)
    {
        $this->estado = $cobrado == $this->importe ? 'Cobro Total' : 'Cobro Parcial';
    }

    public function montoACobrar($monto)
    {
        $montoACobrar = $this->importe - $this->totalEntradaDeMovimientosDeCuota();
        $cobrado = $montoACobrar <= $monto && $monto > 0 ? $montoACobrar : $monto;
        return $cobrado;
    }
    public function setMovimientos($movimientos)
    {
        $this->movimientos =  $movimientos;
    }

    public function addMovimiento($array)
    {
        $movimientoRepo = new MovimientosRepo();
        $mov = $movimientoRepo->create($array);
        $this->movimientos->push($mov);
    }

    public function estaVencida()
    {
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $this->fecha_inicio)->toDateString();
        $fechaHoy = Carbon::today()->toDateString();
        return $this->estaImpaga() && $fechaInicio < $fechaHoy;
    }

    public function estaImpaga()
    {
        return $this->importe > $this->totalEntradaDeMovimientosDeCuota();
    }


    public function montoAdeudado()
    {
        return $this->importe - $this->totalEntradaDeMovimientosDeCuota();
    }

    public function totalEntradaDeMovimientosDeCuota()
    {
        return $this->movimientos->sum(function($movimiento){
            return $movimiento->getEntrada();
        });
    }

    public function pagarProovedor($ganancia)
    {
        $this->movimientos->each(function ($movimiento) use ($ganancia){
            $movimiento->pagarProovedor($ganancia);
        });
    }

    public function correrVto($dias)
    {
        $fechaVto = Carbon::createFromFormat('Y-m-d', $this->fecha_vencimiento)->addDays($dias)->toDateString();
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $this->fecha_inicio)->addDays($dias)->toDateString();
        $this->setFechaVencimiento($fechaVto);
        $this->setFechaInicio($fechaInicio);
        $this->cuotasRepo->update(['fecha_vencimiento' => $fechaVto, 'fecha_inicio' => $fechaInicio], $this->id);
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

    /**
     * @param mixed $fecha_inicio
     */
    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    /**
     * @param mixed $nro_cuota
     */
    public function setNroCuota($nro_cuota)
    {
        $this->nro_cuota = $nro_cuota;
    }

    /**
     * @return mixed
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @param mixed $estado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getMovimientos()
    {
        return $this->movimientos;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getIdVenta()
    {
        return $this->id_venta;
    }

    public function getImporte()
    {
        return $this->importe;
    }

    public function getFechaVencimiento()
    {
        return $this->fecha_vencimiento;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function getNroCuota()
    {
        return $this->nro_cuota;
    }

}