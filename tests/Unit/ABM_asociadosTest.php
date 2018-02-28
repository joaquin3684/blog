<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_asociadosTest extends TestCase
{

    use DatabaseMigrations;

    public function data()
    {
        return [
            'codigo' => '1234',
            'id_subrubro' => '1',
            'nombre' => '1',
        ];
    }

    public function testStore()
    {
        $response = $this->post('imputacion', $this->data());
        $this->assertDatabaseHas('imputaciones', $this->data());
    }
}
