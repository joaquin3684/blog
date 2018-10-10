<?php

namespace Tests\Unit;

use App\Services\VentasService;
use Carbon\Carbon;
use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory;

class VentasServiceTest extends TestCase
{
    use DatabaseMigrations;

    public $factory;
    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistema');
        $this->seed('InicioSistemaSoloAbms');
    }

    public function data()
    {
        $f = Factory::create('App\Capitulo');
        return [
            'id_asociado' => 1,
            'id_producto' => 1,
            'descripcion' => "asldkfj",
            'nro_cuotas' => 3,
            'importe_total' => 1500,
            'importe_cuota' => 500,
            'importe_otorgado' => 1000,

            'fecha_vencimiento' => Carbon::today()->addMonths(3)->toDateString()

        ];

    }


    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAltaServicio()
    {
        $data = $this->data();
        $service = new VentasService();
        $service->crearVenta($data);

        $fechaVencimiento = Carbon::createFromFormat('Y-m-d', $data['fecha_vencimiento'])->subMonth(1);
        $fechaInicio = Carbon::createFromFormat('Y-m-d', $data['fecha_vencimiento'])->subMonths(3);
        for($i=1; $i <= $data['nro_cuotas']; $i++){
            $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => $data['importe_cuota'], 'nro_cuota' => $i, 'fecha_vencimiento' => $fechaVencimiento->toDateString(), 'fecha_inicio' => $fechaInicio->toDateString()]);

            $aux = Carbon::create($fechaVencimiento->year, $fechaVencimiento->month, $fechaVencimiento->day);
            $fechaInicio->addMonth();
            $fechaVencimiento->addMonth();
        }




        $asientoDebe = [
            'id_imputacion' => 6,
            'nombre' => "Comisiones a cobrar",
            'codigo' => 131010002,
            'haber' => 0,
            'id_ejercicio' => 1,
            'fecha_contable' => Carbon::today()->toDateString(),
            'fecha_valor' => Carbon::today()->toDateString(),
            'nro_asiento' => 2
        ];
        $asientoHaber = [
            'id_imputacion' => 8,
            'nombre' => "Comisiones a devengar (Reg A)",
            'codigo' => 131020402,
            'debe' => 0,
            'id_ejercicio' => 1,
            'fecha_contable' => Carbon::today()->toDateString(),
            'fecha_valor' => Carbon::today()->toDateString(),
            'nro_asiento' => 3
        ];
        $saldoD = [
            'codigo' => 131010002,
            'id_imputacion' => 6,
            'year' =>Carbon::today()->year,
            'month' => Carbon::today()->month
        ];
        $saldoH = [
            'codigo' => 131020402,
            'id_imputacion' => 8,
            'year' =>Carbon::today()->year,
            'month' => Carbon::today()->month
        ];



        $this->assertDatabaseHas('ventas', $data);
        $this->assertDatabaseHas('asientos', $asientoDebe);
        $this->assertDatabaseHas('asientos', $asientoHaber);
        $this->assertDatabaseHas('saldos_cuentas', $saldoD);
        $this->assertDatabaseHas('saldos_cuentas', $saldoH);
    }

    public function testCobrarPorVenta()
    {
        $this->seed('VentasParaPagarProveedorSeed');

        $service = new VentasService();
        $elem = [['id' => 1, 'monto' => 250], ['id' => 2, 'monto' => 500]];
        $service->cobrar($elem);

        $fecha = Carbon::today()->toDateString();

        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 1, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 6, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 7, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 2]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 3]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 2]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 3]);


        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 250]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 9,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 10,  'haber' => 175, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 6,  'haber' => 25, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 50, 'id_ejercicio' => 1, 'debe' => 0]);

        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 500]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 9,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 10,  'haber' => 350, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 6,  'haber' => 50, 'id_ejercicio' => 1, 'debe' => 0]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 100, 'id_ejercicio' => 1, 'debe' => 0]);

        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 111010201, 'id_imputacion' => 3, 'year' =>Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 750]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 521020218, 'id_imputacion' => 9, 'year' =>Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 0]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 131010003, 'id_imputacion' => 10, 'year' =>Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -525]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 131010002, 'id_imputacion' => 6, 'year' =>Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -75]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 311020001, 'id_imputacion' => 11, 'year' =>Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -150]);
    }
}
