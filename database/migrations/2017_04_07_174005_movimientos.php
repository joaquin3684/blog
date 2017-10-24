<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class Movimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('identificadores_id')->unsigned();
            $table->string('identificadores_type');
            $table->double('entrada');
            $table->double('salida')->default(0);
            $table->date('fecha');
            $table->double('ganancia')->default(0);
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
        Schema::dropIfExists('movimientos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}