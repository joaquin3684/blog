<?php


namespace App\Services;


use App\Cuotas;
use App\Imputacion;
use App\Ventas;

class CobrarVenta
{
    /**
     * @var Ventas
     */
    private $venta;
    private $monto;

    public function __construct(Ventas $venta, $monto)
    {
        $this->venta = $venta;
        $this->monto = $monto;
    }


    public function cobrar()
    {
        $cuotasPendientes = $this->venta->cuotasPendientes();
        $cuotasPendientesDeCobro = $cuotasPendientes->map(function($cuota){
            return ['nro_cuota' => $cuota->nro_cuota, 'montoCobradoPrevioAlCobroActual' => $cuota->totalCobrado()];
        });
        $totalCobrado = 0;
        $monto = $this->monto;
        foreach ($cuotasPendientes as $cuota) {
            if ($monto == 0)
                break;
            $cobrado      = $cuota->cobrar($this->monto);
            $monto  -= $cobrado;
            $totalCobrado += $cobrado;
        }
        $this->contabilizarCobro($totalCobrado, $this->venta, $cuotasPendientesDeCobro);

        return $totalCobrado;

    }

    /**
     * @param $cuotasPendientesDeCobro
     * @return int|mixed
     */
    public function calculoInteresGanado($cuotasPendientesDeCobro)
    {
        $tasaMensual      = $this->venta->tasaMensual();
        $totalCredito     = $this->venta->importe_otorgado;
        $sistemaFrances   = new SistemaFrances($totalCredito, $this->venta->cuotas->count(), $tasaMensual);
        $monto            = $this->monto;
        $interesTotal     = 0;
        foreach ($cuotasPendientesDeCobro as $cuota) {
            if ($monto == 0)
                break;
            $interesCuota                      = $sistemaFrances->desarrolloPrestamo()[$cuota['nro_cuota']]['interes'];
            $amortizacionCuota                 = $sistemaFrances->desarrolloPrestamo()[$cuota['nro_cuota']]['amortizacion'];
            $montoCobradoHastaElMomento        = $cuota['montoCobradoPrevioAlCobroActual'];
            $interesCobradoHastaElMomento      = $interesCuota > $montoCobradoHastaElMomento ? $montoCobradoHastaElMomento : $montoCobradoHastaElMomento - $interesCuota;
            $amortizacionCobradaHastaElMomento = $interesCobradoHastaElMomento <= $montoCobradoHastaElMomento ? $montoCobradoHastaElMomento - $interesCobradoHastaElMomento : 0;
            $faltaCobrarInteres                = $interesCuota > $interesCobradoHastaElMomento;
            if ($faltaCobrarInteres) {
                $interesCobrado = $interesCuota - $interesCobradoHastaElMomento > $monto ? $monto : $interesCuota - $interesCobradoHastaElMomento;
                $monto          -= $interesCobrado;
                $interesTotal   += $interesCobrado;
            }
            if ($monto == 0)
                break;
            $monto -= $amortizacionCuota - $amortizacionCobradaHastaElMomento > $monto ? $monto : $amortizacionCuota - $amortizacionCobradaHastaElMomento;

        }
        return $interesTotal;
    }

    public function contabilizarCobro($montoContableReal, Ventas $venta, $cuotasPendientesDeCobro)
    {

        $porcentajeOrganismo = $venta->socio->organismo->gasto_cobranza;

        $comisionPagada = $montoContableReal * ($porcentajeOrganismo / 100);
        $totalBanco     = $montoContableReal - $comisionPagada;
        $producto       = $venta->producto;

        $asientoService = new AsientoService();

        if ($producto->proovedor->id == 1) {

            $asientoService->crear([
                ['cuenta' => 111010201, 'debe' => $totalBanco, 'haber' => 0],
                ['cuenta' => 521020218, 'debe' => $comisionPagada, 'haber' => 0],
                ['cuenta' => 131020403, 'debe' => $this->calculoInteresGanado($cuotasPendientesDeCobro), 'haber' => 0],
                ['cuenta' => 511010104, 'debe' => 0, 'haber' => $this->calculoInteresGanado($cuotasPendientesDeCobro)],
                ['cuenta' => 131010001, 'debe' => 0, 'haber' => $montoContableReal],
            ], '');

        } else {

            $cta = Imputacion::where('nombre', 'Cta ' . $producto->proovedor->razon_social)->first();

            $comisionGanada = $montoContableReal * $producto->ganancia / 100;
            $capital        = $montoContableReal - $comisionGanada;

            $asientoService->crear([
                ['cuenta' => 111010201, 'debe' => $totalBanco, 'haber' => 0],
                ['cuenta' => 521020218, 'debe' => $comisionPagada, 'haber' => 0],
                ['cuenta' => $cta->codigo, 'debe' => 0, 'haber' => $capital],
                ['cuenta' => 511010103, 'debe' => 0, 'haber' => $comisionGanada],
            ], '');
        }
    }
}
