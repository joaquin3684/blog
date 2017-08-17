<?php

use App\Prioridades;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Seeder;

class InicioSistemaSoloAbms extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $this->call(ComercializadorSeed::class);
        $this->call(ProovedoresTablaSeeder::class);
        $this->call(ProductosTablaSeeder::class);
        $this->call(OrganismosTablaSeeder::class);
        $this->call(SociosTablaSeeder::class);
    }
}
