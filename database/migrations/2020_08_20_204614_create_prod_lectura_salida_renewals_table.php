<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdLecturaSalidaRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prod_lectura_salida_renewals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('CodigoBarras','10');
            $table->integer('idGetEtiquetas');
            $table->integer('ID_TipoSalida');
            $table->integer('ID_Usuario');
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
        Schema::dropIfExists('prod_lectura_salida_renewals');
    }
}
