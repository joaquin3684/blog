<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asientos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imputacion')->unsigned();
            $table->foreign('id_imputacion')->references('id')->on('imputaciones');
            $table->double('debe')->nullable();
            $table->double('haber')->nullable();
            $table->bigInteger('nro_asiento');
            $table->date('fecha_contable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('asientos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
