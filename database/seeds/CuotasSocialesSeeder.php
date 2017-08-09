<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory as F;

class CuotasSocialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = F::create('App\Proovedores');
        $hoy = Carbon::today();
        $vto = Carbon::today()->addMonth();
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        for($i=1; $i < 5; $i++){
            DB::table('cuotas')->insert([
                'cuotable_id' => 1,
                'cuotable_type' => 'App\Socios',
                'fecha_inicio' => $hoy->toDateString(),
                'fecha_vencimiento' => $vto->toDateString(),
                'nro_cuota' => $i,
                'importe' => 20,
            ]);
            $hoy->addMonth();
            $vto->addMonth();
            for($j = 1; $j < 3; $j++)
            {
                DB::table('movimientos')->insert([
                    'identificadores_id' => $i,
                    'identificadores_type' => 'App\Cuotas',
                    'fecha' => $faker->date('Y-m-d'),
                    'entrada' => $faker->randomNumber(),
                ]);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
