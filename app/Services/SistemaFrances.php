<?php


namespace App\Services;


class SistemaFrances
{
    public $totalCredito;
    public $cantidadCuotas;
    public $tasaMensual;

    public function __construct($totalCredito, $cantidadCuotas, $tasaMensual)
    {
        $this->totalCredito   = $totalCredito;
        $this->cantidadCuotas = $cantidadCuotas;
        $this->tasaMensual    = $tasaMensual;
    }

    public function desarrolloPrestamo()
    {
        $porcentajeTasaMensual = ($this->tasaMensual /100);
        $valorCuota = round(($this->totalCredito * $porcentajeTasaMensual)/ (1-pow((1+$porcentajeTasaMensual),(-$this->cantidadCuotas))),2);
        $desarrolloPrestamo = [];
        $capitalTotal = $this->totalCredito;
        for($i=1; $i <= $this->cantidadCuotas; $i++ )
        {
            $interesCuota = $capitalTotal * $porcentajeTasaMensual;
            $capitalCuota = $valorCuota - $interesCuota;
            $saldo = $capitalTotal - $capitalCuota;
            $desarrolloPrestamo[$i] = ['saldo' => $saldo,  'amortizacion' => $capitalCuota, 'interes' => $interesCuota];
            $capitalTotal = $saldo;
        }
        return $desarrolloPrestamo;
    }


    public function interesAcumuladoHastaLaCuota($nroCuota)
    {
        $desarrolloPrestamoHastaCuota = $this->getDesarrolloPrestamoHastaLaCuota($nroCuota);
        return array_sum(array_map(function($cuota){return $cuota['interes'];}, $desarrolloPrestamoHastaCuota));
    }

    public function amortizacionAcumuladaHastaLaCuota($nroCuota)
    {
        $desarrolloPrestamoHastaCuota = $this->getDesarrolloPrestamoHastaLaCuota($nroCuota);
        return array_sum(array_map(function($cuota){return $cuota['amortizacion'];}, $desarrolloPrestamoHastaCuota));
    }

    private function getDesarrolloPrestamoHastaLaCuota($nroCuota)
    {
        $desarrolloPrestamo = $this->desarrolloPrestamo();
        return array_slice($desarrolloPrestamo, 0, $nroCuota-1);
    }
}
