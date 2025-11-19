<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabInfotecnicaVariedadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_infotecnica_variedades', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Variedad')->unsigned();
            $table->foreign('id_Variedad')->references('id')->on('URC_Variedades');
            $table->string('CoeficienteMultiplicacion');
            $table->string('PorcentajePerdida');
            $table->integer('id_fase')->unsigned();
            $table->foreign('id_fase')->references('id')->on('tipo_fases_labs');
            $table->string('PorcentajePerdidaFase');
            $table->integer('SemanasXFase');
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
        Schema::dropIfExists('lab_infotecnica_variedades');
    }
}
