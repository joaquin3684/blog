<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
class ProovedoresTablaSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $faker = F::create('App\Proovedores');
        for ($i=0; $i < 100; $i++)
        {
        	DB::table('proovedores')->insert([
        	'nombre' => $faker->name,
	        'descripcion' => $faker->realText(200, 3),
        	]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
