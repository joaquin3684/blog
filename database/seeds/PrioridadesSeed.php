<?php

use Illuminate\Database\Seeder;

class PrioridadesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Prioridades::class)->create();
        factory(\App\Prioridades::class)->states('baja')->create();
    }
}
