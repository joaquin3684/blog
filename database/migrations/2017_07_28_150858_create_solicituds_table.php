<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comercializador')->unsigned();
            $table->foreign('comercializador')->references('id')->on('comercializadores');
            $table->integer('agente_financiero')->unsigned()->nullable();
            $table->foreign('agente_financiero')->references('id')->on('proovedores');

            $table->integer('id_producto')->unsigned()->nullable();
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->string('estado');
            $table->string('doc_endeudamiento')->nullable();
            $table->double('total')->nullable();
            $table->integer('cuotas')->nullable();
            $table->double('monto_por_cuota')->nullable();
            $table->integer('id_socio')->unsigned();
            $table->double('monto_pagado')->nullable();
            $table->foreign('id_socio')->references('id')->on('socios');
            $table->softDeletes();
            $table->timestamps();
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
        Schema::dropIfExists('solicitudes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
