<?php

use App\Prioridades;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicioSistemaSoloAbms extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::transaction(function () {
            //$this->call(UserSeed::class);
            $this->call(ComercializadorSeed::class);
            $this->call(ProovedoresTablaSeeder::class);
            $this->call(ProductosTablaSeeder::class);
            $this->call(OrganismosTablaSeeder::class);
            $this->call(SociosTablaSeeder::class);
            $this->call(PrioridadesSeed::class);
        });

    }
}
