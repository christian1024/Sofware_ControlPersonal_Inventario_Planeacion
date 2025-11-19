<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabLecturaEntradasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaEntradas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->foreign('id_Patinador')->references('id')->on('RRHH_empleados');
            $table->integer('id_Cuarto');
            $table->integer('id_estante');
            $table->integer('id_piso');
            $table->integer('Plantas')->nullable();
            $table->string('CodigoBarras');
            $table->string('SemanaLectura');
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
        Schema::dropIfExists('LabLecturaEntradas');
    }
}
