<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SolicitudesEsperandoMutualTest extends TestCase
{
    use DatabaseTransactions;

    private $solicitudGateway;

   public function testPiola1()
   {
       $this->assertTrue(true);
   }


}
