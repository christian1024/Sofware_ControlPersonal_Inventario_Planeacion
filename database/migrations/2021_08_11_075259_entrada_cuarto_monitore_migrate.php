<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EntradaCuartoMonitoreMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LecturaEntradaCuartoMonitoreo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CodigoBarras');
            $table->integer('IdUsers');
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
        Schema::dropIfExists('LecturaEntradaCuartoMonitoreo');
    }
}
