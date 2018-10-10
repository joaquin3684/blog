<?php

namespace Tests\Unit;

use App\Services\ABM_ProductosService;
use App\Services\ABM_ProveedorService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class ABM_ProductoTest extends TestCase
{
    use DatabaseMigrations;

    public $factory;
    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistema');
        $this->seed('ProovedoresTablaSeeder');

    }

    public function data()
    {
        $f = Factory::create('App\Capitulo');
        return [
            'id_proovedor' => 1,
            'descripcion' => "1",
            'ganancia' => 20,
            'nombre' => "canelon",
            'tipo' => "pasta",
            'tasa' => 10,
            "porcentajes" => [[
                'desde' => 300,
                'hasta' => 100,
                'porcentaje' => 20,
                'id_producto' => 1],
                [
                    'desde' => 400,
                    'hasta' => 200,
                    'porcentaje' => 20,
                    'id_producto' => 1]
            ]

        ];

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaProducto()
    {
        $data = $this->data();
        $service = new ABM_ProductosService();
        $service->crearProducto($data);
        $porcentajes = collect($data['porcentajes']);


        $porcentajes->each(function($p){
            $this->assertDatabaseHas('porcentaje_colocaciones', $p);
        });
        unset($data['porcentajes']);
        $this->assertDatabaseHas('productos', $data);
    }
}
