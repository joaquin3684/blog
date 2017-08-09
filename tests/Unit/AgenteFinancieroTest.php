<?php

namespace Tests\Unit;

use App\Repositories\Eloquent\Repos\Gateway\AgenteFinancieroGateway;
use App\Repositories\Eloquent\Repos\Gateway\ProveedoresGateway;
use App\Repositories\Eloquent\Repos\Gateway\SolicitudGateway;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AgenteFinancieroTest extends TestCase
{

    use DatabaseTransactions;

    private $solicitudGateway;
    private $agenteGateway;
    public function setUp()
    {
        parent::setUp();
        $this->solicitudGateway = new SolicitudGateway();
        $this->agenteGateway = new ProveedoresGateway();
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
    }


    public function testTraerSolicitudes()
    {
        $agente =  $this->agenteGateway->findSolicitudesByAgenteFinanciero(1);
        $this->assertEquals($agente->solicitudes()->count(), 1);
    }
}
