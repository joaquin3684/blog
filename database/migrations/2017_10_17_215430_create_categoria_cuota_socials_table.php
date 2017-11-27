<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaCuotaSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoria_cuota_sociales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_organismo')->unsigned();
            $table->foreign('id_organismo')->references('id')->on('organismos');
            $table->integer('categoria');
            $table->double('valor');
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

        Schema::dropIfExists('categoria_cuota_sociales');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
