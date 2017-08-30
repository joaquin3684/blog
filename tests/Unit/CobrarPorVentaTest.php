<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Cobranza\CobrarPorVenta;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CobrarPorVentaTest extends TestCase
{

    use DatabaseTransactions;

    public function testComprobarQueSeCobraLaCantidadEspecificada()
    {
        $monto = 500;
        $ventasRepo = new VentasRepo();
        $ventaCuotasVencidas = $ventasRepo->findWithCuotas(1);

        $cobrar = new CobrarPorVenta();
        $cobrar->cobrar($ventaCuotasVencidas, $monto);
        $totalCobrado = $ventaCuotasVencidas->getCuotas()->sum(function($cuota){
            return $cuota->totalEntradaDeMovimientosDeCuota();
        });

        $cuota = $ventaCuotasVencidas->getCuotas()->all()[0];
        $this->assertEquals($totalCobrado, $monto);
        $this->assertEquals($cuota->getEstado(), 'Cobro Total');
    }

    public function testProbarQueSeCobrenMasDeUnaCuota()
    {
        $monto = 800;
        $ventasRepo = new VentasRepo();
        $ventaCuotasVencidas = $ventasRepo->findWithCuotas(1);

        $cobrar = new CobrarPorVenta();
        $cobrar->cobrar($ventaCuotasVencidas, $monto);
        $totalCobrado = $ventaCuotasVencidas->getCuotas()->sum(function($cuota){
            return $cuota->totalEntradaDeMovimientosDeCuota();
        });

        $cuota1 = $ventaCuotasVencidas->getCuotas()->all()[0];
        $cuota2 = $ventaCuotasVencidas->getCuotas()->all()[1];
        $this->assertEquals($totalCobrado, $monto);
        $this->assertEquals($cuota1->getEstado(), 'Cobro Total');
        $this->assertEquals($cuota2->getEstado(), 'Cobro Parcial');
    }

    /**
     * @expectedException \App\Exceptions\MasPlataCobradaQueElTotalException
     * @expectedExceptionMessage La cantidad de dinero ingresada es superior al monto que se puede cobrar.
     */
    public function testQueSalgaLaExcepcionCuandoPongoPlataDeMas()
    {
        $monto = 5000;
        $ventasRepo = new VentasRepo();
        $ventaCuotasVencidas = $ventasRepo->findWithCuotas(1);
        $cobrar = new CobrarPorVenta();
        $cobrar->cobrar($ventaCuotasVencidas, $monto);
    }
}
