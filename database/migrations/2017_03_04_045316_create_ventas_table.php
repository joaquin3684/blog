<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('ventas', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_asociado')->unsigned();
            $table->integer('id_producto')->unsigned();
            $table->foreign('id_asociado')->references('id')->on('socios');
            $table->foreign('id_producto')->references('id')->on('productos');
            $table->string('descripcion')->nullable();
            $table->integer('nro_cuotas');
            $table->integer('importe');
            $table->date('fecha_vencimiento');
            $table->integer('nro_credito')->nullable();
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
        Schema::dropIfExists('ventas');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}