<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EntradaSalidaPersonalMonitoreoMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('EntradaSalidaPersonalMonitoreo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('CodigoEmpleado');
            $table->integer('IDPatinadorEntrada');
            $table->integer('Flag_ActivoEntrada');
            $table->integer('IDPatinadorSalida')->nullable();
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
        Schema::dropIfExists('EntradaSalidaPersonalMonitoreo');
    }
}
