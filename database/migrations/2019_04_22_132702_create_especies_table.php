<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEspeciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URC_Especies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NombreEspecie');
            $table->integer('CodigoIntegracionEspecie')->unique();
            $table->integer('Id_Genero')->unsigned();
            $table->foreign('Id_Genero')->references('id')->on('URC_Generos');
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
        Schema::dropIfExists('URC_Especies');
    }
}
