<?php

namespace Tests\Unit;

use App\Movimientos;
use App\Repositories\Eloquent\Cobranza\CobrarPorSocio;
use App\Repositories\Eloquent\Repos\SociosRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CobrarPorSocioTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProbarCobrarPorSocioAndaBien()
    {
        $socioRepo = new SociosRepo();
        $socio = $socioRepo->ventasConCuotasVencidas(1);
        $cobrar = new CobrarPorSocio($socio);
        $cobrar->cobrar(300);



    }
}
