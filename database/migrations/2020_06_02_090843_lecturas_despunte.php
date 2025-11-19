<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LecturasDespunte extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('LabLecturaDespunte', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Patinador');
            $table->string('CodigoBarras');
            $table->integer('CodOperario');
            $table->integer('Flag_Activo');
            $table->integer('SemanaLectura');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('LabLecturaDespunte');
    }
}
