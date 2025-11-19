<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LecturaSiembrasMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LecturaSiembra', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('PlotID');
            $table->string('PlantasSembradas');
            $table->string('ubicacion');
            $table->string('Raiz');
            $table->string('Cono');
            $table->string('Pinch');
            $table->string('Faltante');
            $table->string('Otro');
            $table->string('CausalOtros');
            $table->string('CodigoConfirmacion');
            $table->string('Observacion');
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
        Schema::dropIfExists('LecturaSiembra');
    }
}
