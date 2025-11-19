<?php

namespace App\Model;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;


class Empleados extends Model
{

    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_empleados";
    protected $fillable = [
        'id',
        'Tipo_Doc',
        'Numero_Documento',
        'Codigo_Empleado',
        'Primer_Apellido',
        'Segundo_Apellido',
        'Primer_Nombre',
        'Segundo_Nombre',
        'Genero',
        'Direccion_Residencia',
        'Telefono',
        'Barrio',
        'Rh',
        'Edad',
        'Flag_Activo',
        'departamentos_id_Expe',
        'Ciudad_id_Expedcion',
        'departamentos_id_Residencia',
        'Ciudad_id_Residencia',
        'img',
        'FechaNaciemiento'
    ];


    public  static function PatinadoresActivos()
    {
        $patinadores=  DB::table('rrhh_datos_empleados as de')
            ->select(
                'em.id',
                'em.Primer_Nombre',
                'em.Segundo_Nombre',
                'em.Primer_Apellido',
                'em.Segundo_Apellido')
            ->join('rrhh_empleados as em', 'de.id_Empleado', '=', 'em.id')
            ->where('de.id_Bloque_Area', '=', 25)
            ->where('em.Flag_Activo', '=', 1)
            ->get();

        return $patinadores;
    }

    public  static function PatinadoresActivosInver()
    {
        $patinadores=  DB::table('rrhh_datos_empleados as de')
            ->select(
                'em.id',
                'em.Primer_Nombre',
                'em.Segundo_Nombre',
                'em.Primer_Apellido',
                'em.Segundo_Apellido')
            ->join('rrhh_empleados as em', 'de.id_Empleado', '=', 'em.id')
            ->where('de.id_Bloque_Area', '=', 30)
            ->where('em.Flag_Activo', '=', 1)
            ->get();

        return $patinadores;
    }


    public static function EmpleadosLabActivos()
    {
        $EmpleadosLab=  DB::table('rrhh_datos_empleados as de')
            ->select(
                'em.id',
                'ar.area',
                'de.id_area',
                'sb.Sub_Area',
                'de.id_Sub_Area',
                'ba.bloque_area',
                'de.id_Bloque_Area',
                'em.Numero_Documento',
                'em.Codigo_Empleado',
                DB::raw('CONCAT(em.Primer_Nombre,\' \',em.Segundo_Nombre,\' \',em.Primer_Apellido,\' \',em.Segundo_Apellido) as NombreEmpleado')
                )
            ->leftjoin('rrhh_empleados as em', 'de.id_Empleado', '=', 'em.id')
            ->leftJoin('RRHH_areas as ar','ar.id','=','de.id_area')
            ->leftJoin('RRHH_sub_areas as sb','sb.id','=','de.id_Sub_Area')
            ->leftJoin('RRHH_bloque_areas as ba','ba.id','=','de.id_Bloque_Area')
            ->where('de.id_area', '=', 2)
            ->where('em.Flag_Activo', '=', 1)
            ->get();
//dd($EmpleadosLab);
        return $EmpleadosLab;
    }
    /***************************************** entreda *****************************************/
    public static function PatinadoresUltimalectura($request)
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
        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['Barcode'])
            ->first();
        return [$Patinador,$Operario,$var];
    }

    /***************************************** salida *****************************************/
    public static function SalidaCaUltimalectura($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['BarcodeC'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['BarcodeC'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    public static function SalidaXDanoMaterial($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['Barcodedm'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['Barcodedm'])
            ->first();
        return [$Patinador, $var,$operario];
    }


    public static function SAjusteinvTraslado($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['BarcodeT'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['BarcodeT'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    public static function SalidaProduccion($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['BarcodeP'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['BarcodeP'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    public static function SalidaDespacho($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=', $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['Barcoded'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['Barcoded'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    public static function RetornoInventario($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['BarcodeR'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['BarcodeR'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    public static function SalidaInvernadero($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();

        $operario= DB::table('LabLecturaEntradas as lecEn')
            ->select('emp.Primer_Nombre','emp.Segundo_Nombre','emp.Primer_Apellido','emp.Segundo_Apellido')
            ->leftJoin('RRHH_empleados as emp','emp.Codigo_Empleado','=','lecEn.CodOperario')
            ->where('lecEn.CodigoBarras',$request['BarcodeIn'])
            ->first();

        $var =DB::table('GetEtiquetasLabInventario as getEti')
            ->select('Var.Nombre_Variedad','getEti.CantContenedor')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.BarCode',$request['BarcodeIn'])
            ->first();
        return [$Patinador, $var,$operario];
    }

    /***************************************** entreda invernadero*****************************************/
    public static function PatinadoresUltimalecturaInvernadero($request)
    {
        $patinador1  = auth()->user()->id_Empleado;
        $Patinador = DB::table('rrhh_empleados as empl')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->where('empl.id', '=',  $patinador1 )
            ->first();
        $Operario = DB::table('LabLecturaEntradasInvernadero as LEctEntr')
            ->select('empl.Primer_Nombre','empl.Segundo_Nombre','empl.Primer_Apellido','empl.Segundo_Apellido')
            ->join('rrhh_empleados as empl','empl.Codigo_Empleado','=','LEctEntr.CodOperario')
            ->where('LEctEntr.CodigoBarras',$request['Barcode'])
            ->first();
        $var =DB::table('GetEtiquetasLabInventario as getE')
            ->select('Var.Nombre_Variedad','entri.Plantas')
            ->join('LabLecturaEntradasInvernadero as entri','entri.CodigoBarras','=','getE.BarCode')
            ->join('URC_Variedades as Var','Var.id','=','getE.ID_Variedad')
            ->where('getE.BarCode',$request['Barcode'])
            ->first();
        //dd($var);
        return [$Patinador,$Operario,$var];
    }



}
