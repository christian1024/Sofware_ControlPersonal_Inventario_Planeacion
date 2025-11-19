<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CancelacionesRenewalCodigos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('URCCodigosCanceladosRenewal', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idUser');
            $table->integer('idTipoCancelacion');
            $table->string('CodigoBarras');
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
        Schema::dropIfExists('URCCodigosCanceladosRenewal');
    }
}
