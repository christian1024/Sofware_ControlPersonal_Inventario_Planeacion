<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MigrateResultadoMuestrasFitopatologia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabMuestrasFitopatologia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('Identificador',25);
            $table->string('CodigoBarras',10);
            $table->string('SemanaActual',6);
            $table->string('ResultadoIndex',15)->nullable();
            $table->string('MuestrasScreen',350)->nullable();
            $table->string('PositivosMuestrasScreen',350)->nullable();
            $table->string('PositivosMuestrasScreenRestringidas',350)->nullable();
            $table->string('AgroRhodoPruebaUno',15)->nullable();
            $table->string('AgroRhodoPruebaDos',15)->nullable();
            $table->string('AgroRhodoPruebaTres',15)->nullable();
            $table->string('AgroRhodoPruebaCuatro',15)->nullable();
            $table->string('Comentario',15)->nullable();
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
        Schema::dropIfExists('LabMuestrasFitopatologia');
    }
}
