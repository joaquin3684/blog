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
   /* public function setUp()
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
    }*/

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


}
