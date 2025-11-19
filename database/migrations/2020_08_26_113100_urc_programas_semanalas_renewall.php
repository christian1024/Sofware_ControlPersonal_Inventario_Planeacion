<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrcProgramasSemanalasRenewall extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCProgramasSemanalesRenewall', function (Blueprint $table) {
            $table->increments('id');
            $table->string('PlotID');
            $table->string('CanTPlantas');
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
        Schema::dropIfExists('URCProgramasSemanalesRenewall');
    }
}
