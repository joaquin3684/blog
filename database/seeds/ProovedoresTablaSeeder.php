<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
class ProovedoresTablaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker = F::create('App\Proovedores');
        for ($i=0; $i < 10; $i++)
        {
        	DB::table('proovedores')->insert([
        	'nombre' => $faker->name,
	        'descripcion' => $faker->realText(100, 3),
                'id_prioridad' => $faker->numberBetween(1, 2),
                'usuario' => $i,
        	]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
