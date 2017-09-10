<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SocioConVentaVencidaTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $hoy = Carbon::today()->subMonths(4);
         $hoy->addDay();
         $vto = Carbon::today()->subMonths(3);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::transaction(function ()  use ($hoy, $vto){
            $proveedor1 = factory(\App\Proovedores::class)->create();
            $proveedor2 = factory(\App\Proovedores::class)->states('prioridad 2')->create();
            $producto1 = factory(\App\Productos::class)->create(['id_proovedor' => $proveedor1->id]);
            $producto2 = factory(\App\Productos::class)->create(['id_proovedor' => $proveedor2->id]);

            $venta1 = factory(\App\Ventas::class)->states('vencida 2 meses')->create(['id_producto' => $producto1->id, 'nro_credito' => 1]);
            $venta2 = factory(\App\Ventas::class)->states('vencida 2 meses')->create(['id_producto' => $producto2->id, 'nro_credito' => 2]);


            for ($i = 1; $i < 6; $i++) {

                $cuota = factory(\App\Cuotas::class)->create(['fecha_inicio' => $hoy->toDateString(), 'fecha_vencimiento' => $vto->toDateString(), 'cuotable_id' => $venta1->id]);
                $cuota2 = factory(\App\Cuotas::class)->create(['fecha_inicio' => $hoy->toDateString(), 'fecha_vencimiento' => $vto->toDateString(), 'cuotable_id' => $venta2->id]);
                $hoy->addMonth();
                $vto->addMonth();
            }

        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

}
