<?php
use Illuminate\Support\Facades\DB;
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
        Schema::disableForeignKeyConstraints();

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
        Schema::enableForeignKeyConstraints();

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('estado_ventas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}