<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuotas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('cuotable_id')->unsigned();
            $table->string('cuotable_type');
            $table->double('importe');
            $table->date('fecha_vencimiento');
            $table->date('fecha_inicio');
            $table->integer('nro_cuota');
            $table->string('estado');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cuotas');
    }
}
