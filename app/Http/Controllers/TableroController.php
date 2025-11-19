<?php

namespace App\Http\Controllers;

use App\Model\GetEtiquetasLabInventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TableroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function ProgramasPendientes()
    {
        $now = Carbon::now();
        $yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;
        $SemanaActual1 = $yearAc . '' . $SemanaAc;
        $semanaAdicional = '5';;
        $resultado = $SemanaActual1 - $semanaAdicional;

        $Programas = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    'GetEtiquetasLabInventario.CodigoVariedad,
                                URC_Variedades.Nombre_Variedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                tipo_fases_labs.NombreFase,
                                sum(GetEtiquetasLabInventario.CantContenedor)as CantidadPlantas'
                /* ,
                 CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual'*/
                )
                ])
            ->join('GetEtiquetasLabInventario', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('tipo_fases_labs', 'tipo_fases_labs.Codigo', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
            ->join('lab_cuartos as cuar', 'LabLecturaEntradas.id_Cuarto', '=', 'cuar.id')
            ->join('lab_estantes as est', 'LabLecturaEntradas.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'LabLecturaEntradas.id_piso', '=', 'nilv.id')
            ->where('LabLecturaEntradas.Flag_Activo', '=', 1)
            ->where('GetEtiquetasLabInventario.ID_FaseActual', '>=', 6)
            ->where('GetEtiquetasLabInventario.SemanUltimoMovimiento', '<=', $resultado)
            ->groupBy(
                [DB::raw('GetEtiquetasLabInventario.CodigoVariedad,
                                URC_Variedades.Nombre_Variedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                tipo_fases_labs.NombreFase,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento'
                /*, cuar.N_Cuarto,
                 est.N_Estante,
                 nilv.N_Nivel'*/)])
            ->get();
        //dd($Programas);
        return view('Laboratorio.ProgramasPendientes', compact('Programas'));

    }

    public function ProgramasEjecutados()
    {
        $ProgramasEjecutadosSalidasWeekPA = GetEtiquetasLabInventario::ProgramasEjecutadosSalidasWeekPA();
        $ProgramasEjecutadosEntradasWeekPA = GetEtiquetasLabInventario::ProgramasEjecutadosEntradasWeekPA();
        $ProgramasEjecutadosSalidasWeekAC = GetEtiquetasLabInventario::ProgramasEjecutadosSalidasWeekAC();
        $ProgramasEjecutadosEntradasWeekAC = GetEtiquetasLabInventario::ProgramasEjecutadosEntradasWeekAC();

        return view('Laboratorio.programasEjecutados',
            compact('ProgramasEjecutadosSalidasWeekPA',
                'ProgramasEjecutadosEntradasWeekPA',
                'ProgramasEjecutadosSalidasWeekAC',
                'ProgramasEjecutadosEntradasWeekAC'));
    }
}
