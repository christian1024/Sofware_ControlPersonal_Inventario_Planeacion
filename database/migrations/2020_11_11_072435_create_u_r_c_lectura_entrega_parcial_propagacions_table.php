<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateURCLecturaEntregaParcialPropagacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URClecturaEntregaParcialPropagacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CodigoBarras');
            $table->integer('IdCausalParcial');
            $table->integer('PlantasEntregar');
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
        Schema::dropIfExists('URClecturaEntregaParcialPropagacions');
    }
}
