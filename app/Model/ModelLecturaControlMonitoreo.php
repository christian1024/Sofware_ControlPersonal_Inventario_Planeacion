<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelLecturaControlMonitoreo extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LecturaControlMonitoreo";
    protected $fillable = [
        'CodigoBarras',
        'CodOperarioRevision',
        'IdPatinadorEntrada',
        'Flag_ActivoEntrada',
        'IdPatinadorSalida'

    ];

    public static function UltimaLecturaInicioMonitoreoProduccion($request)
    {
        //dd($request->all());
        $patinador1 = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();
        $Operario = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.Codigo_Empleado', '=',  $request['Operario'])
            ->first();
        $var =DB::table('CargueEtiquetasPros as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.CodigoBarras',$request['Barcode'])
            ->first();
        return [$Patinador,$Operario,$var];
    }
    public static function UltimaLecturaInicioMonitoreoRenewall($request)
    {
        $patinador1 = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();
        $Operario = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.Codigo_Empleado', '=',  $request['Operario'])
            ->first();
        $var =DB::table('GetEtiquetasRenewalProduncion as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoIntegracion','=','Var.Codigo')
            ->where('getEti.CodigoBarras',$request['Barcode'])
            ->first();
        return [$Patinador,$Operario,$var];
    }

    public static function UltimaLecturaSalidaMonitoreoRenewall($request)
    {
        $patinador1 = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $var =DB::table('GetEtiquetasRenewalProduncion as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoIntegracion','=','Var.Codigo')
            ->where('getEti.CodigoBarras',$request['Barcode'])
            ->first();
        return [$Patinador,$var];
    }

    public static function UltimaLecturaSalidaMonitoreoProduccion($request)
    {
        $patinador1 = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $var =DB::table('CargueEtiquetasPros as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.CodigoBarras',$request['Barcode'])
            ->first();
        return [$Patinador,$var];
    }
}
