<?php

use Illuminate\Support\Facades\DB;
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
            $table->string('razon_social')->nullable();
            $table->integer('cuit')->nullable();
            $table->string('domicilio')->nullable();
            $table->integer('telefono')->nullable();
            $table->string('descripcion')->nullable();
            $table->softDeletes();
            $table->integer('id_prioridad')->unsigned()->nullable();
            $table->foreign('id_prioridad')->references('id')->on('prioridades');
            $table->integer('usuario')->unsigned()->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('proovedores');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
