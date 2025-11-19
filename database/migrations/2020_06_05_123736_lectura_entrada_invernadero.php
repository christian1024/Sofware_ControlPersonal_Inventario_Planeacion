<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LecturaEntradaInvernadero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaEntradasInvernadero', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->foreign('id_Patinador')->references('id')->on('RRHH_empleados');
            $table->integer('id_Cama');
            $table->integer('id_SeccionCama');
            $table->integer('Plantas')->nullable();
            $table->string('CodigoBarras')->unique();
            $table->integer('SemanaLectura');
            $table->integer('CodOperario');
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
        Schema::dropIfExists('LabLecturaEntradasInvernadero');
    }
}
