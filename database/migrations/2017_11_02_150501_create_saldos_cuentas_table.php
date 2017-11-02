<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaldosCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos_cuentas', function (Blueprint $table) {
            $table->increments('id');
            $table->double('saldo');
            $table->integer('year');
            $table->integer('month');
            $table->integer('id_imputacion')->unsigned();
            $table->foreign('id_imputacion')->references('id')->on('imputaciones');
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

        Schema::dropIfExists('saldos_cuentas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
