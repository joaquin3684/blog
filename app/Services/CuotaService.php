<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 17/04/19
 * Time: 17:09
 */

namespace App\Services;


use App\Cuotas;
use App\Repositories\Eloquent\Cuota;
use App\Ventas;
use Carbon\Carbon;

class CuotaService
{
    private $movimientoService;

    public function __construct()
    {
        $this->movimientoService = new MovimientoService();
    }

    public function crear($fecha_inicio, $fecha_vencimiento, $importe, $nro_cuota, $cuotable_id, $cuotable_type)
    {
        $cuota = new Cuotas();
        $cuota->fecha_inicio = $fecha_inicio;
        $cuota->fecha_vencimiento = $fecha_vencimiento;
        $cuota->importe = $importe;
        $cuota->nro_cuota = $nro_cuota;
        $cuota->cuotable_id = $cuotable_id;
        $cuota->cuotable_type = $cuotable_type;
        $cuota->estado = null;
        $cuota->save();
        return $cuota;
    }

    public function borrar($id)
    {
        Cuotas::destroy($id);
    }

    public function modificar($fecha_inicio, $fecha_vencimiento, $importe, $nro_cuota, $cuotable_id, $cuotable_type, $estado, $id)
    {
        $cuota = $this->find($id);
        $cuota->fecha_inicio = $fecha_inicio;
        $cuota->fecha_vencimiento = $fecha_vencimiento;
        $cuota->importe = $importe;
        $cuota->nro_cuota = $nro_cuota;
        $cuota->cuotable_id = $cuotable_id;
        $cuota->cuotable_type = $cuotable_type;
        $cuota->estado = $estado;
        $cuota->save();
        return $cuota;

    }

    public function find($id)
    {
        return Cuotas::with('movimientos')->find($id);
    }

    public function cuotasDeVenta($idVenta)
    {
        return Cuotas::where('cuotable_type', 'App\Venta')->where('cuotable_id', $idVenta)->get();
    }

    public function totalCobrado(Cuotas $cuota)
    {
        $movimientos = $this->movimientoService->movimientosDeCuota($cuota->id);
        return array_sum(array_map(function($movimiento){ return $movimiento->entrada;}, $movimientos));
    }

    public function cobrar(Cuotas $cuota, $montoDisponible)
    {
        $montoRestante = $cuota->importe - $this->totalCobrado($cuota);
        $cobrado = $montoRestante <= $montoDisponible ? $montoRestante : $montoDisponible;

        $this->movimientoService->crear($cuota->id, $cobrado, 0, Carbon::today()->toDateString());
        $this->modificar(
            $cuota->fecha_iinicio,
            $cuota->fecha_vencimiento,
            $cuota->importe,
            $cuota->nro_cuota,
            $cuota->cuotable_id,
            $cuota->cuotable_type,
            $cobrado == $cuota->importe ? 'Cobro Total' : 'Cobro Parcial',
            $cuota->id);

        return $cobrado;
    }

    public function pagarCuota(Cuotas $cuota, $ganancia)
    {
        $movimientos = $this->movimientoService->movimientosDeCuota($cuota->id);
        $totalPagado = 0;
        foreach($movimientos as $movimiento) {
            $this->movimientoService->modificar(
                $movimiento->id_cuota,
                $movimiento->entrada,
                $movimiento->entrada,
                $movimiento->fecha,
                round($movimiento->entrada * $ganancia / 100, 2),
                $movimiento->contabilizado_entrada,
                $movimiento->contabilizado_salida,
                $movimiento->id);
            $totalPagado += $movimiento->entrada - round($movimiento->entrada * $ganancia / 100, 2);
        }

        return $totalPagado;

    }
}