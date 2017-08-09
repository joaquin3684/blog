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

    public function setUp()
    {
        parent::setUp();
        $this->solicitudGateway = new SolicitudGateway();
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
                                             'doc_endeudamiento' => '',
                                             'agente_financiero' => null,
                                             'estado' => '1']);

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
                                        'doc_endeudamiento' => '',
                                        'agente_financiero' => 1,
                                        'estado' => '1']);
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

    public function testTraerLasSolicitudesQueSeTenganQueAprobar()
    {
        $this->assertEquals(2, $this->solicitudGateway->solicitudesSinAsignar()->count());
    }


}
