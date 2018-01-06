<?php

namespace Tests\Unit;

use App\Capitulo;
use App\ConfigImputaciones;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_CapitulosTest extends TestCase
{

    use DatabaseMigrations;

    public $factory;
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function data()
    {
        $f = Factory::create('App\Capitulo');
        return [
            'nombre' => $f->name,
            'codigo' => $f->randomNumber(4),
            'afecta_codigo_base' => 0
        ];
    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaCapitulo()
    {
        $data = $this->data();
        $response = $this->post('capitulo', $data);
        $this->assertDatabaseHas('capitulos', $data);
    }

    public function testUpdateCapituloConMismoCodigo(){
        $data = $this->data();
        $data2 = $this->data();
        $data2['codigo'] = $data['codigo'];
        $cap = Capitulo::create($data);
        $data2['id'] = $cap->id;
        $response = $this->put('capitulo/'.$cap->id, $data2);
        $this->assertDatabaseHas('capitulos', $data2);
    }

    public function testUpdateCapituloConDistintoCodigoSinAfectarCodigoBase(){
        $data = $this->data();
        $data2 = $this->data();
        $data2['codigo'] = $data['codigo'] + 1;
        $data['afecta_codigo_base'] = 0;
        $cap = Capitulo::create($data);
        $data2['id'] = $cap->id;
        $response = $this->put('capitulo/'.$cap->id, $data2);
        $this->assertDatabaseHas('capitulos', $data2);
    }


}
