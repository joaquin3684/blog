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
            $rubroGastos = factory(\App\Rubro::class)->create(['id_capitulo' => $capituloResultado->id, 'nombre' => 'Gastos', 'codigo' => 52]);


            // Moneda
            $monedaCYBPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCajaYBanco->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $monedaCreditoEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroCreditos->id, 'nombre' => 'Creditos en pesos', 'codigo' => 131]);
            $monedaDeudaEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroDeudas->id, 'nombre' => 'Deudas en pesos', 'codigo' => 311]);
            $monedaRecursosEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroRecursos->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);
            $monedaGastosEnPesos = factory(\App\Moneda::class)->create(['id_rubro' => $rubroGastos->id, 'nombre' => 'Gastos en pesos', 'codigo' => 521]);

            // Departamento
            $departamentoGeralCajaBanco = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCYBPesos->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $departamentoCreditoGeneral = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCreditoEnPesos->id, 'nombre' => 'Creditos Dpto. General', 'codigo' => 13101]);
            $departamentoAyudaEconomica = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCreditoEnPesos->id, 'nombre' => 'Creditos Dpto. ayuda economica', 'codigo' => 13102]);
            $departamentoCreditosYServicios = factory(\App\Departamento::class)->create(['id_moneda' => $monedaCreditoEnPesos->id, 'nombre' => 'Creditos servicios', 'codigo' => 13103]);
            $departamentoDeudasServicio = factory(\App\Departamento::class)->create(['id_moneda' => $monedaDeudaEnPesos->id, 'nombre' => 'Deudas Dpto servicio', 'codigo' => 31103]);
            $departamentoDeudasAyudaEconomica = factory(\App\Departamento::class)->create(['id_moneda' => $monedaDeudaEnPesos->id, 'nombre' => 'Deudas Dpto ayuda economica', 'codigo' => 31102]);
            $departamento3 = factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Recursos Dpto general', 'codigo' => 51101, 'afecta_codigo_base' => null,]);
            $dptoGeneral= factory(\App\Departamento::class)->create(['id_moneda' => $monedaRecursosEnPesos->id, 'nombre' => 'Dpto general', 'codigo' => 51103]);
            $dptoAyudaEconomica= factory(\App\Departamento::class)->create(['id_moneda' => $monedaGastosEnPesos->id, 'nombre' => 'Dpto ayuda economica', 'codigo' => 52102]);

            // SubRubro
            $subRubro5 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Caja Dpto general', 'codigo' => 1110101, 'afecta_codigo_base' => null,]);
            $subRubro4 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoGeralCajaBanco->id, 'nombre' => 'Banco Dpto general', 'codigo' => 1110102]);
            $subRubroCreditos = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoCreditoGeneral->id, 'nombre' => 'Creditos', 'codigo' => 1310100]);
            $subRubroRegularizadora = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoAyudaEconomica->id, 'nombre' => 'Regularizadora de ayudas economicas', 'codigo' => 1310204]);
            $subRubroCreditosCuotaSocial = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoCreditosYServicios->id, 'nombre' => 'Creditos servicio cuota social', 'codigo' => 1310301]);
            $subRubroCreditosCuotaSocialDevengamiento = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoCreditosYServicios->id, 'nombre' => 'Creditos servicio cuota social devengar', 'codigo' => 1310302]);
            $subRubroCredi = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoDeudasServicio->id, 'nombre' => 'Creditos', 'codigo' => 3110300]);
            $subRubroDeudasAyudaEconomica = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoDeudasAyudaEconomica->id, 'nombre' => 'Deudas sub rubro ayuda economica', 'codigo' => 3110200]);
            $subRubroRegularizadoraDeAhorro = factory(\App\SubRubro::class)->create(['id_departamento' => $departamentoDeudasAyudaEconomica->id, 'nombre' => 'Regularizadora', 'codigo' => 3110204]);
            $subRubro3 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento3->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110101, 'afecta_codigo_base' => null,
            ]);
            $subRubroRecursosEspecificos = factory(\App\SubRubro::class)->create(['id_departamento' => $dptoGeneral->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110301]);
            $subRubroGastosAdministrativos = factory(\App\SubRubro::class)->create(['id_departamento' => $dptoAyudaEconomica->id, 'nombre' => 'Gastos administrativos', 'codigo' => 5210202]);

            // Imputaciones
            $imputacion1 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Cuenta puente cobro', 'codigo' => 111010102]);
            $imputacion2 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Cuotas sociales', 'codigo' => 511010101]);
            $imputacion3 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro4->id, 'nombre' => 'Banco xxx', 'codigo' => 111010201]);
            $imputacion4 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Caja - Efectivo', 'codigo' => 111010101]);
            $imputacion5 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditosCuotaSocial->id, 'nombre' => 'Cuota Social a cobrar', 'codigo' => 131030101]);
            $imputacion6 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditos->id, 'nombre' => 'Comisiones a cobrar', 'codigo' => 131010002]);
            $imputacion7 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditosCuotaSocialDevengamiento->id, 'nombre' => 'Cuota Social a devengar', 'codigo' => 131030201]);
            $imputacion8 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroRegularizadora->id, 'nombre' => 'Comisiones a devengar (Reg A)', 'codigo' => 131020402]);
            $imputacion9 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroGastosAdministrativos->id, 'nombre' => 'Comisiones pagadas (R-)', 'codigo' => 521020218]);
            $imputacion10 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditos->id, 'nombre' => 'Fondo de terceros a pagar', 'codigo' => 131010003]);
            $imputacion11 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroDeudasAyudaEconomica->id, 'nombre' => 'Intereses a pagar (proveedor)', 'codigo' => 311020001]);
            $imputacion12 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroDeudasAyudaEconomica->id, 'nombre' => 'Comisiones a pagar (comer)', 'codigo' => 311020002]);
            $imputacion13 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditos->id, 'nombre' => 'Prestamos a cobrar', 'codigo' => 131010001]);
            $imputacion14 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroCreditos->id, 'nombre' => 'Intereses a cobrar', 'codigo' => 131010004]);
            $imputacion15 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Intereses ganados', 'codigo' => 511010104]);
            $imputacion16 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroRegularizadora->id, 'nombre' => 'Intereses a devengar', 'codigo' => 131020403]);
            $imputacion17 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Comisiones ganadas', 'codigo' => 511010103]);
            $imputacion18 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroDeudasAyudaEconomica->id, 'nombre' => 'Fondos de terceros a pagar (P-)', 'codigo' => 311020003]);
            $imputacion19 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubroRegularizadoraDeAhorro->id, 'nombre' => 'Comisiones a devengar (Reg P)', 'codigo' => 311020401]);

            // Saldos
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion1->id, 'codigo' => $imputacion1->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion2->id, 'codigo' => $imputacion2->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion3->id, 'codigo' => $imputacion3->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion4->id, 'codigo' => $imputacion4->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion5->id, 'codigo' => $imputacion5->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion6->id, 'codigo' => $imputacion6->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion7->id, 'codigo' => $imputacion7->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion8->id, 'codigo' => $imputacion8->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion9->id, 'codigo' => $imputacion9->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion10->id, 'codigo' => $imputacion10->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion11->id, 'codigo' => $imputacion11->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion12->id, 'codigo' => $imputacion12->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion13->id, 'codigo' => $imputacion13->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion14->id, 'codigo' => $imputacion14->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion15->id, 'codigo' => $imputacion15->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion16->id, 'codigo' => $imputacion16->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion17->id, 'codigo' => $imputacion17->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion18->id, 'codigo' => $imputacion18->codigo]);
            $saldoCuenta = factory(\App\SaldosCuentas::class)->create(['id_imputacion' => $imputacion19->id, 'codigo' => $imputacion19->codigo]);



            // Asiento de inicio
            $asiento = factory(\App\Asiento::class)->create(['id_ejercicio' => $ejercicio->id, 'id_imputacion' => $imputacion2]);

            $user = Sentinel::registerAndActivate(array('usuario'=>'200', 'email'=>'1', 'password'=> '200'));
            $role = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'genio',
                'slug' => 'genio',
            ]);
            $role1 = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'comercializador',
                'slug' => 'comercializador',
            ]);
            $role2 = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'proveedor',
                'slug' => 'proveedor',
            ]);
            $role3 = Sentinel::getRoleRepository()->createModel()->create([
                'name' => 'ignorante',
                'slug' => 'ignorante',
            ]);
            $this->call(PantallasSeed::class);

            $pantallas = \App\Pantallas::all();
            $permisos = collect();
            $a = [];
            foreach ($pantallas as $pantalla) {
                $p = $pantalla->nombre;
                $a[$pantalla->nombre . '.crear'] = true;
                $a[$pantalla->nombre . '.visualizar'] = true;
                $a[$pantalla->nombre . '.borrar'] = true;
                $a[$pantalla->nombre . '.editar'] = true;

                
            }
            $role = Sentinel::findRoleById(1);

            $role->permissions = $a;
            $role2->permissions = ['agentesFinancieros.crear' => true,'agentesFinancieros.visualizar' => true,'agentesFinancieros.borrar' => true,'agentesFinancieros.editar' => true, 'CCProveedor.crear' => true,'CCProveedor.visualizar' => true,'CCProveedor.borrar' => true,'CCProveedor.editar' => true];
            $role1->permissions = ['comercializador.crear' => true,'comercializador.visualizar' => true,'comercializador.borrar' => true,'comercializador.editar' => true, 'solicitudesPendientesDeCobro.crear' => true,'solicitudesPendientesDeCobro.visualizar' => true,'solicitudesPendientesDeCobro.borrar' => true,'solicitudesPendientesDeCobro.editar' => true];
            $role->save();
            $role1->save();
            $role2->save();
            $role3->save();
            $role->users()->attach($user);

            $this->call(PrioridadesSeed::class);
        });
    }
}
