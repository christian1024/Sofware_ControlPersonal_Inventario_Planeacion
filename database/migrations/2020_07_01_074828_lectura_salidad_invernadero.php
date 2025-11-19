<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LecturaSalidadInvernadero extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaSalidasInvernadero', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->integer('id_TipoSalida')->index();
            $table->foreign('id_TipoSalida')->references('id')->on('InverCausalesDescartes');
            $table->integer('id_TipoCancelado')->index()->nullable();
            $table->string('CodigoBarras');
            $table->integer('Flag_Activo');
            $table->integer('SemanaLectura');
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
