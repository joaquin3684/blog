<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Cobranza\CobrarCuotasSociales;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CobroCuotasSocialesTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCobrarCuotas()
    {
        $id_socio = 11;
        $monto = 200;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->cuotasSociales($id_socio);
        $cobrarObj = new CobrarCuotasSociales();
        $cobrarObj->cobrar($socio, $monto);

        $cobrado = $socio->getCuotasSociales()->sum(function($cuota){
            return $cuota->totalEntradaDeMovimientosDeCuota();
        });

        $cuota1 = $socio->getCuotasSociales()->all()[0];
        $cuota2 = $socio->getCuotasSociales()->all()[1];


        $this->assertEquals($cobrado, $monto);
        $this->assertEquals(100, $cuota1->totalEntradaDeMovimientosDeCuota());
        $this->assertEquals(100, $cuota2->totalEntradaDeMovimientosDeCuota());
        $this->assertEquals('Cobro Total', $cuota1->getEstado());
        $this->assertEquals('Cobro Total', $cuota2->getEstado());
    }

    /**
     * @expectedException \App\Exceptions\MasPlataCobradaQueElTotalException
     * @expectedExceptionMessage La cantidad de dinero ingresada es superior al monto que se puede cobrar.
     */
    public function testQueSalgaLaExcepcionCuandoPongoPlataDeMas()
    {
        $id_socio = 11;
        $monto = 3000;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->cuotasSociales($id_socio);
        $cobrarObj = new CobrarCuotasSociales();
        $cobrarObj->cobrar($socio, $monto);
    }

    public function testCuotasSocialesConCobroParcial()
    {
        $id_socio = 11;
        $monto = 123;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->cuotasSociales($id_socio);
        $cobrarObj = new CobrarCuotasSociales();
        $cobrarObj->cobrar($socio, $monto);

        $cobrado = $socio->getCuotasSociales()->sum(function($cuota){
            return $cuota->totalEntradaDeMovimientosDeCuota();
        });

        $cuota1 = $socio->getCuotasSociales()->all()[0];
        $cuota2 = $socio->getCuotasSociales()->all()[1];


        $this->assertEquals($cobrado, $monto);
        $this->assertEquals(100, $cuota1->totalEntradaDeMovimientosDeCuota());
        $this->assertEquals(23, $cuota2->totalEntradaDeMovimientosDeCuota());
        $this->assertEquals('Cobro Total', $cuota1->getEstado());
        $this->assertEquals('Cobro Parcial', $cuota2->getEstado());
    }
}
