<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
class SociosTablaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	$faker = F::create('App\Proovedores');
           for($i=0; $i < 10; $i++){
	        	DB::table('socios')->insert([
	        		'id_organismo' => $faker->numberBetween(1,10),
	        		'nombre' => $faker->name,
	        		]);
        } 
         DB::statement('SET FOREIGN_KEY_CHECKS=1;');   
    }
}
