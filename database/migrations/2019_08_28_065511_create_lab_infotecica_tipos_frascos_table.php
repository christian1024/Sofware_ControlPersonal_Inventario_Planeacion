<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabInfotecicaTiposFrascosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_infotecica_tipos_frascos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Variedad')->unsigned();
            $table->foreign('id_Variedad')->references('id')->on('URC_Variedades');

            $table->integer('id_fase')->unsigned();
            $table->foreign('id_fase')->references('id')->on('tipo_fases_labs');
            $table->integer('id_tipofrasco')->unsigned();
            $table->foreign('id_tipofrasco')->references('id')->on('tipo_Contenedores_labs');
            $table->integer('Cantidad');
            $table->integer('IdUser');
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
        Schema::dropIfExists('lab_infotecica_tipos_frascos');
    }
}
