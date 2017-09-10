<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AprobarServicioTest extends TestCase
{
    use DatabaseTransactions;


    public function setUp()
    {
        parent::setUp();
        $this->venta = Ventas::create($this->getData()->toArray());
    }


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



    public function testAprobarServicio()
    {
            $id = $this->venta->id;
            $estado = 'APROBADO';
            $observacion = '';
            $estadoRepo = new EstadoVentaRepo();
            $data = array('id_venta' => $id, 'id_responsable_estado' => 1, 'estado' => $estado, 'observacion' => $observacion);
            $actualEstado = $estadoRepo->create($data);
            $ventasRepo = new VentasRepo();
            $venta = $ventasRepo->find($id);
            if($estado == 'APROBADO')
            {
               $actualVenta =  GeneradorCuotas::generarCuotasVenta($venta);
            }else if($estado == 'RECHAZADO')
            {
                $actualVenta = $ventasRepo->destroy($id);
            }

            $map = new VentasMapper();
            $expectedVenta = $map->map(Ventas::with('cuotas')->find($venta->getId()));
            $expectedEstado = $estadoRepo->find($actualEstado->getId());


            $this->assertEquals($expectedEstado, $actualEstado);
            $this->assertEquals($expectedVenta, $actualVenta);

        }

        public function testRechazarServicio()
        {
            $id = $this->venta->id;
            $estado = 'RECHAZADO';
            $observacion = '';
            $estadoRepo = new EstadoVentaRepo();
            $data = array('id_venta' => $id, 'id_responsable_estado' => 1, 'estado' => $estado, 'observacion' => $observacion);
            $actualEstado = $estadoRepo->create($data);
            $ventasRepo = new VentasRepo();
            $venta = $ventasRepo->find($id);
            if($estado == 'APROBADO')
            {
                $actualVenta =  GeneradorCuotas::generarCuotasVenta($venta);
            }else if($estado == 'RECHAZADO')
            {
                $ventasRepo->destroy($id);
            }

            $actualVenta = Ventas::withTrashed()->find($venta->getId());
            $expectedEstado = $estadoRepo->find($actualEstado->getId());


            $this->assertEquals($expectedEstado, $actualEstado);
            $this->assertEquals(true, $actualVenta->trashed());
        }

}
