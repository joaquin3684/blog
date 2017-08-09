<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;

class ProductosTablaSeeder extends Seeder
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
           for($i=0; $i < 100; $i++){
	        	DB::table('productos')->insert([
	        		'id_proovedor' => $faker->numberBetween(1,10),
	        		'nombre' => $faker->name,
	        		'ganancia' => $faker->numberBetween(0, 100),
	        		]);
        } 
         DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
    }
}
