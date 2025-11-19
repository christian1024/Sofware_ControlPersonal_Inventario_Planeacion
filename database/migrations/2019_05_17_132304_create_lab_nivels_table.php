<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabNivelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_nivels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Estante')->unsigned();;
            $table->foreign('id_Estante')->references('id')->on('lab_estantes');
            $table->integer('N_Nivel');
            $table->integer('Flag_Activo');
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
        Schema::dropIfExists('lab_nivels');
    }
}
