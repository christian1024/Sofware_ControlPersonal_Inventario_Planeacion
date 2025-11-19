<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvSeccionCamas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_seccioncamas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Cama')->unsigned();;
            $table->foreign('id_Cama')->references('id')->on('inv_camas');
            $table->integer('N_Seccion');
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
        Schema::dropIfExists('inv_seccioncamas');
    }
}
