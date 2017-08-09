<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\AgenteFinanciero;
use App\Repositories\Eloquent\Comercializador;
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

    public function testDeGenerarSolicitud()
    {
        $agente = new AgenteFinanciero(1, 'pepe');
        $agentes = collect([$agente]);
        $comercializador = new Comercializador(1);
        $comercializador->generarSolicitud('Martin', 'Gutierrez', '123456', 'Calle falsa', '46716548', '1407', 'url1', 'url2', 'url3', 'url4', 'url5', $agentes);
        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $this->assertEquals($comerExpected->getSolicitudes(), $comercializador->getSolicitudes());
    }

    public function testGenerarSolicitudConUnAgenteFinancieroComoResultadoDelFiltro()
    {
        $ventas = DB::table('agentes_financieros')
            ->select('agentes_financieros.*');

        $filtro = ['nombre' => 'pedro'];
        $agentesFiltrados = \App\Repositories\Eloquent\Filtros\AgentesFinancierosFilter::apply($filtro, $ventas);
        $agentes = $agentesFiltrados->map(function($agente){
            return $this->agenteMapper->map($agente);
        });
        $comercializador = new Comercializador(1);
        $comercializador->generarSolicitud('Martin', 'Gutierrez', '123456', 'Calle falsa', '46716548', '1407', 'url1', 'url2', 'url3', 'url4', 'url5', $agentes);

        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $solicitudesSinInversionistas = SolicitudesSinInversionista::all();

        $this->assertEquals($solicitudesSinInversionistas->count(), 0);

    }

    public function testGenerarSolicitudConDosAgenteFinancieroComoResultadoDelFiltro()
    {
        $agentesFiltrados = DB::table('agentes_financieros')
            ->select('agentes_financieros.*')->get();
        $agentes = $agentesFiltrados->map(function($agente){
            return $this->agenteMapper->map($agente);
        });
        $comercializador = new Comercializador(1);
        $comercializador->generarSolicitud('Martin', 'Gutierrez', '123456', 'Calle falsa', '46716548', '1407', 'url1', 'url2', 'url3', 'url4', 'url5', $agentes);
        $comer = \App\Comercializador::with('solicitudes')->find(1);
        $comerExpected = $this->comerMapper->map($comer);
        $solicitudesSinInversionistas = SolicitudesSinInversionista::all();

        $this->assertEquals($solicitudesSinInversionistas->count(), 2);

    }

    public function testTraerLasSolicitudesPorElUsuario()
    {
        $this->solicitudGateway->create(['nombre' => '1',
            'apellido' => '1',
            'cuit' => '1',
            'domicilio' => '1',
            'telefono' => '1',
            'codigo_postal' => '1',
            'comercializador' => '1',
            'doc_documento' => '1',
            'doc_recibo' => '1',
            'doc_domicilio' => '1',
            'doc_cbu' => '1',
            'doc_endeudamiento' => '200',
            'agente_financiero' => 1,
            'estado' => '1']);
        $comercializador = $this->comerGateway->findSolicitudesFromUser(1);
        $this->assertEquals($comercializador->solicitudes()->count(), 1);
    }
}
