<?php
/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 17/04/19
 * Time: 09:11
 */

namespace App\Services;


use App\Asiento;
use App\Ejercicio;
use App\Exceptions\EjercicioCerradoException;
use App\Repositories\Eloquent\CalcularSaldos;
use Carbon\Carbon;

class AsientoService
{
    private $saldoService;

    public function __construct()
    {
        $this->saldoService = new SaldoService();
    }

    public function crear($cuentas, $observacion, $fechaValor = null)
    {

        $ultimoAsiento = $this->ultimoAsiento();
        $nroAsiento = $ultimoAsiento->nro_asiento + 1;

        $fechaVal = $fechaValor == null ? Carbon::today() : Carbon::createFromFormat('Y-m-d', $fechaValor);

        $ejercicio = Ejercicio::where('fecha', '<', $fechaVal->toDateString())
            ->where('fecha_cierre', null)
            ->orderBy('id', 'desc')
            ->first();

        if($ejercicio == null)
        {
            throw new EjercicioCerradoException('ejercicio_cerrado');
        }

        foreach($cuentas as $c)
        {
            $cuenta = ImputacionService::findByCodigo($c['cuenta']);
            $debe = $c['debe'];
            $haber = $c['haber'];
            Asiento::create(['id_imputacion' => $cuenta->id, 'nombre' => $cuenta->nombre, 'codigo' => $cuenta->codigo, 'debe' => is_null($debe) ? 0 : $debe, 'haber' => is_null($haber) ? 0 : $haber, 'id_ejercicio' => $ejercicio->id, 'fecha_contable' => Carbon::today()->toDateString(), 'fecha_valor' => $fechaVal->toDateString(), 'nro_asiento' => $nroAsiento, 'observacion' => $observacion]);
            $this->saldoService->modificar($cuenta, Carbon::today(), $debe, $haber);
        }


    }

    public function modificar($cuentas, $observacion, $nroAsiento, $fechaValor = null)
    {
        $this->borrar($nroAsiento);
        $this->crear($cuentas, $observacion, $fechaValor);
    }

    public function renumerar($fecha)
    {
        $asientos = Asiento::where('fecha_contable', '>=', $fecha)->orderBy('nro_asiento')->get();
        $asientoAnterior = $asientos->first();
        $nroAsientoAnterior = $asientoAnterior->nro_asiento;
        $nroNuevo = $asientoAnterior->nro_asiento;

        foreach ($asientos as $asiento)
        {
            if($nroAsientoAnterior == $asiento->nro_asiento)
            {
                $asiento->nro_asiento = $nroNuevo;
                $asiento->save();
            } else
            {
                $nroNuevo++;
                $nroAsientoAnterior = $asiento->nro_asiento;
                $asiento->nro_asiento = $nroNuevo;
                $asiento->save();
            }

        }
    }

    public function find($id)
    {
        return Asiento::find($id);
    }

    public function findFromNumero($nroAsiento)
    {
        return Asiento::where('nro_asiento', $nroAsiento)->get();
    }

    public function borrar($nroAsiento)
    {
       $asientos = $this->findFromNumero($nroAsiento);
       foreach ($asientos as $asiento)
       {
           // invierto el haber con el debe para cancelar lo que ya estaba hecho antes
           $this->saldoService->modificar($asiento->imputacion, Carbon::createFromFormat('Y-m-d',$asiento->fecha_contable), $asiento->haber, $asiento->debe);
       }
       Asiento::destroy($asientos->map(function($asiento){ return $asiento->id;})->toArray());

    }

    public function ultimoAsiento()
    {
        return Asiento::orderBy('nro_asiento', 'desc')->first();
    }
}