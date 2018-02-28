<?php

namespace Tests\Unit;

use App\Imputacion;
use App\Repositories\Eloquent\Generadores\GeneradorCuotas;
use App\Repositories\Eloquent\Repos\CuotasRepo;
use App\Repositories\Eloquent\Repos\EstadoVentaRepo;
use App\Repositories\Eloquent\Repos\Mapper\VentasMapper;
use App\Repositories\Eloquent\Repos\VentasRepo;
use App\Ventas;
use Carbon\Carbon;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;




class AprobarServicioTest extends TestCase
{
    use DatabaseMigrations;

    private $organismo;
    private $socio;
    private $proveedor;
    private $proveedor2;
    private $producto;
    private $venta;
    private $usuario;
    public function setUp()
    {
        parent::setUp();
        $this->seed('PrioridadesSeed');
        $this->usuario = Sentinel::registerAndActivate([
            'usuario' => 123,
            'password' => 1,
            'email' => 1233
        ]);
        $this->organismo = factory(\App\Organismos::class)->create();
        $this->socio = factory(\App\Socios::class)->create(['id_organismo' => $this->organismo->id]);
        $this->proveedor = factory(\App\Proovedores::class)->create();
        $this->proveedor2 = factory(\App\Proovedores::class)->create();
        $this->producto = factory(\App\Productos::class)->create(['id_proovedor' => $this->proveedor2->id]);
        $this->venta = Ventas::create([ 'id_asociado' => $this->socio->id,
            'id_producto' => $this->producto->id,
            'nro_cuotas' => 5,
            'importe' => '500',
            'fecha_vencimiento' => Carbon::today()->addMonths(2)->toDateString()]);
        $this->seed('InicioSistema');

    }


    public function getData()
    {
        return collect([
            'id_asociado' => 1,
            'id_producto' => 5,
            'nro_cuotas' => 5,
            'total' => '500',
            'fecha_vencimiento' => Carbon::today()->addMonths(2)->toDateString(),
        ]);
    }

    public function newData()
    {
        return collect([[
            'id' => 1,
            'estado' => 'APROBADO'
        ]]);
    }




    public function testAprobarServicio()
    {

        $data = $this->newData()->toArray();
        $us = Sentinel::authenticateAndRemember(['usuario' => 123, 'password' => 1]);
        $response = $this->post('aprobacion/aprobar', $data);
        $this->assertDatabaseHas('estado_ventas', ['id_venta' => $this->venta->id, 'estado' => 'APROBADO', 'id_responsable_estado' => $this->usuario->id ]);
        $fechaVencimiento = Carbon::createFromFormat('Y-m-d', $this->venta->fecha_vencimiento);
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $this->venta->fecha_vencimiento)->subMonths(2);
        for($i=1; $i <= $this->venta->nro_cuotas; $i++){
            $this->assertDatabaseHas('cuotas', ['cuotable_id' => $this->venta->id, 'cuotable_type' => 'App\Ventas', 'importe' => $this->venta->importe/$this->venta->nro_cuotas, 'nro_cuota' => $i, 'fecha_vencimiento' => $fechaVencimiento->toDateString(), 'fecha_inicio' => $fechaInicio->toDateString()]);

            $aux = Carbon::create($fechaVencimiento->year, $fechaVencimiento->month, $fechaVencimiento->day);
            $fechaInicio = $aux->addDay();
            $fechaVencimiento->addMonth();
        }

        $imputacionDebe = Imputacion::where('nombre', 'Deudores '.$this->proveedor2->razon_social)->first();
        $imputacionHaber = Imputacion::where('nombre', 'Cta '.$this->proveedor2->razon_social)->first();

        $this->assertDatabaseHas('asientos', ['id_imputacion' => $imputacionDebe->id,
                                'debe' => $this->venta->importe,
                                'haber' => 0,
                                'codigo' => $imputacionDebe->codigo,
                                'nombre' => $imputacionDebe->nombre,
                                'nro_asiento' => 2,
                                'id_ejercicio' => 1,
                                'fecha_contable' => Carbon::today()->toDateString(),
                                'fecha_valor' => Carbon::today()->toDateString()
        ]);
        $this->assertDatabaseHas('asientos', ['id_imputacion' => $imputacionHaber->id,
                                'debe' => 0,
                                'haber' => $this->venta->importe,
                                'codigo' => $imputacionHaber->codigo,
                                'nombre' => $imputacionHaber->nombre,
                                'nro_asiento' => 3,
                                'id_ejercicio' => 1,
                                'fecha_contable' => Carbon::today()->toDateString(),
                                'fecha_valor' => Carbon::today()->toDateString()
        ]);
    }

        public function testRechazarServicio()
        {
            $data =  collect([[
                'id' => 1,
                'estado' => 'RECHAZADO'
            ]]);
            $us = Sentinel::authenticateAndRemember(['usuario' => 123, 'password' => 1]);
            $response = $this->post('aprobacion/aprobar', $data->toArray());
            $this->assertDatabaseHas('estado_ventas', ['id_venta' => $this->venta->id, 'estado' => 'RECHAZADO', 'id_responsable_estado' => $this->usuario->id ]);
            $this->assertDatabaseHas('ventas', ['id' => $this->venta->id, 'deleted_at' => Carbon::now()->toDateTimeString()]);
        }

}
