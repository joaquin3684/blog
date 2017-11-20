<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorImputacionDeudoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedor_imputaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('codigo');
            $table->integer('id_proveedor')->unsigned();
            $table->foreign('id_proveedor')->references('id')->on('proovedores');
            $table->integer('id_imputacion')->unsigned();
            $table->foreign('id_imputacion')->references('id')->on('imputaciones');
            $table->string('tipo');
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

        Schema::dropIfExists('proveedor_imputaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
