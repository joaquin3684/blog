<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSociosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->date('fecha_nacimiento');
            $table->string('cuit');
            $table->integer('dni');
            $table->string('domicilio');
            $table->string('localidad');
            $table->integer('codigo_postal');
            $table->integer('telefono');
            $table->integer('id_organismo')->unsigned();
            $table->foreign('id_organismo')->references('id')->on('organismos');
            $table->date('fecha_ingreso');
            $table->integer('legajo');
            $table->string('grupo_familiar');
            $table->softDeletes();
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
        Schema::dropIfExists('socios');
    }
}
