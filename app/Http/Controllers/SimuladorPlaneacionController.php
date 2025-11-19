<?php

namespace App\Http\Controllers;

use App\Model\ClientesLab;
use App\Model\GetEtiquetasLabInventario;
use App\Model\labCabezaPedidos;
use App\Model\labdetallesPedidos;
use App\Model\LabInfotecnicaVariedades;
use App\Model\ModelAnoSemana;
use App\Model\ModelCalculoSemanasPlaneacion;
use App\Model\Variedades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimuladorPlaneacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function SimuladorView()
    {
        $Variedades = Variedades::VariedadesExistenteslab();

        return view('Ventas.SimuladorPlaneacion', compact('Variedades'));
    }

    public function ConsultaIntroduccionesFactor(Request $request)
    {
        //dd($request->all());
        $informacionTecnicaM = LabInfotecnicaVariedades::query()
            ->select(['CoeficienteMultiplicacion'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $request->get('IdVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 6)
            ->first();

        $GermosyStock = GetEtiquetasLabInventario::query()
            ->select([
                'Indentificador',
                'SemanUltimoMovimiento',
                'NombreFase',
                DB::raw('sum(CantContenedor) as CantPlantas')
            ])
            ->join('LabLecturaEntradas as ent', 'ent.CodigoBarras', '=', 'BarCode')
            ->join('tipo_fases_labs as fas', 'fas.id', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
            ->where('ID_Variedad', $request->get('IdVariedad'))
            ->where('ent.Flag_Activo', 1)
            ->wherein('ID_FaseActual', [4, 5])
            ->groupBy('Indentificador', 'SemanUltimoMovimiento', 'NombreFase')
            ->get();

        return response()->json([
            'factor' => $informacionTecnicaM,
            'identificadores' => $GermosyStock,
            'data' => 1,
        ]);

    }

    public function CalcularSimulacionPedido(Request $request)
    {
        $informacionTecnicaM = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $request->get('IdVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 6)
            ->first();
        $informacionTecnicaE = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $request->get('IdVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 7)
            ->first();
        $informacionTecnicaA = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $request->get('IdVariedad'))
            ->where('lab_infotecnica_variedades.id_fase', 8)
            ->first();

        $SemanaInicialCalculo = $request->get('SemanaInicio');
        $CantidadInicialCalculo = $request->get('CantPLantas');
        $FactorMultiplicacion = $request->get('Factor');
        $CantidadSolicitada = $request->get('CantidadSolicitada');
        $semanaIC = explode('-W', $SemanaInicialCalculo);
        $yearActual = $semanaIC[0];
        $weekPlaning = $semanaIC[1];
        $semanaInicioPlaneacion = $yearActual . '' . $weekPlaning;
        $vecesCiclo = 0;

        $CantidadSolicitadaEnraizamiento = $CantidadSolicitada * $informacionTecnicaE->PorcentajePerdidaFase;//asegurar enraizamiento
        $CantidadSolicitadaAdaptada = $CantidadSolicitada * $informacionTecnicaA->PorcentajePerdidaFase;//asegurar Adaptación*/
        $resul = $CantidadInicialCalculo;

        if ($request->get('tpFase') === 1 || $request->get('tpFase') === '1') {
            $vecesCiclo = 1;
            for ($i = 0; $resul < $CantidadSolicitadaEnraizamiento; $i++) {
                $array = [ceil($resul)];
                $resul = $resul * $FactorMultiplicacion;
                $vecesCiclo++;
            }
        } else {
            //dd('stock');
            for ($i = 0; $resul < $CantidadSolicitadaEnraizamiento; $i++) {
                $array = [ceil($resul)];
                $resul = $resul * $FactorMultiplicacion;
                $vecesCiclo++;
            }
        }

        $semanaActuales = ModelAnoSemana::query()
            ->select('AnoYSemana',
                DB::raw('Row_Number() Over (Order By AnoYSemana) As Consecutivo'))
            ->where('AnoYSemana', '>=', $semanaInicioPlaneacion)
            ->groupBy('AnoYSemana')
            ->get();

        ModelCalculoSemanasPlaneacion::query()->truncate();
        foreach ($semanaActuales as $semanaActual) {
            ModelCalculoSemanasPlaneacion::query()->create([
                'AnoYSemana' => $semanaActual->AnoYSemana,
                'Consecutivo' => $semanaActual->Consecutivo,
            ]);
        }

        $CantidadSemanasMultiplicacion = ($vecesCiclo-1) * $informacionTecnicaM->SemanasXFase;

        $unoantes = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana')
            ->where('Consecutivo',$CantidadSemanasMultiplicacion+1)
            ->first();
        $weekFinalMultiplicacion = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana','Consecutivo')
            ->where('Consecutivo',($CantidadSemanasMultiplicacion+1)+ $informacionTecnicaM->SemanasXFase)
            ->first();
        $weekFinalEnraizamiento = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana','Consecutivo')
            ->where('Consecutivo',$weekFinalMultiplicacion->Consecutivo + $informacionTecnicaM->SemanasXFase)
            ->first();
        $weekFinalAdaptacion = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana','Consecutivo')
            ->where('Consecutivo',$weekFinalEnraizamiento->Consecutivo + $informacionTecnicaE->SemanasXFase)
            ->first();

        $weekDespacho = ModelCalculoSemanasPlaneacion::query()
            ->select('AnoYSemana','Consecutivo')
            ->where('Consecutivo',$weekFinalAdaptacion->Consecutivo+$informacionTecnicaA->SemanasXFase)
            ->first();

        return response()->json([
            'SemanaMultiplicacion' => $weekFinalMultiplicacion->AnoYSemana,
            'SemanaMultiplicacionAntes' => $unoantes->AnoYSemana,
            'CantidadPlantasMultiplicacion' => $array,
            'CantidadPlantasMultiplicacionM' => ceil($resul),
            'SemanaEnraizamiento' => $weekFinalEnraizamiento->AnoYSemana,
            'PlanttasEnreiazar' => ceil($CantidadSolicitadaEnraizamiento),
            'SemanaAdaptacion' => $weekFinalAdaptacion->AnoYSemana,
            'CantidadAdaptacion' => ceil($CantidadSolicitadaAdaptada),
            'SEmanaDespacho' => $weekDespacho->AnoYSemana,
            'data' => 1,
        ]);
    }

    public function ProyeccionRegresion(Request $request)
    {
        // dd($request->all());
        $tipoentrega = $request->get('TpentregaR');
        $Factor = $request->get('FactorR');
        $IdVariedad = $request->get('IdVariedadR');
        $SemanaDespachoR = $request->get('SemanaDespachoR');
        $CantidadDespacharR = $request->get('CantidadDespacharR');
        $semanaP = explode('-W', $SemanaDespachoR);
        //dd($semanaP);
        $dato1 = $semanaP[0];
        $dato2 = $semanaP[1];
        $SemanaDespachoCliente = $dato1 . '' . $dato2;


        $informacionTecnicaM = LabInfotecnicaVariedades::query()
            ->select(['CoeficienteMultiplicacion', 'SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $IdVariedad)
            ->where('lab_infotecnica_variedades.id_fase', 6)
            ->first();

        $informacionTecnicaE = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $IdVariedad)
            ->where('lab_infotecnica_variedades.id_fase', 7)
            ->first();

        $informacionTecnicaA = LabInfotecnicaVariedades::query()
            ->select(['SemanasXFase', 'PorcentajePerdidaFase'])
            ->join('URC_Variedades as vari', 'vari.id', '=', 'lab_infotecnica_variedades.id_Variedad')
            ->where('vari.id', $IdVariedad)
            ->where('lab_infotecnica_variedades.id_fase', 8)
            ->first();

        $NumeroDeSemanasMultiplicacion = $informacionTecnicaM->SemanasXFase;

        if ($tipoentrega === '2' || $tipoentrega === 2) {
            $semanaadaptacion = $SemanaDespachoCliente - $informacionTecnicaA->SemanasXFase;
        } else {
            $semanaadaptacion = $SemanaDespachoCliente;
        }
        $date = Carbon::now();
        $year = $date->format('Y');
        /*un año adicional*/
        $date1 = Carbon::now();
        $endDate1 = $date1->addYear();
        $year1 = $date1->format('Y');
        /*dos años adicionales*/
        $date2 = Carbon::now();
        $endDate2 = $date2->addYears(2);
        $year2 = $endDate2->format('Y');
        /*tres años adicionales*/
        $date3 = Carbon::now();
        $endDate3 = $date3->addYears(3);
        $year3 = $endDate3->format('Y');
        /*cuatro años adicionales*/
        $date4 = Carbon::now();
        $endDate4 = $date4->addYears(4);
        $year4 = $endDate4->format('Y');

        $weekFinal = Carbon::parse('29-12-' . $year)->week();
        $weekFinal1 = Carbon::parse('29-12-' . $year1)->week();
        $weekFinal2 = Carbon::parse('29-12-' . $year2)->week();
        $weekFinal3 = Carbon::parse('29-12-' . $year3)->week();
        $weekFinal4 = Carbon::parse('29-12-' . $year4)->week();

        $Inicial = substr($semanaadaptacion, 0, 4);
        $ultimo = substr($semanaadaptacion, -2);

        if ($Inicial === $year && $ultimo > $weekFinal) {
            $semanaRela = 100 - $ultimo;
            $weekFinal = $weekFinal - $semanaRela;
            $SemanaPlaneacion = $year . '' . $weekFinal;
            $semanaadaptacion = $SemanaPlaneacion;
        }

        if ($Inicial === $year1 && $ultimo > $weekFinal1) {
            $semanaRela = 100 - $ultimo;
            $weekFinal1 = $weekFinal1 - $semanaRela;
            $SemanaPlaneacion = $year1 . '' . $weekFinal1;
            $semanaadaptacion = $SemanaPlaneacion;
        }
        if ($Inicial === $year2 && $ultimo > $weekFinal2) {
            $semanaRela = 100 - $ultimo;
            $weekFinal2 = $weekFinal2 - $semanaRela;
            $SemanaPlaneacion = $year2 . '' . $weekFinal2;
            $semanaadaptacion = $SemanaPlaneacion;
        }

        if ($Inicial === $year3 && $ultimo > $weekFinal3) {
            $semanaRela = 100 - $ultimo;
            $weekFinal3 = $weekFinal3 - $semanaRela;
            $SemanaPlaneacion = $year3 . '' . $weekFinal3;
            $semanaadaptacion = $SemanaPlaneacion;


        }
        if ($Inicial === $year4 && $ultimo > $weekFinal4) {
            $semanaRela = 100 - $ultimo;
            $weekFinal4 = $weekFinal4 - $semanaRela;
            $SemanaPlaneacion = $year4 . '' . $weekFinal4;
            $semanaadaptacion = $SemanaPlaneacion;
        }
        $semanaEnraizar = $semanaadaptacion - $informacionTecnicaE->SemanasXFase;

        //dd($semanaEnraizar);
        $Inicial2 = substr($semanaEnraizar, 0, 4);
        $ultimo2 = substr($semanaEnraizar, -2);

        if ($Inicial2 === $year && $ultimo2 > $weekFinal) {
            $semanaRela = 100 - $ultimo2;
            $weekFinal = $weekFinal - $semanaRela;
            $SemanaPlaneacion = $year . '' . $weekFinal;
            $semanaEnraizar = $SemanaPlaneacion;

        }

        if ($Inicial2 === $year1 && $ultimo2 > $weekFinal1) {
            $semanaRela = 100 - $ultimo2;
            $weekFinal1 = $weekFinal1 - $semanaRela;
            $SemanaPlaneacion = $year1 . '' . $weekFinal1;
            $semanaEnraizar = $SemanaPlaneacion;
        }
        if ($Inicial2 === $year2 && $ultimo2 > $weekFinal2) {
            $semanaRela = 100 - $ultimo2;
            $weekFinal2 = $weekFinal2 - $semanaRela;
            $SemanaPlaneacion = $year2 . '' . $weekFinal2;
            $semanaEnraizar = $SemanaPlaneacion;
        }

        if ($Inicial2 === $year3 && $ultimo2 > $weekFinal3) {
            $semanaRela = 100 - $ultimo2;
            $weekFinal3 = $weekFinal3 - $semanaRela;
            $SemanaPlaneacion = $year3 . '' . $weekFinal3;
            $semanaEnraizar = $SemanaPlaneacion;
        }
        if ($Inicial2 === $year4 && $ultimo2 > $weekFinal4) {
            $semanaRela = 100 - $ultimo2;
            $weekFinal4 = $weekFinal4 - $semanaRela;
            $SemanaPlaneacion = $year4 . '' . $weekFinal4;
            $semanaEnraizar = $SemanaPlaneacion;
        }


        $dateA = $date = new Carbon('next monday');
        $year = $dateA->format('Y');
        $Day = $dateA->week();

        if (strlen($Day) === 1) {
            $Day = '0' . $Day;
        }
        $SemanaFinal = $year . '' . $Day;

        $calculoMultiplicacion = $semanaEnraizar;
        $semanaigual = $calculoMultiplicacion;
        $CantidadSolicitadaEnraizamiento = $CantidadDespacharR * $informacionTecnicaE->PorcentajePerdidaFase;//asegurar enraizamiento
        $resultadoPLantas = $CantidadSolicitadaEnraizamiento;


        //dd($semanaadaptacion,$semanaEnraizar);

        while ($semanaigual >= $SemanaFinal) {
            //dd('entro');
            //$array = array('Semana' => $semanaadaptacion, 'Plantas' => $resultadoPLantas);
            $array = array('Semana' => $semanaigual, 'Plantas' => $resultadoPLantas);
            // print_r($array);
            $CantidadSolicitadaEnraizamiento = $CantidadSolicitadaEnraizamiento / $Factor;
            $resultadoPLantas = ceil($CantidadSolicitadaEnraizamiento);
            $calculoMultiplicacion = $calculoMultiplicacion - $NumeroDeSemanasMultiplicacion;
            $semanaigual = $calculoMultiplicacion;
            $Inicial = substr($semanaigual, 0, 4);
            $ultimo = substr($semanaigual, -2);
            if ($Inicial === $year && $ultimo > $weekFinal) {
                $semanaRela = 100 - $ultimo;
                $weekFinal = $weekFinal - $semanaRela;
                $calculoMultiplicacion = $year . '' . $weekFinal;
                $semanaigual = $calculoMultiplicacion;
            }

            if ($Inicial === $year1 && $ultimo > $weekFinal1) {
                $semanaRela = 100 - $ultimo;
                $weekFinal1 = $weekFinal1 - $semanaRela;
                $calculoMultiplicacion = $year1 . '' . $weekFinal1;
                $semanaigual = $calculoMultiplicacion;
            }
            if ($Inicial === $year2 && $ultimo > $weekFinal2) {
                $semanaRela = 100 - $ultimo;
                $weekFinal2 = $weekFinal2 - $semanaRela;
                $calculoMultiplicacion = $year2 . '' . $weekFinal2;
                $semanaigual = $calculoMultiplicacion;
            }

            if ($Inicial === $year3 && $ultimo > $weekFinal3) {
                $semanaRela = 100 - $ultimo;
                $weekFinal3 = $weekFinal3 - $semanaRela;
                $calculoMultiplicacion = $year3 . '' . $weekFinal3;
                $semanaigual = $calculoMultiplicacion;
            }
            if ($Inicial === $year4 && $ultimo > $weekFinal4) {
                $semanaRela = 100 - $ultimo;
                $weekFinal4 = $weekFinal4 - $semanaRela;
                $calculoMultiplicacion = $year4 . '' . $weekFinal4;
                $semanaigual = $calculoMultiplicacion;
            }


            $validandoSEmana = $array['Semana'];
            $ano = substr($semanaigual, 0, 4);
            $semana = substr($semanaigual, -2);

            if ($semana === '00' || $semana === 00) {
                $ano = $ano - 1;
                if ($ano == $year) {
                    $calculoMultiplicacion = $year . '' . $weekFinal;
                    $semanaigual = $calculoMultiplicacion;
                }
                if ($ano == $year1) {
                    $calculoMultiplicacion = $year1 . '' . $weekFinal1;
                    $semanaigual = $calculoMultiplicacion;
                }
                if ($ano == $year2) {
                    $calculoMultiplicacion = $year2 . '' . $weekFinal2;
                    $semanaigual = $calculoMultiplicacion;
                }
                if ($ano == $year3) {
                    $calculoMultiplicacion = $year3 . '' . $weekFinal3;
                    $semanaigual = $calculoMultiplicacion;
                }
                if ($ano == $year4) {
                    $calculoMultiplicacion = $year4 . '' . $weekFinal4;
                    $semanaigual = $calculoMultiplicacion;
                }

            }
        }
        $CantidadSolicitadaAdaptada = $CantidadDespacharR * $informacionTecnicaA->PorcentajePerdidaFase;//asegurar Adaptación*/
        $CantidadSolicitadaEnraizamiento = $CantidadDespacharR * $informacionTecnicaE->PorcentajePerdidaFase;//asegurar enraizamiento

        return response()->json([
            'SemanaMultiplicacion' => $array['Semana'],
            'CantidadMultplicar' => ceil($array['Plantas']),
            'SemanaEnraizamiento' => $semanaEnraizar,
            'PlanttasEnreiazar' => ceil($CantidadSolicitadaEnraizamiento),
            'SemanaAdaptacion' => $semanaadaptacion,
            'CantidadAdaptacion' => ceil($CantidadSolicitadaAdaptada),
            'data' => 1,
        ]);

    }
}
