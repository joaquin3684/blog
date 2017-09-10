<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CorrerVtoTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp()
    {
        parent::setUp();
    }

    public function testCorrerVto()
    {
        $venta = collect(['id_asociado' => 1,
            'id_producto' => 1,
            'nro_cuotas' => 2,
            'importe' => 400,
            'fecha_vencimiento' => '2017-04-01',
            ]);
        $ventasRepo = new VentasRepo();
        $cuotasRepo = new CuotasRepo();
        $v = $ventasRepo->create($venta->toArray());
        $cuota1 = collect(['cuotable_id' => $v->getId(),
            'cuotable_type' => 'App\Ventas',
            'importe' => 200,
            'fecha_vencimiento' => '2017-04-01',
            'fecha_inicio' => '2017-03-01',
            'nro_cuota' => '1']);
        $cuota2 = collect(['cuotable_id' => $v->getId(),
            'cuotable_type' => 'App\Ventas',
            'importe' => 200,
            'fecha_vencimiento' => '2017-05-01',
            'fecha_inicio' => '2017-04-01',
            'nro_cuota' => '2']);
        $cuota1 = $cuotasRepo->create($cuota1->toArray());
        $cuota2 = $cuotasRepo->create($cuota2->toArray());
        $dias = 5;
        $venta1 = $ventasRepo->findWithCuotas($v->getId());
        $venta1->correrVto($dias);
        $cuota1Expected = $cuotasRepo->find($cuota1->getId());
        $cuota2Expected = $cuotasRepo->find($cuota2->getId());

        $this->assertEquals($venta1->getFechaVencimiento(), '2017-04-06');
        $this->assertEquals($cuota1Expected->getFechaVencimiento(), '2017-04-06');
        $this->assertEquals($cuota2Expected->getFechaVencimiento(), '2017-05-06');
        $this->assertEquals($cuota2Expected->getFechaInicio(), '2017-04-06');
        $this->assertEquals($cuota1Expected->getFechaInicio(), '2017-03-06');
    }
}
