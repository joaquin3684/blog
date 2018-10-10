<?php

namespace Tests\Unit;

use App\Services\ABM_ComercializadorService;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_ComercializadorTest extends TestCase
{
    use DatabaseMigrations;

    public $factory;
    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistema');

    }

    public function data()
    {
        $f = Factory::create('App\Capitulo');
        return [
            'nombre' => $f->firstName(),
            'dni' => $f->randomNumber(8),
            'cuit' => $f->randomNumber(8),
            'telefono' => $f->randomNumber(8),
            'usuario' => 'prueba',
            'apellido' => $f->lastName,
            'domicilio' =>  $f->address,
            'email' => $f->email,
            'porcentaje_colocacion' => $f->randomNumber(2),
            'password' => 'prueba'
        ];

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaComercializador()
    {
        $data = $this->data();
        $service = new ABM_ComercializadorService();
        $service->crearComer($data);



        $user = ['usuario' => $data['usuario'], 'email' => $data['email']];
        $data['usuario'] = 2;
        unset($data['password']);
        $this->assertDatabaseHas('imputaciones', ['nombre' => 'Comisiones a pagar '.$data['nombre'].' '.$data['apellido'], 'codigo' => 311020001]);
        $this->assertDatabaseHas('saldos_cuentas', ['saldo' => 0, 'codigo' => 311020001, 'nombre' => 'Comisiones a pagar '.$data['nombre'].' '.$data['apellido']]);
        $this->assertDatabaseHas('users', $user);
        $this->assertDatabaseHas('role_users', ['user_id' => 2, 'role_id' => 2]);
        $this->assertDatabaseHas('comercializadores', $data);
    }

    public function testUpdateComercializador()
    {

        $data = $this->data();
        $data2 = $this->data();
        $response = $this->post('abm_comercializador', $data);
        $col = collect();
        $col->put('usuario', $data2['usuario']);
        $col->put('email', $data2['email']);
        $data2['id'] = 1;

        $response = $this->put('abm_comercializador/1', $data2);
        $data2['usuario'] = 1;
        unset($data2['password']);
        $this->assertDatabaseHas('comercializadores', $data2);
        $this->assertDatabaseHas('users', $col->toArray());
    }
}
