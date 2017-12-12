<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCajaOperacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('caja_operaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->double('entrada')->default(0);
            $table->double('salida')->default(0);
            $table->integer('id_operacion')->unsigned();
            $table->foreign('id_operacion')->references('id')->on('operaciones');
            $table->string('operacion_type');
            $table->string('observacion');
            $table->integer('transferencia');
            $table->integer('id_chequera')->unsigned()->nullable();
            $table->foreign('id_chequera')->references('id')->on('chequeras');
            $table->integer('nro_cheque')->nullable();
            $table->date('vto_cheque')->nullable();
            $table->integer('id_banco')->unsigned()->nullable();
            $table->foreign('id_banco')->references('id')->on('bancos');
            $table->date('fecha');
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

        Schema::dropIfExists('caja_operaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
