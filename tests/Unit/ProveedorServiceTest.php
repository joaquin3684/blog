<?php

namespace Tests\Unit;

use App\Asiento;
use App\Services\ProveedorService;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProveedorServiceTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistema');
        $this->seed('InicioSistemaSoloAbms');
        $this->seed('VentasParaPagarProveedorSeed');

    }
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testPagarProveedores()
    {
        $service = new ProveedorService();

        $service->pagar();
            $asientos = Asiento::all();
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 11, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'salida' => 250]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 12, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'salida' => 250]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 13, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'salida' => 250]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 14, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'salida' => 250]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 15, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'salida' => 250]);

        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 250]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 18,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 875]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 1125, 'id_ejercicio' => 1, 'debe' => 0]);

        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 311020001, 'id_imputacion' => 11, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 250]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 311020003, 'id_imputacion' => 18, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 875]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 111010201, 'id_imputacion' => 3, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -1125]);

    }
}
