<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImputacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imputaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('codigo');
            $table->foreign('id_subrubro')->references('id')->on('sub_rubros');
            $table->integer('id_subrubro')->unsigned()->nullable();
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
        Schema::dropIfExists('imputaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
