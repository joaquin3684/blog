<?php

use App\Repositories\Eloquent\Contabilidad\GeneradorDeCuentas;
use App\Repositories\Eloquent\Repos\Gateway\ImputacionGateway;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicioSistema extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){
            $ejercicio = factory(\App\Ejercicio::class)->create();

            $proveedores = \App\Proovedores::all();
            $proveedores->each(function($proveedor){
                $codigo = ImputacionGateway::obtenerCodigoNuevo('1310100');
                GeneradorDeCuentas::generar('Deudores '.$proveedor->razon_social, $codigo);
                $codigo = ImputacionGateway::obtenerCodigoNuevo('3110300');
                GeneradorDeCuentas::generar('Cta '.$proveedor->razon_social, $codigo);
                $codigo = ImputacionGateway::obtenerCodigoNuevo('5110301');
                GeneradorDeCuentas::generar('Comisiones '.$proveedor->razon_social, $codigo);
            });




            // Cuenta De Cuotas Sociales
            $capitulo3 = factory(\App\Capitulo::class)->create(['nombre' => 'Resultado', 'codigo' => 5]);
            $rubro3 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo3->id, 'nombre' => 'Recursos', 'codigo' => 51]);
            $moneda3 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro3->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);
            $departamento3 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda3->id, 'nombre' => 'Recursos Dpto general', 'codigo' => 51101]);
            $subRubro3 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento3->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110101]);
            $imputacion3 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Cuotas sociales', 'codigo' => 511010101]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion3->id, 'codigo' => $imputacion3->codigo]);

            // Cuenta Bancos
            $capitulo4 = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $rubro4 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo4->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $moneda4 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro4->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $departamento4 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda4->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $subRubro4 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento4->id, 'nombre' => 'Banco Dpto general', 'codigo' => 1110102]);
            $imputacion4 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro4->id, 'nombre' => 'Banco xxx', 'codigo' => 111010201]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion4->id, 'codigo' => $imputacion4->codigo]);

            // Cuenta Caja
            $capitulo5 = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $rubro5 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo5->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $moneda5 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro5->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $departamento5 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda5->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $subRubro5 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento5->id, 'nombre' => 'Caja Dpto general', 'codigo' => 1110101]);
            $imputacion5 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Caja - Efectivo', 'codigo' => 111010101]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion5->id, 'codigo' => $imputacion5->codigo]);

            // Asiento de inicio
            $asiento = factory(\App\Asiento::class)->create(['id_ejercicio' => $ejercicio->id]);

            $user = Sentinel::registerAndActivate(array('usuario'=>'200', 'email'=>'1', 'password'=> '200'));
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'genio',
                'slug' => 'genio',
            ]);
            $role->permissions = ['organismos.crear' => true, 'organismos.visualizar' => true, 'organismos.editar' => true, 'organismos.borrar'=> true, 'socios.editar' => true, 'socios.visualizar' => true, 'socios.crear' => true, 'socios.borrar' => true];
            $role->save();
            $role->users()->attach($user);

            $this->call(PrioridadesSeed::class);
            //TODO:: los rubros y eso estan mal estory repitiendo la creacion de capitulos y rubros y etc
        });
    }
}
