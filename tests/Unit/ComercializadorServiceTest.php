<?php

namespace Tests\Unit;

use App\Services\ComercializadorService;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComercializadorServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistema');
        $this->seed('InicioSistemaSoloAbms');

    }

/*    public function testGenerarSolicitud()
    {
        $mock = Mockery::mock('alias:Sentinel');
        $user = new \stdClass();
        $user->id = 1;
        $mock->shouldReceive('check')->andReturn($user);

        $service = new ComercializadorService();
        $data=[
            'nombre' => 'pepe, argento',
            'apellido' => 'argento',
            'cuit' => '1',
            'domicilio' => '1',
            'departamento' => '1',
            'nucleo' => '1',
            'fecha_nacimiento' => '2017-02-02',
            'sexo' => 'Masculino',
            'codigo_postal' => '1',
            'telefono' => '4674-7274',
            'id_organismo' => 1,
            'dni' => 39624527,
            'localidad' => '1',
            'legajo' => '1'
        ];

        $service->generarSolicitud($data);
        
        $this->assertDatabaseHas('socios', [
            'nombre' => 'pepe, argento',
            'apellido' => 'argento',
            'cuit' => '1',
            'domicilio' => '1',
            'departamento' => '1',
            'nucleo' => '1',
            'fecha_nacimiento' => '2017-02-02',
            'sexo' => 'Masculino',
            'codigo_postal' => '1',
            'telefono' => '4674-7274',
            'id_organismo' => 1,
            'dni' => 39624527,
            'localidad' => '1',
            'legajo' => '1']);
        
        $this->assertDatabaseHas('solicitud', ['id_socio' => 11, 'comercializador' => 1]);
    }*/
}
