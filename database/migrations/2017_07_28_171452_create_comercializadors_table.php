<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComercializadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('comercializadores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('domicilio');
            $table->integer('dni');
            $table->integer('cuit');
            $table->integer('telefono');
            $table->double('porcentaje_colocacion');
            $table->string('email');
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('users');

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
        Schema::dropIfExists('comercializadores');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
