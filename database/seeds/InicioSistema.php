<?php

use App\ProveedorImputacionDeudores;
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
            $mock = Mockery::mock('overload:App\Repositories\Eloquent\ControlFechaContable');
            $fecha = \Carbon\Carbon::today();
            $mock->shouldReceive('getFechaContable')->andReturn($fecha);
            $ejercicio = factory(\App\Ejercicio::class)->create();

            $proveedores = \App\Proovedores::all();

            // Capitulos
            $capituloResultado = factory(\App\Capitulo::class)->create(['nombre' => 'Resultado', 'codigo' => 5]);
            $capituloActivo = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $capituloPasivo = factory(\App\Capitulo::class)->create(['nombre' => 'Pasivo', 'codigo' => 3]);


            // Rubro
            $rubroCajaYBanco = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloActivo->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $rubroCreditos = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloActivo->id, 'nombre' => 'Creditos', 'codigo' => 13]);
            $rubroDeudas = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloPasivo->id, 'nombre' => 'Deudas', 'codigo' => 31]);
            $rubroRecursos = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloResultado->id, 'nombre' => 'Recursos', 'codigo' => 51]);


            // Moneda
            $monedaCYBPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCajaYBanco->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $monedaCreditoEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCreditos->id, 'nombre' => 'Creditos en pesos', 'codigo' => 131]);
            $monedaDeudaEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroDeudas->id, 'nombre' => 'Deudas en pesos', 'codigo' => 311]);
            $monedaRecursosEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroRecursos->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);

            // Departamento
            $departamentoGeralCajaBanco = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCYBPesos->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $departamentoCreditoGeneral = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCreditoEnPesos->id, 'nombre' => 'Creditos Dpto. General', 'codigo' => 13101]);
            $departamentoDeudasServicio = factory(\App\Departamento::class)->create(['id_moneda' => $monedaDeudaEnPesos->id, 'nombre' => 'Deudas Dpto servicio', 'codigo' => 31103]);
            $departamento3 = factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Recursos Dpto general', 'codigo' => 51101, 'afecta_codigo_base' => null,]);
            $dptoGeneral= factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Dpto general', 'codigo' => 51103]);

            // SubRubro
            $subRubro5 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Caja Dpto general', 'codigo' => 1110101, 'afecta_codigo_base' => null,]);
            $subRubro4 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Banco Dpto general', 'codigo' => 1110102]);
            $subRubroCreditos = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoCreditoGeneral->id, 'nombre' => 'Creditos', 'codigo' => 1310100]);
            $subRubroCredi = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoDeudasServicio->id, 'nombre' => 'Creditos', 'codigo' => 3110300]);
            $subRubro3 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento3->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110101, 'afecta_codigo_base' => null,
            ]);
            $subRubroRecursosEspecificos = factory(\App\SubRubro::class)->create(['id_departamento' => $dptoGeneral->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110301]);

            // Imputaciones
            $imputacion2 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Cuenta puente cobro', 'codigo' => 111010102]);
            $imputacion3 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Cuotas sociales', 'codigo' => 511010101]);
            $imputacion4 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro4->id, 'nombre' => 'Banco xxx', 'codigo' => 111010201]);
            $imputacion5 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Caja - Efectivo', 'codigo' => 111010101]);

            // Saldos
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion2->id, 'codigo' => $imputacion2->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion3->id, 'codigo' => $imputacion3->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion4->id, 'codigo' => $imputacion4->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion5->id, 'codigo' => $imputacion5->codigo]);

            //config cuentas

            \App\ConfigImputaciones::create(['nombre' => 'Deudores XXXX', 'codigo_base' => '1310100']);
            \App\ConfigImputaciones::create(['nombre' => 'Cta XXXX', 'codigo_base' => '3110300']);
            \App\ConfigImputaciones::create(['nombre' => 'Comisiones XXXX', 'codigo_base' => '5110301']);
            \App\ConfigImputaciones::create(['nombre' => 'Banco XXXX', 'codigo_base' => '1110102']);

            if($proveedores->isNotEmpty()){

                $primerProveedor = $proveedores->splice(1, 1);
                $primerProveedor = $primerProveedor->first();

                $imputacion = GeneradorDeCuentas::generar('Deudores ' . $primerProveedor->razon_social, '131010001');
                ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);
                $imputacion = GeneradorDeCuentas::generar('Cta ' . $primerProveedor->razon_social, '311030001');
                ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Cta', 'codigo' => $imputacion->codigo]);

                $imputacion = GeneradorDeCuentas::generar('Comisiones ' . $primerProveedor->razon_social, '511030101');
                ProveedorImputacionDeudores::create(['id_proveedor' => $primerProveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Comisiones', 'codigo' => $imputacion->codigo]);

                $proveedores->each(function ($proveedor) {
                    $codigo = ImputacionGateway::obtenerCodigoNuevo('1310100');
                    $imputacion = GeneradorDeCuentas::generar('Deudores ' . $proveedor->razon_social, $codigo);
                    ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Deudores', 'codigo' => $imputacion->codigo]);

                    $codigo = ImputacionGateway::obtenerCodigoNuevo('3110300');
                    $imputacion = GeneradorDeCuentas::generar('Cta ' . $proveedor->razon_social, $codigo);
                    ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Cta', 'codigo' => $imputacion->codigo]);

                    $codigo = ImputacionGateway::obtenerCodigoNuevo('5110301');
                    $imputacion = GeneradorDeCuentas::generar('Comisiones ' . $proveedor->razon_social, $codigo);
                    ProveedorImputacionDeudores::create(['id_proveedor' => $proveedor->id, 'id_imputacion' => $imputacion->id, 'tipo' => 'Comisiones', 'codigo' => $imputacion->codigo]);

                });
            }
            // Asiento de inicio
            $asiento = factory(\App\Asiento::class)->create(['id_ejercicio' => $ejercicio->id, 'id_imputacion' => $imputacion2]);

            $user = Sentinel::registerAndActivate(array('usuario'=>'200', 'email'=>'1', 'password'=> '200'));
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'genio',
                'slug' => 'genio',
            ]);
            $role2 = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'ignorante',
                'slug' => 'ignorante',
            ]);
            $pantallas = DB::table('pantallas')->pluck('nombre');
            $permisos = collect([]);
            foreach ($pantallas as $pantalla) {
                $permisos->put($pantalla . '.crear', true);
                $permisos->put($pantalla . '.visualizar', true);
                $permisos->put($pantalla . '.borrar', true);
                $permisos->put($pantalla . '.editar', true);
                
            }
            $role->permissions = $permisos->toArray();
            $role2->permissions = [];
            $role->save();
            $role2->save();
            $role->users()->attach($user);

            $this->call(PrioridadesSeed::class);
        });
    }
}
