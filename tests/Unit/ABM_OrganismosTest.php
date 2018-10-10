<?php

namespace Tests\Unit;

use App\Cuotas;
use App\Services\ABM_OrganismosService;
use App\Socios;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class ABM_OrganismosTest extends TestCase
{

    use DatabaseMigrations;

    public function data()
    {
        $f = Factory::create('App\Organismos');
        return [
            'id' => 1,
            'nombre' => $f->name,
            'cuit' => $f->randomNumber(5),
            'localidad' => $f->name,
            'domicilio' => $f->address,
            'cuota_social' => [['valor' => 3, 'categoria' => 0], ['valor' => 4, 'categoria' => 1]]
        ];
    }

    public function data2()
    {
        $f = Factory::create('App\Organismos');
        return [
            'id' => 1,
            'nombre' => $f->name,
            'cuit' => $f->randomNumber(5),
            'localidad' => $f->name,
            'domicilio' => $f->address,
            'cuota_social' => [['valor' => 23, 'categoria' => 0], ['valor' => 43, 'categoria' => 1]]
        ];
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaOrganismo()
    {
        $data = collect($this->data());

        $service = new ABM_OrganismosService();
        $service->crearOrganismo($data->toArray());

        $cuotaSocial = collect($data['cuota_social']);
        $data->forget('cuota_social');
        $this->assertDatabaseHas('organismos', $data->toArray());

        $cuotaSocial->each(function($cuota, $key) {
            $cuota['id_organismo'] = 1;
            $cuota['categoria'] = $key;
            $this->assertDatabaseHas('categoria_cuota_sociales', $cuota);

        });
    }

    public function testUpdateOrganismo()
    {
        $data = $this->data();
        $data2 = $this->data2();
        $response = $this->post('organismos', $data);

            $socio1 = factory(\App\Socios::class)->create(['id_organismo' => 1]);
            $socio2 = factory(\App\Socios::class)->create(['id_organismo' => 1]);

            $cuotaImpaga1 = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['cuotable_id' => $socio1->id, 'importe' => $data['cuota_social'][0]['valor']]);
            $cuotaPaga1 = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['cuotable_id' => $socio1->id, 'estado' => 'Cobro Total', 'importe' => $data['cuota_social'][0]['valor']]);

            $cuotaImpaga2 = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['cuotable_id' => $socio2->id, 'importe' => $data['cuota_social'][1]['valor']]);
            $cuotaPaga2 = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['cuotable_id' => $socio2->id, 'estado' => 'Cobro Total', 'importe' => $data['cuota_social'][1]['valor']]);


        $response = $this->put('organismos/1', $data2);

        $cuota1Paga = Cuotas::find($cuotaPaga1->id);
        $cuota2Paga = Cuotas::find($cuotaPaga2->id);
        $cuota1Impaga = Cuotas::find($cuotaImpaga1->id);
        $cuota2Impaga = Cuotas::find($cuotaImpaga2->id);
        $this->assertEquals($data['cuota_social'][0]['valor'], $cuota1Paga->importe);
        $this->assertEquals($data['cuota_social'][1]['valor'], $cuota2Paga->importe);
        $this->assertEquals($data2['cuota_social'][0]['valor'], $cuota1Impaga->importe);
        $this->assertEquals($data2['cuota_social'][1]['valor'], $cuota2Impaga->importe);
        $cuotaSocial = collect($data2['cuota_social']);
        unset($data2['cuota_social']);

        $this->assertDatabaseHas('organismos', $data2);

        $cuotaSocial->each(function($cuota, $key) {
            $cuota['id_organismo'] = 1;
            $cuota['categoria'] = $key;
            $this->assertDatabaseHas('categoria_cuota_sociales', $cuota);

        });

    }
}
