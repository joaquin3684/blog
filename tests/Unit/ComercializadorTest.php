<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\AgenteFinanciero;
use App\Repositories\Eloquent\Comercializador;
use App\Repositories\Eloquent\Proveedor;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;
use App\Repositories\Eloquent\Repos\Mapper\ComercializadorMapper;
use App\Repositories\Eloquent\Repos\Mapper\SolicitudMapper;
use App\Repositories\Eloquent\Repos\SolicitudesSinInversionistaRepo;
use App\Repositories\Eloquent\Solicitud;
use App\SolicitudesSinInversionista;
use App\Traits\Conversion;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComercializadorTest extends TestCase
{
    use DatabaseTransactions;
    use Conversion;
    /**
     * A basic test example.
     *
     * @return void
     */
    private $comerMapper;
    private $agenteMapper;
    private $comerGateway;
    private $solicitudGateway;
    private $solicitudMapper;
    public function setUp()
    {
        parent::setUp();
        $this->comerMapper = new ComercializadorMapper();
        $this->agenteMapper = new AgenteFinancieroMapper();
        $this->comerGateway = new ComercializadorGateway();
        $this->solicitudGateway = new SolicitudGateway();
        $this->solicitudMapper = new SolicitudMapper();


    }


    public function getData()
    {
        return collect([
            'id_socio' => 1,
            'comercializador' => '1',

        ]);
    }


    public function testDeGenerarSolicitud()
    {
        $agente = collect([new Proveedor(1, 'pedro', 'sdfsd')]);
        $data = $this->getData();
        $comercializador = new Comercializador(1);
        $solicitud = $comercializador->generarSolicitud($data, $agente);
        $solExpected = \App\Solicitud::find($solicitud->getId());
        $solExpected = $this->solicitudMapper->map($solExpected);
        $this->assertEquals($solExpected, $solicitud);
    }


    public function testGenerarSolicitudConDosAgenteFinancieroComoResultadoDelFiltro()
    {
        $proveedor1 = new Proveedor(1, 'pedro', 'sdfsd');
        $proveedor2 = new Proveedor(2, 'martin', 'fdd');
        $data = $this->getData();
        $agentes = collect([$proveedor1, $proveedor2]);
        $comercializador = new Comercializador(1);
        $solicitud = $comercializador->generarSolicitud($data, $agentes);
        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $solicitudesSinInversionistas = SolicitudesSinInversionista::all();

        $this->assertEquals($solicitudesSinInversionistas->count(), 2);
        $this->assertEquals($solicitud->getEstado(), 'Procesando Solicitud');

    }

    public function testTraerLasSolicitudesPorElUsuario()
    {

        $data = collect([
            'id_socio' => 1,
            'comercializador' => '1',
            'estado' => 'Esperando Inversionista',
        ]);

        $data1 = collect([
            'id_socio' => 1,
            'comercializador' => '2',
            'estado' => 'Esperando Inversionista',
        ]);

        $this->solicitudGateway->create($data->toArray());
        $this->solicitudGateway->create($data1->toArray());

        $comercializador = $this->comerGateway->findSolicitudesFromUser(1);
        $this->assertEquals($comercializador->solicitudes()->count(), 1);
    }

}
