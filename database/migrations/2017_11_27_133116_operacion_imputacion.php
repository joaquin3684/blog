<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OperacionImputacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operacion_imputacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_imputacion')->unsigned();
            $table->foreign('id_imputacion')->references('id')->on('imputaciones');
            $table->integer('id_operacion')->unsigned();
            $table->foreign('id_operacion')->references('id')->on('operaciones');
            $table->smallInteger('debe')->default(0);
            $table->smallInteger('haber')->default(0);
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

        Schema::dropIfExists('operacion_imputacion');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
