<?php

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

            // Cuenta de deudores
            $capitulo = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $rubro = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo->id, 'nombre' => 'Creditos', 'codigo' => 31]);
            $moneda = factory(\App\Moneda::class)->create(['id_rubro' => $rubro->id, 'nombre' => 'Creditos en pesos', 'codigo' => 311]);
            $departamento = factory(\App\Departamento::class)->create(['id_moneda' => $moneda->id, 'nombre' => 'Creditos Dpto. General', 'codigo' => 31101]);
            $subRubro = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento->id, 'nombre' => 'Creditos', 'codigo' => 3110100]);
            $imputacion = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro->id, 'nombre' => 'Deudores XXX', 'codigo' => 311010001]);

            // Cuenta de proveedores
            $capitulo2 = factory(\App\Capitulo::class)->create(['nombre' => 'Pasivo', 'codigo' => 3]);
            $rubro2 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo2->id, 'nombre' => 'Deudas', 'codigo' => 31]);
            $moneda2 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro2->id, 'nombre' => 'Deudas en pesos', 'codigo' => 311]);
            $departamento2 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda2->id, 'nombre' => 'Deudas Dpto servicio', 'codigo' => 31103]);
            $subRubro2 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento2->id, 'nombre' => 'Creditos', 'codigo' => 3110300]);
            $imputacion2 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro2->id, 'nombre' => 'Cta', 'codigo' => 311030001]);

            // Cuenta De Cuotas SOciales
            $capitulo3 = factory(\App\Capitulo::class)->create(['nombre' => 'Resultado', 'codigo' => 5]);
            $rubro3 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo3->id, 'nombre' => 'Recursos', 'codigo' => 51]);
            $moneda3 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro3->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);
            $departamento3 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda3->id, 'nombre' => 'Recursos Dpto general', 'codigo' => 51101]);
            $subRubro3 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento3->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110101]);
            $imputacion3 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro3->id, 'nombre' => 'Cuotas sociales', 'codigo' => 511010101]);

            // Cuenta Bancos
            $capitulo4 = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $rubro4 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo4->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $moneda4 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro4->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $departamento4 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda4->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $subRubro4 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento4->id, 'nombre' => 'Banco Dpto general', 'codigo' => 1110102]);
            $imputacion4 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro4->id, 'nombre' => 'Banco xxx', 'codigo' => 111010201]);

            // Cuenta Caja
            $capitulo5 = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 1]);
            $rubro5 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo5->id, 'nombre' => 'Caja y bancos', 'codigo' => 11]);
            $moneda5 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro5->id, 'nombre' => 'Caja y bancos en pesos', 'codigo' => 111]);
            $departamento5 = factory(\App\Departamento::class)->create(['id_moneda' => $moneda5->id, 'nombre' => 'Caja y bancos Dpto general', 'codigo' => 11101]);
            $subRubro5 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento5->id, 'nombre' => 'Caja Dpto general', 'codigo' => 1110101]);
            $imputacion5 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro5->id, 'nombre' => 'Caja - Efectivo', 'codigo' => 111010101]);

            // Cuenta Comisiones
            $capitulo6 = factory(\App\Capitulo::class)->create(['nombre' => 'Activo', 'codigo' => 5]);
            $rubro6 = factory(\App\Rubro::class)->create(['id_capitulo' => $capitulo6->id, 'nombre' => 'Recursos', 'codigo' => 51]);
            $moneda6 = factory(\App\Moneda::class)->create(['id_rubro' => $rubro6->id, 'nombre' => 'Recursos en pesos', 'codigo' => 511]);
            $departamento6= factory(\App\Departamento::class)->create(['id_moneda' => $moneda6->id, 'nombre' => 'Dpto general', 'codigo' => 51103]);
            $subRubro6 = factory(\App\SubRubro::class)->create(['id_departamento' => $departamento6->id, 'nombre' => 'Recursos especificos', 'codigo' => 5110301]);
            $imputacion6 = factory(\App\Imputacion::class)->create(['id_subrubro' => $subRubro6->id, 'nombre' => 'Comisiones XXX', 'codigo' => 511030101]);

            // Asiento de inicio
            $asiento = factory(\App\Asiento::class)->create(['id_ejercicio' => $ejercicio->id]);
        });
    }
}
