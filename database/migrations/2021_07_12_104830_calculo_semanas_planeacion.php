<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CalculoSemanasPlaneacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabCalculoSemanasPlaneacion', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('AnoYSemana');
            $table->integer('Consecutivo');
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
        Schema::dropIfExists('LabCalculoSemanasPlaneacion');
    }
}
