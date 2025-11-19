<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LecturaDespunteModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaDespunte";
    protected $fillable = [

        'id_Patinador',
        'CodigoBarras',
        'CodOperario',
        'Flag_Activo',
        'SemanaLectura'

    ];

    static public function ViewDespuntes()
    {
        $date = new Carbon('yesterday');
        $date2 = Carbon::now()->format('Y-d-m H:i:s.v');
        $date3 = $date->format('Y-d-m 05:00:00.000');
        $date4 = Carbon::now()->format('d-m-Y');
        $prueba = ('2020-07-04 05:00:00.000');
        //dd($date2);
        $Despuntes = DB::table('LabLecturaDespunte as DES')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'DES.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            /* ->join('lab_infotecnica_variedades as varifo',function($join){
                 $join->on('varifo.id_Variedad', '=', 'ETI.ID_Variedad')
                      ->on('varifo.id_fase','=','ETI.ID_FaseActual');
             })*/
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantas'),
                'ETI.Indentificador',
                'FA.NombreFase as fase_Actual',
                'FA.ID',
                'ETI.SemanaDespacho',
                'ETI.SemanaIngreso',
                'ETI.ID_FaseActual',
                'ETI.ID_Variedad',
                'ETI.cliente',
                DB::raw('(SELECT NombreFase FROM tipo_fases_labs WHERE ID = (FA.id + 1)) AS SiguienteFase')
                //'varifo.CoeficienteMultiplicacion'
            ])
            ->where('DES.updated_at', '>=', $date3)
            ->where('DES.updated_at', '<=', $date2)
            ->where('DES.Flag_Activo', '=', 1)
            //->where('ETI.Indentificador', '=', 'BLL3503061201837')
            //->where('SA.updated_at', '>=', $prueba)
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'FA.ID',
                'ETI.SemanaDespacho',
                'ETI.SemanaIngreso',
                'ETI.ID_Variedad',
                'ETI.ID_FaseActual',
                'ETI.cliente'
            )
            ->orderBy(
                'ETI.Indentificador', 'ASC'
            )->orderBy(
                'fase_Actual', 'ASC'
            )
            ->get();
        //dd($Despuntes);
        return $Despuntes;
    }


}
