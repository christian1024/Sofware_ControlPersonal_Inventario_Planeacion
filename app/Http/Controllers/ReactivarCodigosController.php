<?php

namespace App\Http\Controllers;

use App\Model\LabLecturaSalida;
use App\Model\Variedades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReactivarCodigosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function VistaReactivarProgramas()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        return view('Laboratorio.ReActivacionProgramas', compact('VariedadesActivas'));
    }

    public function DetallesProgramasReactivar(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            //$datoEntrada = $request->get('SemanIntro');
            $IdVariedad = $request->get('idVariedad');
            $Fase = $request->get('FaseActual');
            $FechaInicial = Carbon::parse($request->get('FechaIncial'))->format('Y-d-m');
            $FechaFinal = Carbon::parse($request->get('FechaFinal'))->format('Y-d-m');

            //dd($FechaInicial, $FechaFinal);
            /*
                        $semanaC = explode('-W', $datoEntrada);
                        //dd($semanaP);
                        $dato1 = $semanaC[0];
                        $dato2 = $semanaC[1];
                        $SemanaFi = $dato1 . '' . $dato2;*/

            $DetallesPrograma = DB::table('GetEtiquetasLabInventario')
                ->select(
                    [DB::raw(
                        'GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                sum(GetEtiquetasLabInventario.CantContenedor)as CantidadPlantas,
                                GetEtiquetasLabInventario.ID_FaseActual'
                    )
                    ])
                ->join('LabLecturaSalidas', 'LabLecturaSalidas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
                ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
                ->where('GetEtiquetasLabInventario.ID_variedad', $IdVariedad)/*
                ->where('GetEtiquetasLabInventario.SemanaIngreso', $SemanaFi)*/
                ->where('GetEtiquetasLabInventario.ID_FaseActual', $Fase)
                ->where('LabLecturaSalidas.Flag_Activo', '=', 1)
                ->where('LabLecturaSalidas.id_TipoSalida', '=', 8)
                ->whereBetween('LabLecturaSalidas.updated_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
                ->groupBy(
                    [DB::raw('GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                GetEtiquetasLabInventario.ID_FaseActual')])
                ->get();

            // dd($DetallesPrograma);
            return response()->json([
                'Data' => $DetallesPrograma,
            ]);
        }
    }

    public function DetallesTableProgramasReactivar(Request $request)
    {
        //dd($request->all());
        $FechaInicial = Carbon::parse($request->get('FechaIncial'))->format('Y-d-m');
        $FechaFinal = Carbon::parse($request->get('FechaFinal'))->format('Y-d-m');
        if ($request->ajax()) {
            $datoEntrada = $request->get('valor');
            $DatoCompleto = explode(',', $datoEntrada);
            //dd($DatoCompleto);
            $dato1 = $DatoCompleto[0];
            $dato2 = $DatoCompleto[1];
            $dato3 = $DatoCompleto[2];
            $dato4 = $DatoCompleto[3];
            $dato5 = $DatoCompleto[4];
            //dd($dato3);
            if ($dato3 === '' || $dato3 === null || empty($dato3) || $dato3 === NULL || is_null($dato3) || $dato3==='null') {
                $dato3=null;
            }


            $DetallesPrograma = DB::table('GetEtiquetasLabInventario')
                ->select(
                    [DB::raw(
                        'GetEtiquetasLabInventario.Indentificador,
                            GetEtiquetasLabInventario.BarCode,
                            GetEtiquetasLabInventario.TipoContenedor,
                            GetEtiquetasLabInventario.Cliente,
                            GetEtiquetasLabInventario.SemanUltimoMovimiento,
                            GetEtiquetasLabInventario.SemanaDespacho,
                            tipo_fases_labs.NombreFase'
                    )
                    ])
                ->join('LabLecturaSalidas', 'LabLecturaSalidas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
                ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
                ->where('GetEtiquetasLabInventario.CodigoVariedad', $dato1)
                ->where('GetEtiquetasLabInventario.Indentificador', $dato2)
                ->where('GetEtiquetasLabInventario.SemanaDespacho', $dato3)
                ->where('GetEtiquetasLabInventario.SemanUltimoMovimiento', $dato4)
                ->where('GetEtiquetasLabInventario.ID_FaseActual', '=', $dato5)
                ->where('LabLecturaSalidas.Flag_Activo', '=', 1)
                ->where('LabLecturaSalidas.id_TipoSalida', '=', 8)
                ->whereBetween('LabLecturaSalidas.updated_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
                ->get();

            //dd($DetallesPrograma);
            return response()->json([
                'Data' => $DetallesPrograma,
            ]);
        }
    }

    public function ActivarCodigo(Request $request)
    {
        $Hoy = Carbon::now()->format('Y-d-m');
        $array = $request['CheckedAK'];
        for ($i = 0; $i < count($array); $i++) {
            $update = LabLecturaSalida::query()
                ->where('CodigoBarras', $array[$i])
                ->update([
                    'FlagActivo_CambioFase' => NULL,
                    'updated_at' => $Hoy . ' 05:00:00.000',
                ]);
        }
        return response()->json([
            'data' => 1,
        ]);

    }
}
