<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrcLecturaEntradaPropagacionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCLecturaEntradaPropagacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador')->index();
            $table->foreign('id_Patinador')->references('id')->on('RRHH_empleados');
            $table->integer('idUbicacion');
            $table->foreign('idUbicacion')->references('id')->on('URC_Propagacion');
            $table->integer('Plantas');
            $table->string('CodigoBarras')->unique();
            $table->integer('CodOperario');
            $table->integer('SemanaLectura');
            $table->integer('PlotId');
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
        Schema::dropIfExists('URCLecturaEntradaPropagacion');
    }
}
