<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LecturaControlMonitoreoMigrate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LecturaControlMonitoreo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CodigoBarras');
            $table->integer('CodOperarioRevision')->nullable();
            $table->integer('IdPatinadorEntrada')->nullable();
            $table->integer('Flag_ActivoEntrada')->nullable();
            $table->integer('IdPatinadorSalida')->nullable();
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
        Schema::dropIfExists('LecturaControlMonitoreo');
    }
}
