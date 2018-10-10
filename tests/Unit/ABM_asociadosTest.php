<?php

namespace Tests\Unit;

use App\Cuotas;
use App\Services\ABM_SociosService;
use App\Socios;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ABM_asociadosTest extends TestCase
{

    use DatabaseMigrations;

    public function data()
    {
        return [
            'nombre' => 'juan',
            'fecha_nacimiento' => '2017-02-08',
            'cuit' => '20-12345678-20',
            'dni' => 39624527,
            'domicilio' => 'alskdjfaslkdj',
            'localidad' => 'lkfdjsalñksjd',
            'codigo_postal' => '65465',
            'telefono' => '654165df',
            'id_organismo' => 1,
            'legajo' => 1,
            'fecha_ingreso' => '2017-02-08',
            'sexo' => '21',
            'valor' => 100,
            'piso' => null,
            'departamento' => null,
            'nucleo' => null

        ];
    }
    public function setUp()
    {
        parent::setUp();
        $this->seed('InicioSistemaCompleto');

    }
    public function testStore()
    {

        $data = $this->data();

        $servicio = new ABM_SociosService();
        $servicio->crearSocio($data);

        $fechaInicioCuota = Carbon::today()->toDateString();
        $fechaVencimientoCuota = Carbon::today()->addMonths(2);

        $cuota = [
            'fecha_inicio' => $fechaInicioCuota,
            'fecha_vencimiento' => $fechaVencimientoCuota,
            'importe' => $data['valor'],
            'nro_cuota' => 1,
        ];
        $asientoDebe = [
            'id_imputacion' => 5,
            'nombre' => "Cuota Social a cobrar",
            'codigo' => 131030101,
            'debe' => $data['valor'],
            'haber' => 0,
            'id_ejercicio' => 1,
            'fecha_contable' => $fechaInicioCuota,
            'fecha_valor' => $fechaInicioCuota,
            'nro_asiento' => 2
        ];
        $asientoHaber = [
            'id_imputacion' => 7,
            'nombre' => "Cuota Social a devengar",
            'codigo' => 131030201,
            'debe' => 0,
            'haber' => $data['valor'],
            'id_ejercicio' => 1,
            'fecha_contable' => $fechaInicioCuota,
            'fecha_valor' => $fechaInicioCuota,
            'nro_asiento' => 3
        ];
        $saldoD = [
            'codigo' => 131030101,
            'id_imputacion' => 5,
            'saldo' => $data['valor'],
            'year' =>Carbon::today()->year,
            'month' => Carbon::today()->month
        ];
        $saldoH = [
            'codigo' => 131030201,
            'id_imputacion' => 7,
            'saldo' => -$data['valor'],
            'year' =>Carbon::today()->year,
            'month' => Carbon::today()->month
        ];
        $this->assertDatabaseHas('socios', $data);
        $this->assertDatabaseHas('cuotas', $cuota);
        $this->assertDatabaseHas('asientos', $asientoDebe);
        $this->assertDatabaseHas('asientos', $asientoHaber);
        $this->assertDatabaseHas('saldos_cuentas', $saldoD);
        $this->assertDatabaseHas('saldos_cuentas', $saldoH);

    }

    public function testCobrar()
    {
        $data = [['id' => 1, 'monto' => 600], ['id' => 2, 'monto' => 350]];
        $servicio = new ABM_SociosService();

        $servicio->cobrar($data);
        $fecha = Carbon::today()->toDateString();

        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 1, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 2, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 6, 'identificadores_type' => 'App\Cuotas', 'entrada' => 100, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 11, 'identificadores_type' => 'App\Cuotas', 'entrada' => 250, 'fecha' => $fecha]);
        $this->assertDatabaseHas('movimientos', ['identificadores_id' => 12, 'identificadores_type' => 'App\Cuotas', 'entrada' => 100, 'fecha' => $fecha]);


        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 2]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 1, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 3]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Parcial', 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 2]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 2, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => null, 'nro_cuota' => 3]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 3, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Total', 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['cuotable_id' => 3, 'cuotable_type' => 'App\Ventas', 'importe' => 250, 'estado' => 'Cobro Parcial', 'nro_cuota' => 2]);


        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 500, 'nro_asiento' => 2]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 9,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 3]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 10,  'haber' => 350, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 4]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 6,  'haber' => 50, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 5]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 100, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 6]);

        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 100, 'nro_asiento' => 7]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 9,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 8]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 10,  'haber' => 70, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 9]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 6,  'haber' => 10, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 10]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 20, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 11]);

        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 3,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 350, 'nro_asiento' => 12]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 9,  'haber' => 0, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 13]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 10,  'haber' => 245, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 14]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 6,  'haber' => 35, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 15]);
        $this->assertDatabaseHas('asientos',  ['id_imputacion' => 11,  'haber' => 70, 'id_ejercicio' => 1, 'debe' => 0, 'nro_asiento' => 16]);

        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 111010201, 'id_imputacion' => 3, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 950]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 521020218, 'id_imputacion' => 9, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => 0]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 131010003, 'id_imputacion' => 10, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -665]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 131010002, 'id_imputacion' => 6, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -95]);
        $this->assertDatabaseHas('saldos_cuentas', ['codigo' => 311020001, 'id_imputacion' => 11, 'year' => Carbon::today()->year,'month' => Carbon::today()->month, 'saldo' => -190]);    }
}
