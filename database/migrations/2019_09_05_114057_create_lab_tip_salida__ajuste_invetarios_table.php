<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabTipSalidaAjusteInvetariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabTipSalida_AjusteInvetarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('TipoSalida_Ajuste');
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
        Schema::dropIfExists('LabTipSalida_AjusteInvetarios');
    }
}
