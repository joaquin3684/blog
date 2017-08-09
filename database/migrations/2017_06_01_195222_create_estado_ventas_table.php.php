<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateEstadoVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estado_ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_venta')->unsigned();
            $table->foreign('id_venta')->references('id')->on('ventas');
            $table->integer('id_responsable_estado')->unsigned();
            $table->foreign('id_responsable_estado')->references('id')->on('users');
            $table->string('estado');
            $table->string('observacion');
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
        Schema::dropIfExists('estado_ventas');
    }
}