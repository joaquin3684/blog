<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Cobranza\CobrarCuotasSociales;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CobroCuotasSocialesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function cobrarCuotas()
    {
        $id_socio = 11;
        $monto = 200;
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->cuotasSociales($id_socio);
        $cobrarObj = new CobrarCuotasSociales();
        $cobrarObj->cobrar($socio, $monto);

        $cobrado = $socio->getCuotasSociales()->sum(function($item, $key){

        });
    }
}
