<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Tipo_Doc')->unsigned();
            $table->foreign('Tipo_Doc')->references('id_Doc')->on('RRHH_tipo_documentos');
            $table->string('Numero_Documento')->unsigned()->unique();
            $table->integer('Codigo_Empleado')->nullable()->unique();
            $table->string('Primer_Apellido','50');
            $table->string('Segundo_Apellido','50')->nullable();
            $table->string('Primer_Nombre','50');
            $table->string('Segundo_Nombre','50')->nullable();
            $table->string('Genero','25');
            $table->string('Direccion_Residencia','50')->nullable();
            $table->string('Telefono','50')->nullable();
            $table->string('Barrio','50')->nullable();
            $table->string('Rh','50')->nullable();
            $table->integer('Edad');
            $table->integer('Flag_Activo');
            $table->integer('departamentos_id_Expe')->unsigned();
            $table->foreign('departamentos_id_Expe')->references('id')->on('RRHH_departamentos');
            $table->integer('Ciudad_id_Expedcion')->unsigned();
            $table->foreign('Ciudad_id_Expedcion')->references('id')->on('RRHH_ciudades');
            $table->integer('departamentos_id_Residencia')->unsigned();
            $table->foreign('departamentos_id_Residencia')->references('id')->on('RRHH_departamentos');
            $table->integer('Ciudad_id_Residencia')->unsigned();
            $table->foreign('Ciudad_id_Residencia')->references('id')->on('RRHH_ciudades');
            $table->string('img','50')->nullable();
            $table->date('FechaNaciemiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     *
     */
    public function down()
    {
        Schema::dropIfExists('RRHH_empleados');
    }
}
