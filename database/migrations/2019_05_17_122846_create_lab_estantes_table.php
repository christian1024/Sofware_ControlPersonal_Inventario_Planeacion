<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabEstantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_estantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Cuarto')->unsigned();;
            $table->foreign('id_Cuarto')->references('id')->on('lab_cuartos');
            $table->integer('N_Estante');
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
        Schema::dropIfExists('lab_estantes');
    }
}
