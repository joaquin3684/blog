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
            $table->string('nombre')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->double('valor')->nullable();
            $table->string('cuit')->nullable();
            $table->integer('dni')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('sexo')->nullable();
            $table->string('localidad')->nullable();
            $table->integer('codigo_postal')->nullable();
            $table->integer('telefono')->nullable();
            $table->integer('id_organismo')->unsigned()->nullable();
            $table->foreign('id_organismo')->references('id')->on('organismos');
            $table->date('fecha_ingreso')->nullable();
            $table->integer('legajo')->nullable();
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
