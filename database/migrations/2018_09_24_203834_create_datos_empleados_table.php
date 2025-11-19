<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('RRHH_datos_empleados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_Empleado')->unsigned()->unique();
            $table->foreign('id_Empleado')->references('id')->on('RRHH_empleados');
            $table->Date('Fecha_Ingreso')->nullable();
            $table->integer('Salario')->nullable();
            $table->Date('Fecha_retiro')->nullable();
            $table->integer('Frecuencia')->nullable();
            $table->Date('Ultima_Fecha_Ingreso')->nullable();
            $table->Date('Fecha_Cambio_Contrato')->nullable();
            $table->string('Tipo_Vivienda', '50')->nullable();

            $table->integer('id_Pension')->unsigned()->nullable();
            $table->foreign('id_Pension')->references('id')->on('RRHH_FondosPension'); /***************ojo toca llenar el select*/


            $table->string('Cesantias', '50')->nullable();

            $table->integer('id_CajaCompensacion')->unsigned()->nullable();
            $table->foreign('id_CajaCompensacion')->references('id')->on('RRHH_CajasCompensacion'); /***************ojo toca llenar el select*/

            $table->string('Auxilio_Transporte', '5')->nullable();
            $table->string('Numero_Cuenta', '50')->nullable();
            $table->string('acion', '50')->nullable();
            $table->integer('Numero_Hijos')->nullable();
            $table->string('Talla_Chaqueta', '50')->nullable();
            $table->string('Talla_Pantalon', '50')->nullable();
            $table->string('Talla_overol', '50')->nullable();
            $table->integer('Numero_Calzado')->nullable();
            $table->integer('personas_cargo')->nullable();
            $table->float('peso')->nullable();
            $table->float('estatura')->nullable();
            $table->string('enfermedad_laboral', '50')->nullable();
            $table->string('Carnet', '50')->nullable();
            $table->integer('Numero_Botas_Caucho')->nullable();
            $table->string('Raza', '50')->nullable();
            $table->string('Estrato_Social', '50')->nullable();
            $table->string('Enfermedad_Comun', '50')->nullable();
            $table->string('At_Level', '25')->nullable();
            $table->string('At_Grave', '25')->nullable();
            $table->string('Intervencion_Xat', '25')->nullable();
            $table->string('Comida_Dia', '25')->nullable(); /*Consume 5 comidas al dia*/
            $table->string('Vegetales', '25')->nullable();
            $table->string('Carbohidratos', '25')->nullable();
            $table->string('Hidratacion', '25')->nullable(); /*se hidrata*/
            $table->string('cumple_horario_comidas', '25')->nullable();
            $table->string('Deporte', '25')->nullable(); /*si o no*/
            $table->string('Hobbies', '25')->nullable();
            $table->string('sustancias_psicoactivas', '25')->nullable();
            $table->string('fuma', '25')->nullable();
            $table->string('consume_alcohol', '25')->nullable();
            $table->string('restriccion', '25')->nullable();
            $table->string('motivo_retiro', '25')->nullable();
            $table->string('lavado_manos', '25')->nullable();



  /*          $table->integer('Horas_Activas_mes_anterior')->nullable();
            $table->integer('Horas_activas_semna_anterior')->nullable();
            $table->integer('horas_semanas_seleccionada')->nullable();*/


            $table->integer('Nivel_Sisben')->nullable();
            $table->integer('Rodamiento')->nullable();

            $table->integer('id_arl')->unsigned()->nullable();
            $table->foreign('id_arl')->references('id')->on('RRHH_arlS');



            $table->integer('id_Estado_Civil')->unsigned()->nullable();
            $table->foreign('id_Estado_Civil')->references('id')->on('RRHH_estado_civils');


            $table->integer('id_Medio_Transporte')->unsigned()->nullable();
            $table->foreign('id_Medio_Transporte')->references('id')->on('RRHH_medio_transportes');


            $table->integer('id_Cargo')->unsigned()->nullable();
            $table->foreign('id_Cargo')->references('id')->on('RRHH_cargos');

            $table->integer('id_tipocontratos')->unsigned()->nullable();
            $table->foreign('id_tipocontratos')->references('id')->on('RRHH_tipo_contratos');

            $table->integer('id_area')->unsigned()->nullable();
            $table->foreign('id_area')->references('id')->on('RRHH_areas');

            $table->integer('id_Sub_Area')->unsigned()->nullable();
            $table->foreign('id_Sub_Area')->references('id')->on('RRHH_sub_areas');

            $table->integer('id_Bloque_Area')->unsigned()->nullable();
            $table->foreign('id_Bloque_Area')->references('id')->on('RRHH_bloque_areas');

            $table->integer('id_CentroCosto')->unsigned()->nullable();
            $table->foreign('id_CentroCosto')->references('id')->on('RRHH_CentroCostos'); /***************ojo toca llenar el select*/

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations. dina
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('RRHH_datos_empleados');
    }
}
