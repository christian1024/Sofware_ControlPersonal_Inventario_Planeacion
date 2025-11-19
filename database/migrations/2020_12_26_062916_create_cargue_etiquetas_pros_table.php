<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargueEtiquetasProsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CargueEtiquetasPros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CodigoVariedad',25);
            $table->string('CodigoBarras',25);
            $table->string('CodigoCaja',25);
            $table->string('CodigoBarrasCaja',25);
            $table->string('diadespacho ',25);
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
        Schema::dropIfExists('CargueEtiquetasPros');
    }
}
