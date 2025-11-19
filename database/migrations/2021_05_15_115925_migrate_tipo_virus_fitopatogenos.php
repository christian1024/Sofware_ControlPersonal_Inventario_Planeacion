<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateTipoVirusFitopatogenos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('FitoVirus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NombreVirus',250);
            $table->string('Siglas',150);
            $table->integer('Permitido');
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
        Schema::dropIfExists('FitoVirus');
    }
}
