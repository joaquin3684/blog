<?php

namespace Tests\Unit;

use App\Http\Controllers\ABM_asociados;
use App\Repositories\Eloquent\Proveedor;
use App\Repositories\Eloquent\Repos\SolicitudRepo;
use App\Repositories\Eloquent\Solicitud;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class AgenteFinancieroSolicitudesTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use DatabaseMigrations;

    private $solicitudRepo;
    public function setUp()
    {
        parent::setUp();
        $this->solicitudRepo = new SolicitudRepo();
    }

    public function testGenerarPropuesta()
    {

        $importe = 100;
        $cuotas = 5;
        $montoPorCuota = 120;
        $solicitud = factory(\App\Solicitud::class)->create();
        $proveedor = new Proveedor(1, 'pepe', 'asdfsad');
        $proveedor->generarPropuesta($importe, $montoPorCuota, $cuotas, $solicitud->id);
        $actualSol = $this->solicitudRepo->find($solicitud->id);
        $expectedSol = new Solicitud($solicitud->id, $importe, $montoPorCuota, $cuotas, 1, 'Esperando Respuesta Comercializador');
        $this->assertEquals($actualSol, $expectedSol);
    }

    public function testRechazarPropuesta()
    {
        $solicitud = factory(\App\Solicitud::class)->states('Modificada por Comercializador')->create();
        $proveedor = new Proveedor(1, 'pepe', 'asdfsad');
        $proveedor->rechazarPropuesta($solicitud->id);
        $actualSol = $this->solicitudRepo->find($solicitud->id);
        $expectedSol = new Solicitud($solicitud->id, $solicitud->total, $solicitud->monto_por_cuota, $solicitud->cuotas, $solicitud->doc_endeudamiento, 'Rechazada por Inversionista');
        $this->assertEquals($actualSol, $expectedSol);
    }

    public function testAceptarPropuesta()
    {
        $solicitud = factory(\App\Solicitud::class)->states('Modificada por Comercializador')->create();
        $proveedor = new Proveedor(1, 'pepe', 'asdfsad');
        $proveedor->aceptarPropuesta($solicitud->id);
        $actualSol = $this->solicitudRepo->find($solicitud->id);
        $expectedSol = new Solicitud($solicitud->id, $solicitud->total, $solicitud->monto_por_cuota, $solicitud->cuotas, $solicitud->doc_endeudamiento, 'Aceptada por Comercializador');
        $this->assertEquals($actualSol, $expectedSol);
    }


}
