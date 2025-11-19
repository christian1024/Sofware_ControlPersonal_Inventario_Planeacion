<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabLecturaSaliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaSalidas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->foreign('id_Patinador')->references('id')->on('RRHH_empleados');
            $table->integer('id_TipoSalida')->index();
            $table->foreign('id_TipoSalida')->references('id')->on('LabTipSalida_AjusteInvetarios');
            $table->integer('id_TipoCancelado')->index()->nullable();
            $table->foreign('id_TipoCancelado')->references('id')->on('labCausalesDescartes');
            $table->string('CodigoBarras');
            $table->integer('Flag_Activo');
            $table->integer('SemanaLectura');
            $table->integer('FlagActivo_CambioFase')->nullable();;

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
        Schema::dropIfExists('LabLecturaSalias');
    }
}
