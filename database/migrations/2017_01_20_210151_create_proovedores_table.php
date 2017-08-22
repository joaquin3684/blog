<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProovedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('proovedores', function (Blueprint $table) {
            $table->increments('id');
            $table->string('razon_social');
            $table->integer('cuit');
            $table->string('domicilio');
            $table->integer('telefono');
            $table->string('descripcion');
            $table->softDeletes();
            $table->integer('id_prioridad')->unsigned();
            $table->foreign('id_prioridad')->references('id')->on('prioridades');
            $table->integer('usuario')->unsigned();
            $table->foreign('usuario')->references('id')->on('users');
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
        Schema::dropIfExists('proovedores');
    }
}
