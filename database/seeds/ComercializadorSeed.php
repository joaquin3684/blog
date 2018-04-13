<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
use Illuminate\Support\Facades\DB;

class ComercializadorSeed extends Seeder
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
        for ($i=0; $i < 10; $i++)
        {
            DB::table('comercializadores')->insert([
                'nombre' => $faker->name,
                'apellido' => $faker->name,
                'domicilio' => $faker->address,
                'cuit' =>   $faker->randomNumber(8),
                'dni' => $faker->randomNumber(8),
                'telefono' => $faker->randomNumber(8),
                'email' => $faker->email,
                'usuario' => $i,
            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
