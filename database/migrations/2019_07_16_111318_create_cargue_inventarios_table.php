<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargueInventariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cargue_inventario', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('CodigoVariedad');
            $table->string('Identificador');
            $table->string('Breeder');
            $table->string('FaseActual');
            $table->date('SemanaUltimoMovimiento');
            $table->date('SemanaIngreso');
            $table->string('Cantidad');
            $table->integer('id_Cuarto')->unsigned();
            $table->foreign('id_Cuarto')->references('id')->on('lab_cuartos');
            $table->integer('id_Estante')->unsigned();
            $table->foreign('id_Estante')->references('id')->on('lab_estantes');
            $table->integer('id_Nivel')->unsigned();
            $table->foreign('id_Nivel')->references('id')->on('lab_nivels');
            $table->integer('id_Frasco')->unsigned();
            $table->foreign('id_Frasco')->references('id')->on('tipo_Contenedores_labs');
            $table->date('SemanaDespacho')->nullable();
            $table->integer('NumeroRadicado')->nullable();
            $table->string('cliente')->nullable();
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
        Schema::dropIfExists('cargue_inventarios');
    }
}
