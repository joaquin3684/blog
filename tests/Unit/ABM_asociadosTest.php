<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_asociadosTest extends TestCase
{

    public function data()
    {
        return [
            'nombre' => '1',
            'apellido' => '1',
            'fecha_nacimiento' => '1',
            'valor' => '1',
            'cuit' => '1',
            'dni' => '1',
            'domicilio' => '1',
            'sexo' => '1',
            'localidad' => '1',
            'codigo_postal' => '1',
            'telefono' => '1',
            'id_organismo' => '1',
            'fecha_ingreso' => '1',
            'legajo' => '1',
        ];
    }
    public function testStore()
    {
        $response = $this->post('asociados', $this->data());
        $this->assertDatabaseHas('socios', $this->data());
    }
}
