<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
use Illuminate\Support\Facades\DB;

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
           for($i=0; $i < 2; $i++){
	        	DB::table('productos')->insert([
	        		'id_proovedor' => 1,
	        		'nombre' => $faker->name,
	        		'ganancia' => 10,
	        		'tasa' => 20,
                    'tipo' => 'Producto'
	        		]);
            }
        for($i=0; $i < 2; $i++){
            DB::table('productos')->insert([
                'id_proovedor' => $faker->numberBetween(1,10),
                'nombre' => $faker->name,
                'ganancia' => 10,
                'tasa' => 20,
                'tipo' => 'Credito'
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
