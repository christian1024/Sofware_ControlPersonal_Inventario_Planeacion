<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ModelEntradaCuartoMonitore extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LecturaEntradaCuartoMonitoreo";
    protected $fillable = [
        'CodigoBarras',
        'IdUsers',
        'Flag_Activo',

    ];

    public static function UltimaLecturaEntradaCuartoMonitoreo($request)
    {
        //dd($request->all());
        $CodigoBarras = $request['Barcode'];
        $var =DB::table('CargueEtiquetasPros as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoVariedad','=','Var.Codigo')
            ->where('getEti.CodigoBarras', $CodigoBarras)
            ->first();
        return $var;
    }

    public static function UltimaLecturaEntradaCuartoMonitoreoR($request)
    {
        //dd($request->all());
        $CodigoBarras = $request['Barcode'];
        $var =DB::table('GetEtiquetasRenewalProduncion as getEti')
            ->select('Var.Nombre_Variedad')
            ->join('URC_Variedades as Var','getEti.CodigoIntegracion','=','Var.Codigo')
            ->where('getEti.CodigoBarras', $CodigoBarras)
            ->first();
        return $var;
    }
}
