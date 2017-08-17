<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
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
            DB::table('users')->insert([
                'usuario' => $i,
                'password' => $i,
                'email' => $faker->email,

            ]);
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
