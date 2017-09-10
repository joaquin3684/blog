<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\VentasRepo;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DarServicioTest extends TestCase
{

    use DatabaseTransactions;

    public function getData()
    {
        return collect([
            'id_asociado' => 1,
            'id_producto' => 5,
            'nro_cuotas' => 5,
            'total' => '500',
            'fecha_vencimiento' => Carbon::today()->addMonths(2)->toDateString(),
        ]);
    }



    public function testCrearServicio()
    {
        $req = $this->getData()->toArray();
        $ventaRepo = new VentasRepo();
        $venta = $ventaRepo->create($req);
        $estadoRepo = new EstadoVentaRepo();
        $estado = $estadoRepo->create(['id_venta' => $venta->getId(),
                            'id_responsable_estado' => 1,
                            'estado' => 'ALTA']);

        $ventaExpected = $ventaRepo->find($venta->getId());
        $estadoExpected = $estadoRepo->find($estado->getId());
        $this->assertEquals($ventaExpected, $venta);
        $this->assertEquals($estadoExpected, $estado);
    }
}
