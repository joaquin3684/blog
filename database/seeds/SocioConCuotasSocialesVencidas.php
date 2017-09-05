<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SocioConCuotasSocialesVencidas extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hoy = Carbon::today()->subMonths(4);
        $vto = Carbon::today()->subMonths(3);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::transaction(function ()  use ($hoy, $vto){
            $organismo1 = factory(\App\Organismos::class)->create();
            $organismo2 = factory(\App\Organismos::class)->create();

            $socio1 = factory(\App\Socios::class)->create(['id_organismo' => $organismo1->id]);
            $socio2 = factory(\App\Socios::class)->create(['id_organismo' => $organismo2->id]);


            for ($i = 1; $i < 6; $i++) {

                $cuota = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['fecha_inicio' => $hoy->toDateString(), 'fecha_vencimiento' => $vto->toDateString(), 'cuotable_id' => $socio1->id]);
                $cuota2 = factory(\App\Cuotas::class)->states('cuotas sociales')->create(['fecha_inicio' => $hoy->toDateString(), 'fecha_vencimiento' => $vto->toDateString(), 'cuotable_id' => $socio2->id]);
                $hoy->addMonth();
                $vto->addMonth();
            }

        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
