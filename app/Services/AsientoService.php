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

    public function crear($cuentas, $fechaValor = null)
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
            Asiento::create(['id_imputacion' => $cuenta->id, 'nombre' => $cuenta->nombre, 'codigo' => $cuenta->codigo, 'debe' => $debe, 'haber' => $haber, 'id_ejercicio' => $ejercicio->id, 'fecha_contable' => Carbon::today()->toDateString(), 'fecha_valor' => $fechaVal->toDateString(), 'nro_asiento' => $nroAsiento]);
            $this->saldoService->modificar($cuenta, Carbon::today(), $debe, $haber);
        }


    }

    public function ultimoAsiento()
    {
        return Asiento::orderBy('nro_asiento', 'desc')->first();
    }
}