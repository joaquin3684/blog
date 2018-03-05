<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PantallasSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            $pantallas = [ 'bancos', 
                 'capitulos',
                 'comercializadores',
                 'operaciones',
                 'organismos',
                 'pantallas',
                 'productos',
                 'proovedores',
                 'roles',
                 'socios',
                 'usuarios',
                 'agentesFinancieros',
                 'aprobacionServicios',
                 'asientosManuales',
                 'balances',
                 'cajaOperaciones',
                 'cajas',
                 'ccCuotasSociales',
                 'cobrar',
                 'cobroCuotasSociales',
                 'comercializador',
                 'correrVtoServicios',
                 'ventas',
                 'darServicios',
                 'mayorContable',
                 'novedades',
                 'pagoContableProveedores',
                 'pagoProveedores',
                 'CCProveedor',
                 'solicitudesPendientes',
                 'fechaContable',
                 'cerrarFecha',
                 'solicitudesPendientesDeCobro',
                 'cuentaCorrienteComercializador'
            ];
            for ($i=0; $i < count($pantallas); $i++)
            {
                DB::table('pantallas')->insert([
                 'nombre' => $pantallas[$i]
                ]);
            }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
