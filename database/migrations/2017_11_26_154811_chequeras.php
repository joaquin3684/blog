<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Chequeras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chequeras', function (Blueprint $table) {
            $table->increments('id');
            $table->double('nro_inicio');
            $table->integer('nro_chequera');
            $table->integer('nro_fin');
            $table->string('estado');
            $table->integer('id_banco')->unsigned();
            $table->foreign('id_banco')->references('id')->on('bancos');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('chequeras');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
