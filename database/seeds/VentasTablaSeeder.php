<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class VentasTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hoy = Carbon::today();
        $vto = Carbon::today()->addMonth();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('ventas')->insert([
            'id_asociado' => 1,
            'id_producto' => 1,
            'nro_cuotas' => 5,
            'importe' => 100,
        ]);
        for($i=1; $i < 6; $i++){
            DB::table('cuotas')->insert([
                'cuotable_id' => 1,
                'cuotable_type' => 'App\Ventas',
                'fecha_inicio' => $hoy->toDateString(),
                'fecha_vencimiento' => $vto->toDateString(),
                'nro_cuota' => $i,
                'importe' => 20,
            ]);
            $hoy->addMonth();
            $vto->addMonth();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
