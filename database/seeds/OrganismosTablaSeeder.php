<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
use Illuminate\Support\Facades\DB;

class OrganismosTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = F::create('App\Organismos');
        for ($i=0; $i < 3; $i++)
        {
            $org = factory(App\Organismos::class)->create();
            $cat1 = factory(App\CategoriaCuotaSocial::class)->create(['id_organismo' => $org->id, 'categoria' => 1, 'valor' =>  100]);
            $cat1 = factory(App\CategoriaCuotaSocial::class)->create(['id_organismo' => $org->id, 'categoria' => 2, 'valor' =>  200]);
            $cat1 = factory(App\CategoriaCuotaSocial::class)->create(['id_organismo' => $org->id, 'categoria' => 3, 'valor' =>  300]);
        }

	     
    }
}
