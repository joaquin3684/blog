<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('cuit');
            $table->integer('telefono');
            $table->string('domicilio');
            $table->string('codigo_postal');
            $table->integer('comercializador')->unsigned();
            $table->foreign('comercializador')->references('id')->on('comercializadores');
            $table->integer('agente_financiero')->unsigned()->nullable();
            $table->foreign('agente_financiero')->references('id')->on('agentes_financieros');
            $table->string('estado');
            $table->string('doc_documento');
            $table->string('doc_recibo');
            $table->string('doc_cbu');
            $table->string('doc_endeudamiento')->nullable();
            $table->string('doc_domicilio');
            $table->integer('total')->nullable();
            $table->integer('cuotas')->nullable();
            $table->integer('monto_por_cuota')->nullable();
            $table->integer('organismo')->unsigned();
            $table->foreign('organismo')->references('id')->on('organismos');
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
        Schema::dropIfExists('solicitudes');
    }
}
