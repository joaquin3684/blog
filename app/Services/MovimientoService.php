<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 24/04/19
 * Time: 11:39
 */

namespace App\Services;


use App\Movimientos;

class MovimientoService
{
    public function crear(
        $idCuota,
        $entrada,
        $salida,
        $fecha,
        $ganancia = 0,
        $contabilizado_entrada = 0,
        $contabilizado_salida = 0)
    {
        return Movimientos::create([
            'id_cuota' => $idCuota,
            'entrada' => $entrada,
            'salida' => $salida,
            'fecha' => $fecha,
            'ganancia' => $ganancia,
            'contabilizado_entrada' => $contabilizado_entrada,
            'contabilizado_salida' => $contabilizado_salida
        ]);
    }

    public function movimientosDeCuota($idCuota)
    {
        return Movimientos::where('id_cuota', $idCuota)->get();
    }

    public function find($id)
    {
        return Movimientos::find($id);
    }

    public function modificar(
        $idCuota,
        $entrada,
        $salida,
        $fecha,
        $ganancia,
        $contabilizado_entrada,
        $contabilizado_salida,
        $id
    )
    {
        $movimiento = $this->find($id);
        $movimiento->id_cuota = $idCuota;
        $movimiento->entrada = $entrada;
        $movimiento->salida = $salida;
        $movimiento->fecha = $fecha;
        $movimiento->ganancia = $ganancia;
        $movimiento->contabilizado_entrada = $contabilizado_entrada;
        $movimiento->contabilizado_salida = $contabilizado_salida;
        $movimiento->save();
        return $movimiento;
    }
}