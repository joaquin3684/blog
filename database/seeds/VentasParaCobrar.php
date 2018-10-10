<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VentasParaCobrar extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hoy1 = Carbon::today()->subMonths(2);
        $hoy1->addDay();
        $vto1 = Carbon::today()->subMonths(1);
        $hoy2 = Carbon::today()->subMonths(1);
        $hoy2->addDay();
        $vto2 = Carbon::today();
        $hoy3 = Carbon::today()->subMonths(3);
        $hoy3->addDay();
        $vto3 = Carbon::today()->subMonths(2);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::transaction(function () use ($hoy1, $vto1, $hoy2, $vto2, $hoy3, $vto3) {

            $venta1 = factory(\App\Ventas::class)->create(['id_producto' => 1, 'nro_credito' => 1, 'id_asociado' => 1]);

            $venta2 = factory(\App\Ventas::class)->create(['id_producto' => 2, 'nro_credito' => 2, 'id_asociado' => 1]);

            $venta3 = factory(\App\Ventas::class)->create(['id_producto' => 1, 'nro_credito' => 3, 'id_asociado' => 2]);

            for ($i = 1; $i < 6; $i++) {

                $cuota = factory(\App\Cuotas::class)->create(['nro_cuota' => $i, 'fecha_inicio' => $hoy1->toDateString(), 'fecha_vencimiento' => $vto1->toDateString(), 'cuotable_id' => $venta1->id, 'importe' => $venta1->importe_cuota]);

                $hoy1->addMonth();
                $vto1->addMonth();
            }

            for ($i = 1; $i < 6; $i++) {

                $cuota = factory(\App\Cuotas::class)->create(['nro_cuota' => $i, 'fecha_inicio' => $hoy2->toDateString(), 'fecha_vencimiento' => $vto2->toDateString(), 'cuotable_id' => $venta2->id, 'importe' => $venta2->importe_cuota]);

                $hoy2->addMonth();
                $vto2->addMonth();
            }


            for ($i = 1; $i < 6; $i++) {

                $cuota = factory(\App\Cuotas::class)->create(['nro_cuota' => $i, 'fecha_inicio' => $hoy3->toDateString(), 'fecha_vencimiento' => $vto3->toDateString(), 'cuotable_id' => $venta3->id, 'importe' => $venta3->importe_cuota]);

                $hoy3->addMonth();
                $vto3->addMonth();
            }

        });
    }
}
