<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FichaTecnicaEmpleados extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_datos_empleados";
    protected $fillable = [
        'id_Empleado'
        ,'Fecha_Ingreso'
        ,'Salario'
        ,'Fecha_retiro'
        ,'Frecuencia'
        ,'Ultima_Fecha_Ingreso'
        ,'Fecha_Cambio_Contrato'
        ,'Tipo_Vivienda'

        ,'Codigo_Pension'
        ,'Cesantias'
        ,'id_CajaCompensacion'
        ,'Codigo_Compensacion'
        ,'Auxilio_Transporte'
        ,'Numero_Cuenta'
        ,'Formacion'
        ,'Numero_Hijos'
        ,'Talla_Chaqueta'
        ,'Talla_Pantalon'
        ,'Talla_overol'
        ,'Numero_Calzado'
        ,'personas_cargo'
        ,'peso'
        ,'estatura'
        ,'enfermedad_laboral'
        ,'Carnet'
        ,'Numero_Botas_Caucho'
        ,'Raza'
        ,'Estrato_Social'
        ,'Enfermedad_Comun'
        ,'At_Level'
        ,'At_Grave'
        ,'Intervencion_Xat'
        ,'Comida_Dia'
        ,'Vegetales'
        ,'Carbohidratos'
        ,'Hidratacion'
        ,'cumple_horario_comidas'
        ,'Deporte'
        ,'Hobbies'
        ,'sustancias_psicoactivas'
        ,'fuma'
        ,'consume_alcohol'
        ,'restriccion'
        ,'motivo_retiro'
        ,'lavado_manos'

        ,'Nivel_Sisben'
        ,'Rodamiento'
        ,'id_arl'
        ,'id_Estado_Civil'
        ,'id_Medio_Transporte'
        ,'id_Cargo'
        ,'id_tipocontratos'
        ,'id_area'
        ,'id_Sub_Area'
        ,'id_Bloque_Area'
        ,'id_CentroCosto'
        ,'id_Pension'
        ,'created_at'
        ,'updated_at'
    ];

    public static function FichaTecnicaEmpleados($id)
    {
        $datos = DB::table('RRHH_datos_empleados as dt')
            ->leftJoin('RRHH_sub_areas as sa','sa.id','=','dt.id_Sub_Area')
            ->leftJoin('RRHH_bloque_areas as ba','ba.id','=','dt.id_Bloque_Area')
            ->select(
                'id_Empleado'
                ,'Fecha_Ingreso'
                ,'Salario'
                ,'Fecha_retiro'
                ,'Frecuencia'
                ,'Ultima_Fecha_Ingreso'
                ,'Fecha_Cambio_Contrato'
                ,'Tipo_Vivienda'
                ,'id_Pension'
                ,'Cesantias'
                ,'id_CajaCompensacion'
                ,'Auxilio_Transporte'
                ,'Numero_Cuenta'
                ,'Formacion'
                ,'Numero_Hijos'
                ,'Talla_Chaqueta'
                ,'Talla_Pantalon'
                ,'Talla_overol'
                ,'Numero_Calzado'
                ,'personas_cargo'
                ,'peso'
                ,'estatura'
                ,'enfermedad_laboral'
                ,'Carnet'
                ,'Numero_Botas_Caucho'
                ,'Raza'
                ,'Estrato_Social'
                ,'Enfermedad_Comun'
                ,'At_Level'
                ,'At_Grave'
                ,'Intervencion_Xat'
                ,'Comida_Dia'
                ,'Vegetales'
                ,'Carbohidratos'
                ,'Hidratacion'
                ,'cumple_horario_comidas'
                ,'Deporte'
                ,'Hobbies'
                ,'sustancias_psicoactivas'
                ,'fuma'
                ,'consume_alcohol'
                ,'restriccion'
                ,'motivo_retiro'
                ,'lavado_manos'
                ,'Nivel_Sisben'
                ,'Rodamiento'
                ,'id_arl'
                ,'id_Estado_Civil'
                ,'id_Medio_Transporte'
                ,'id_Cargo'
                ,'id_tipocontratos'
                ,'dt.id_area'
                ,'sa.Sub_Area'
                ,'dt.id_Sub_Area'
                ,'ba.bloque_area'
                ,'dt.id_Bloque_Area'
                ,'id_CentroCosto'
            )
            ->where('id_Empleado',$id)
            ->first();

        return $datos;


    }

}
