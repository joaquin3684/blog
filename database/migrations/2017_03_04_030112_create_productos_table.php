<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_proovedor')->unsigned()->nullable();
            $table->foreign('id_proovedor')->references('id')->on('proovedores');
            $table->string('descripcion')->nullable();
            $table->string('tipo')->nullable();
            $table->double('ganancia')->nullable();
            $table->double('tasa')->nullable();
            $table->string('nombre')->nullable();
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
        Schema::dropIfExists('productos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}