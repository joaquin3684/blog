<?php

namespace Tests\Unit;

use App\Proovedores;
use App\Services\ABM_ComercializadorService;
use App\Services\ABM_ProveedorService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class ABM_ProveedorTest extends TestCase
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
            'descripcion' => $f->name,
            'id_prioridad' => 2,
            'usuario' => 1,
            'razon_social' => "pepe",
            'cuit' => $f->randomNumber(8),
            'domicilio' => $f->address,
            'telefono' => $f->phoneNumber,
            'piso' => $f->randomNumber(1),
            'departamento' => $f->name,
            'nucleo' => $f->address,
            'usuario' => 'prueba',
            'email' => $f->email,
            'password' => 'prueba'
        ];

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaProveedor()
    {
        $data = collect($this->data());
        $service = new ABM_ProveedorService();
        $user = ['usuario' => $data['usuario'], 'email' => $data['email']];
        $service->crearProveedor($data);



        $data['usuario'] = 2;
        unset($data['password']);
        unset($data['email']);
        $this->assertDatabaseHas('imputaciones', ['nombre' => 'Cta '.$data['razon_social'], 'codigo' => 311030001]);
        $this->assertDatabaseHas('saldos_cuentas', ['saldo' => 0, 'codigo' => 311030001, 'nombre' => 'Cta '.$data['razon_social']]);
        $this->assertDatabaseHas('users', $user);
        $this->assertDatabaseHas('role_users', ['user_id' => 2, 'role_id' => 3]);
        $this->assertDatabaseHas('proovedores', $data->toArray());
    }

    public function testModel()
    {
        $data = $this->data();

        unset($data['password']);
        unset($data['email']);
        $proveedor = new Proovedores($data);
        $val = $proveedor->p();
        $this->assertEquals($val, "pepe");
    }
}
