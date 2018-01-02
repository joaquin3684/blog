<?php

namespace Tests\Unit;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_CapitulosTest extends TestCase
{

    use DatabaseTransactions;

    public $factory;
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->factory = Factory::create('App\Capitulo');
    }

    public function data()
    {
        $f = Factory::create('App\Capitulo');
        return [
            'nombre' => $f->name,
            'codigo' => $f->randomNumber(5),
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
        $response = $this->post('capitulo', $this->data());
        $this->assertDatabaseHas('capitulos', $this->data());
    }

    public function testUpdateCapitulo(){

    }
}
