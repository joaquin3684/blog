<?php

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
            $table->integer('codigo');
            $table->foreign('id_subrubro')->references('id')->on('subrubros');
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
        Schema::dropIfExists('imputaciones');
    }
}
