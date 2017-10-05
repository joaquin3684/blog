<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesSinInversionistasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('solicitudes_sin_inversionistas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('solicitud')->unsigned();
            $table->foreign('solicitud')->references('id')->on('solicitudes');
            $table->integer('agente_financiero')->unsigned();
            $table->foreign('agente_financiero')->references('id')->on('proovedores');

        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('solicitudes_sin_inversionistas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
