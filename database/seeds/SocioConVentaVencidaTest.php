<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SocioConVentaVencidaTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $hoy = Carbon::today();
        $vto = Carbon::today()->addMonth();

            DB::table('ventas')->insert([
                'id' => 1,
                'id_asociado' => 1,
                'id_producto' => 1,
                'nro_cuotas' => 5,
                'importe' => 500,
                'fecha' => $hoy->toDateString(),
                'fecha_vencimiento' => $vto->toDateString(),
            ]);

            $hoy->subMonths(3);
            $vto->subMonth(3);

        for($i=1; $i < 6; $i++) {
            DB::table('cuotas')->insert([
                'cuotable_id' => 1,
                'cuotable_type' => 'App\Ventas',
                'fecha_inicio' => $hoy->toDateString(),
                'fecha_vencimiento' => $vto->toDateString(),
                'nro_cuota' => $i,
                'importe' => 100,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
