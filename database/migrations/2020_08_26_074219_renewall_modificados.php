<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenewallModificados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCCodigosRenewallUpdate', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CodigoBarras');
            $table->string('PlotIdCargado');
            $table->string('ProcedenciaCargada');
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
        Schema::dropIfExists('URCCodigosRenewallUpdate');
    }
}
