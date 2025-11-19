<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabLecturaAjusteInvsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaAjusteInvs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->foreign('id_Patinador')->references('id')->on('RRHH_empleados');
            $table->integer('id_TipoSalida')->index();
            $table->foreign('id_TipoSalida')->references('id')->on('LabTipSalida_AjusteInvetarios');
            $table->integer('id_Cuarto');
            $table->integer('id_estante');
            $table->integer('id_piso');
            $table->string('CodigoBarras');
            $table->string('SemanaLectura');
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
        Schema::dropIfExists('LabLecturaAjusteInvs');
    }
}
