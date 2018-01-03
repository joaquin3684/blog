<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class ABM_OperacionesTest extends TestCase
{

    use DatabaseTransactions;

    public function data()
    {
        $f = Factory::create('App\Organismos');
        return [0
            'nombre' => '$f->name',
            'cuit' => $f->randomNumber(5),
            'localidad' => "hola",
            'domicilio' => '0',
            'cuota_social' => ['valor' => 3]
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
        $response = $this->post('organismos', $data->toArray());
        $data->forget('cuota_social');
        $this->assertDatabaseHas('organismos', $data->toArray());
    }

    public function testModificacionOrganismo()
    {
        $data = $this->data();
        $response = $this->put('organismos', $data);
        $this->assertDatabaseHas('organismos', $data);
    }
}
