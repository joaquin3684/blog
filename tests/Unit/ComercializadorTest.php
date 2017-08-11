<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\AgenteFinanciero;
use App\Repositories\Eloquent\Comercializador;
use App\Repositories\Eloquent\Proveedor;
use App\Repositories\Eloquent\Repos\Gateway\ComercializadorGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use App\Repositories\Eloquent\Repos\Mapper\AgenteFinancieroMapper;
use App\Repositories\Eloquent\Repos\Mapper\ComercializadorMapper;
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
    public function setUp()
    {
        parent::setUp();
        $this->comerMapper = new ComercializadorMapper();
        $this->agenteMapper = new AgenteFinancieroMapper();
        $this->comerGateway = new ComercializadorGateway();
        $this->solicitudGateway = new SolicitudGateway();


    }


    public function getData()
    {
        return collect([
            'nombre' => 'pepe',
            'apellido' => 'gutierrez',
            'cuit' => '1',
            'domicilio' => '1',
            'telefono' => '1',
            'codigo_postal' => '1',
            'comercializador' => '1',
            'doc_recibo' => '1',
            'doc_documento' => '1',
            'doc_domicilio' => '1',
            'doc_cbu' => '1',
            'doc_endeudamiento' => '1',
            'total' => '1',
            'cuotas' => '1',
            'monto_por_cuota' => '1',
            'organismo' => '1',
            'fecha_nacimiento' => '2017-02-04',
            'dni' => '1',
            'localidad' => '1',
            'legajo' => '1',

        ]);
    }

    public function testDeGenerarSolicitud()
    {
        $agente = collect([new Proveedor(1, 'pedro', 'sdfsd')]);
        $data = $this->getData();
        $comercializador = new Comercializador(1);
        $comercializador->generarSolicitud($data, $agente);
        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $this->assertEquals($comerExpected->getSolicitudes(), $comercializador->getSolicitudes());
    }


    public function testGenerarSolicitudConDosAgenteFinancieroComoResultadoDelFiltro()
    {
        $proveedor1 = new Proveedor(1, 'pedro', 'sdfsd');
        $proveedor2 = new Proveedor(2, 'martin', 'fdd');
        $data = $this->getData();
        $agentes = collect([$proveedor1, $proveedor2]);
        $comercializador = new Comercializador(1);
        $comercializador->generarSolicitud($data, $agentes);
        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $solicitudesSinInversionistas = SolicitudesSinInversionista::all();

        $this->assertEquals($solicitudesSinInversionistas->count(), 2);

    }

    public function testTraerLasSolicitudesPorElUsuario()
    {
        $data = $this->getData();
        $data->put('estado', '2');
        $this->solicitudGateway->create($data->toArray());
        $comercializador = $this->comerGateway->findSolicitudesFromUser(1);
        $this->assertEquals($comercializador->solicitudes()->count(), 1);
    }
}
