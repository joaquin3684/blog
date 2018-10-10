<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InicioSistemaCompleto extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            $this->call(InicioSistemaSoloAbms::class);
            $this->call(VentasParaCobrar::class);
            $this->call(PantallasSeed::class);
            $this->call(InicioSistema::class);
        });
    }
}
