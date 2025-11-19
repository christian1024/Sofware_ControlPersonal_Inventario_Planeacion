<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UbicacionPropagacionMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URC_Propagacion', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Ubicacion','10');
            $table->integer('CapacidadBandejas');
            $table->integer('CapacidadEsquejes');
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
        Schema::dropIfExists('URC_Propagacion');
    }
}
