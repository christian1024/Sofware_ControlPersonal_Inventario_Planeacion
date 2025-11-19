<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVariedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URC_Variedades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Codigo')->unique();
            $table->string('Nombre_Variedad','55');
            $table->integer('ID_Especie')->unsigned();
            $table->foreign('ID_Especie')->references('id')->on('URC_Especies');
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
        Schema::dropIfExists('URC_Variedades');
    }
}
