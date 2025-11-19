<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EtiquetasMigradas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabEtiquetasMigradas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('CodigoBarras',9);
            $table->integer('SemanaDespacho')->nullable();
            $table->string('FaseActual',25);
            $table->string('Identificador',16);
            $table->string('cliente',3)->nullable();
            $table->integer('NewSemanaDespacho')->nullable();
            $table->string('NewFaseActual',25)->nullable();
            $table->string('NewCliente',25)->nullable();
            $table->integer('Impresa')->nullable();
            $table->integer('CodigoRadicado')->nullable();
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
        Schema::dropIfExists('LabEtiquetasMigradas');
    }
}
