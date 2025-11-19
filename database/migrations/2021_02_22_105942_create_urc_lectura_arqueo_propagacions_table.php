<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrcLecturaArqueoPropagacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCLecturaArqueoPropagacions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_Patinador');
            $table->integer('idUbicacion');
            $table->integer('Plantas');
            $table->integer('PlotId');
            $table->integer('Semana');
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
        Schema::dropIfExists('URCLecturaArqueoPropagacions');
    }
}
