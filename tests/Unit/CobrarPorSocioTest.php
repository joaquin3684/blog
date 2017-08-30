<?php

namespace Tests\Unit;

use App\Exceptions\MasPlataCobradaQueElTotalException;
use App\Movimientos;
use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CobrarPorSocioTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProbarQueSeCobroElMontoDado()
    {
        $monto = 300;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->ventasConCuotasVencidas(1);
        $cobrar = new CobrarPorSocio($socio);
        $cobrar->cobrar($monto);

        $totalCobrado = $socio->getVentas()->sum(function($venta){
            return $venta->getCuotas()->sum(function($cuota){
                return $cuota->totalEntradaDeMovimientosDeCuota();
            });
        });

        $this->assertEquals($totalCobrado, $monto);

    }

    public function testProbarQueFuncionanLasPrioridades()
    {
        $monto = 300;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->ventasConCuotasVencidas(1);
        $cobrar = new CobrarPorSocio($socio);
        $cobrar->cobrar($monto);

        $venta = $socio->getVentas()->filter(function($venta){
            return $venta->getCuotas()->sum(function($cuota){
                return $cuota->totalEntradaDeMovimientosDeCuota();
            }) > 0;
        });

        $this->assertEquals($venta->count(), 1);
        $this->assertEquals($venta->all()[0]->getId(), 1);

        $cobrar->cobrar(300);

        $venta = $socio->getVentas()->filter(function($venta){
            return $venta->getCuotas()->sum(function($cuota){
                    return $cuota->totalEntradaDeMovimientosDeCuota();
                }) > 0;
        });

        $cuotasVenta1 = $venta->all()[0]->getCuotas();
        $cuotasVenta2 = $venta->all()[1]->getCuotas();

        $cuota1Venta1 = $cuotasVenta1->all()[0];
        $cuota2Venta2 = $cuotasVenta2->all()[0];
        $totalCuota2Venta2 = $cuota2Venta2->totalEntradaDeMovimientosDeCuota();
        $totalCuota1Venta1 = $cuota1Venta1->totalEntradaDeMovimientosDeCuota();



        $this->assertEquals($venta->count(), 2);
        $this->assertEquals($totalCuota1Venta1, 500);
        $this->assertEquals($totalCuota2Venta2, 100);
        $this->assertEquals($cuota1Venta1->getEstado(), 'Cobro Parcial');
        $this->assertEquals($cuota2Venta2->getEstado(), 'Cobro Parcial');
    }


    /**
     * @expectedException \App\Exceptions\MasPlataCobradaQueElTotalException
     * @expectedExceptionMessage La cantidad de dinero ingresada es superior al monto que se puede cobrar.
     */
    public function testQueSalgaLaExcepcionCuandoPongoPlataDeMas()
    {
        //TODO: cambiar el factory de las cuotas que cree aunque sea una un mes adelante del dia de la fecha actual
        //todo : pensar como hacer para que la excepcion funcione bien
        $monto = 4001;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->ventasConCuotasVencidas(1);
        $cobrar = new CobrarPorSocio($socio);
        $cobrar->cobrar($monto);
    }

    public function testCobrarPlataDeMasDelTotalVencidoYQueSePongaEnLasCuotasFuturas()
    {
        $monto = 3999;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->ventasConCuotasVencidas(1);
        $cobrar = new CobrarPorSocio($socio);
        $cobrar->cobrar($monto);
    }

}
