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
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->solicitudGateway = new SolicitudGateway();
        $data = $this->getData();
        $this->solicitudGateway->create($data->toArray());
    }

    public function getData()
    {
        return collect([
            'id_socio' => 1,
            'comercializador' => '1',
            'estado' => 'Procesando Solicitud',
        ]);
    }

    public function testEsperandoEndeudamientoYAgenteYcompletoUno()
    {
        $elem = collect(['doc_endeudamiento' => '200']);
        $col = collect();
        if($elem->has('doc_endeudamiento'))
        {
            $endeudamiento = $elem['doc_endeudamiento'];
            $col->put('doc_endeudamiento', $endeudamiento);

        }
        if ($elem->has('agente_financiero'))
        {
            $agente = $elem['agente_financiero'];
            $col->put('agente_financiero', $agente);
        }

        $sol = $this->solicitudGateway->update($col->toArray(), 1);
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Inversionista Asignado' : 'Procesando Solicitud';
        $sol->save();
        $this->assertEquals($sol->doc_endeudamiento, 200);
        $this->assertEquals($sol->agente_financiero, null);
        $this->assertEquals($sol->estado, 'Procesando Solicitud');
    }

    public function testEsperandoEndeudamientoYAgenteYcompletoAmbos()
    {
        $elem = collect(['doc_endeudamiento' => '200', 'agente_financiero' => 1]);
        $col = collect();
        if($elem->has('doc_endeudamiento'))
        {
            $endeudamiento = $elem['doc_endeudamiento'];
            $col->put('doc_endeudamiento', $endeudamiento);

        }
        if ($elem->has('agente_financiero'))
        {
            $agente = $elem['agente_financiero'];
            $col->put('agente_financiero', $agente);
        }

        $sol = $this->solicitudGateway->update($col->toArray(), 1);
        $sol->estado = $sol->doc_endeudamiento != null && $sol->agente_financiero != null ? 'Inversionista Asignado' : 'Procesando Solicitud';
        $sol->save();
        $this->assertEquals($sol->estado, 'Inversionista Asignado');
        $this->assertEquals($sol->doc_endeudamiento, 200);
        $this->assertEquals($sol->agente_financiero, 1);
    }




}
