<?php

use Illuminate\Support\Facades\DB;
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
        Schema::disableForeignKeyConstraints();

        Schema::create('socios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento');
            $table->string('cuit');
            $table->integer('dni');
            $table->string('domicilio');
            $table->string('sexo');
            $table->string('localidad');
            $table->integer('codigo_postal');
            $table->integer('telefono');
            $table->integer('id_organismo')->unsigned();
            $table->foreign('id_organismo')->references('id')->on('organismos');
            $table->date('fecha_ingreso')->nullable();
            $table->integer('legajo');

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
        Schema::dropIfExists('socios');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
