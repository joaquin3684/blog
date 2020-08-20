<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_cuota')->unsigned();
            $table->foreign('id_cuota')->references('id')->on('cuotas');
            $table->double('entrada');
            $table->double('salida')->default(0);
            $table->date('fecha');
            $table->double('ganancia')->default(0);
            $table->integer('contabilizado_salida')->default(0);
            $table->integer('contabilizado_entrada')->default(0);
            $table->softDeletes();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('movimientos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
