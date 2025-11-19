<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdInfotecRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_infotec_renewal', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('CodigoVariedad');
            $table->string('TamañoEsqueje','20');
            $table->integer('EsquejesXBolsillo');
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
        Schema::dropIfExists('prod_infotec_renewal');
    }
}
