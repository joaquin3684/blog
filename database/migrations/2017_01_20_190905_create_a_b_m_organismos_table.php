<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateABMOrganismosTable extends Migration
{
    public function up()
    {
        //Schema::rename('a_b_m_organismos', 'ORGANISMOS');
        Schema::create('organismos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('cuit');
            $table->integer('cuota_social');
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
        Schema::dropIfExists('ORGANISMOS');
    }
}
