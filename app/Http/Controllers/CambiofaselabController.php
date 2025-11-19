<?php

namespace App\Http\Controllers;

use App\LabCambioFases;
use App\Model\ClientesLab;
use App\Model\LabCambioFaseCh;
use App\Model\LabInfotecicaTiposFrascos;
use App\Model\LabLecturaSalida;
use App\Model\LecturaDespunteModel;
use App\Model\ModelAnoSemana;
use App\Model\ModelResultadoMuestrasFitopatologia;
use App\Model\TipoFasesLab;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CambiofaselabController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function MovimientoFasesLabView()
    {

        //dd('aqui');

        $clientes = ClientesLab::clientesActivos();
          $FasesLab = TipoFasesLab::all()
              ->whereIn('id', [2, 3, 4, 5, 6, 7, 8]);
        $introducciones = LabCambioFaseCh::ViewP();
        $despuntes = LecturaDespunteModel::ViewDespuntes();


        return view('Laboratorio.Movimientofaselabview', compact('introducciones', 'clientes','FasesLab', 'despuntes'));
    }

    public function DetallesIntroduccion(Request $request)
    {
        //dd($request->all());
        $date = new Carbon('yesterday');
        $date2 = $date->format('Y-d-m 05:00:00.000');
        $semanaDespacho = $request->get('SemanaDespacho');
        $cliente = $request->get('cliente');


        if (empty($semanaDespacho)) {
            $semanaDespacho = null;
        }
        if (empty($cliente)) {
            $cliente = null;
        }

        $DetallesIntroduccion = DB::table('LabLecturaSalidas as SA')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'SA.CodigoBarras')
            ->join('URC_Variedades as varr', 'varr.Codigo', '=', 'ETI.CodigoVariedad')
            ->select([
                'SA.CodigoBarras',
                'varr.Nombre_Variedad',
                'ETI.TipoContenedor',
                'ETI.SemanaDespacho',
                'ETI.CantContenedor',
                'ETI.Cliente',
            ])
            ->where('ETI.Indentificador', '=', $request->get('valor'))
            ->where('ETI.ID_FaseActual', '=', $request->get('fase'))
            ->where('ETI.SemanaDespacho', '=', $semanaDespacho)
            ->where('ETI.cliente', '=', $cliente)
            ->where('SA.id_TipoSalida', '=', 8)
            ->where('SA.Flag_Activo', '=', 1)
            ->whereNull('SA.FlagActivo_CambioFase')
            ->where('SA.updated_at', '>=', $date2)
            ->get();
        //dd($DetallesIntroduccion);
        return response()->json([
            'datos' => $DetallesIntroduccion,
        ]);
        //dd($DetallesIntroduccion);
    }

    public function CambiarFaseLabChr(Request $request)
    {
        //dd($request->all());
        $now = Carbon::now();
        /*$yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;
        $SemanaActual = $yearAc . '' . $SemanaAc;*/
        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

        $Var = $request->get('ID_VariedadC');
        $FaseActual = $request->get('ID_FaseActualC');
        $FaseNueva = $request->get('idFaseN');
        $ProgamasAdiconales = $request->get('radio');
        $semdespacho = $request->get('SemDespacho');
        $semdespacho1 = $request->get('SemDespacho1');
        $semdespacho2 = $request->get('SemDespacho2');
        $semdespacho3 = $request->get('SemDespacho3');
        $SemanaDespacho = '';
        $Cliente1 = '';
        $ClienteAd1 = '';
        $ClienteAd2 = '';
        $ClienteAd3 = '';
        $SemanaDespachoAd = '';
        $SemanaDespachoAd1 = '';
        $SemanaDespachoAd2 = '';
        $SemanaDespachoAd3 = '';


        if (empty($semdespacho)) {
            $SemanaDespachoAd = null;
        } else {
            $semanaP = explode('-W', $semdespacho);
            //dd($semanaP);
            $dato1 = $semanaP[0];
            $dato2 = $semanaP[1];
            $SemanaDespachoAd = $dato1 . '' . $dato2;
        }
        if (empty($semdespacho1)) {
            $SemanaDespachoAd1 = null;
        } else {
            $semanaP = explode('-W', $semdespacho1);
            //dd($semanaP);
            $dato1 = $semanaP[0];
            $dato2 = $semanaP[1];
            $SemanaDespachoAd1 = $dato1 . '' . $dato2;
        }
        if (empty($semdespacho2)) {
            $SemanaDespachoAd2 = null;
        } else {
            $semanaP = explode('-W', $semdespacho2);
            //dd($semanaP);
            $dato1 = $semanaP[0];
            $dato2 = $semanaP[1];
            $SemanaDespachoAd2 = $dato1 . '' . $dato2;
        }
        if (empty($semdespacho3)) {
            $SemanaDespachoAd3 = null;
        } else {
            $semanaP = explode('-W', $semdespacho3);
            //dd($semanaP);
            $dato1 = $semanaP[0];
            $dato2 = $semanaP[1];
            $SemanaDespachoAd3 = $dato1 . '' . $dato2;
        }
        if (empty($request->get('Cliente'))) {
            $Cliente1 = null;
        } else {
            $Cliente1 = $request->get('Cliente');
        }
        if (empty($request->get('Cliente1'))) {
            $ClienteAd1 = null;
        } else {
            $ClienteAd1 = $request->get('Cliente1');
        }
        if (empty($request->get('Cliente2'))) {
            $ClienteAd2 = null;
        } else {
            $ClienteAd2 = $request->get('Cliente2');
        }
        if (empty($request->get('Cliente3'))) {
            $ClienteAd3 = null;
        } else {
            $ClienteAd3 = $request->get('Cliente3');
        }

//dd($semdespacho1);
        $tipoFras = DB::table('lab_infotecica_tipos_frascos as tp')
            ->join('tipo_Contenedores_labs as tc', 'tc.id', 'tp.id_tipofrasco')
            ->select('tc.TipoContenedor')
            ->where('tp.id_Variedad', $Var)
            ->where('tp.id_fase', $FaseActual)
            ->first();

        /********************** CAMBIO FASE GERMOPLASMA *********************************/

        if ($FaseActual === '4' && $FaseNueva === '4' && $ProgamasAdiconales > '0') {
            return $this->GermoAGermoConprogramaConAdicional($tipoFras, $request->all(), $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '4' && $FaseNueva > '4' && $ProgamasAdiconales > '0') {
            return $this->GermoMayorGermoConprogramaConAdicional($tipoFras, $request->all(), $SemanaDespachoAd, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '4' && $FaseNueva === '4') {

            return $this->GermoAGermoSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '4' && $FaseNueva > '4') {
            return $this->GermoAGermoConprogramaSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana, $SemanaDespachoAd, $Cliente1);
        }

        /********************** CAMBIO FASE STOCK *********************************/

        if ($FaseActual === '5' && $FaseNueva === '4' && $ProgamasAdiconales > '0') {
            return $this->StockASGermoConprogramaConAdicional($tipoFras, $request->all(), $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '5' && $FaseNueva === '5' && $ProgamasAdiconales > '0') {
            return $this->StockAStockConprogramaConAdicional($tipoFras, $request->all(), $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '5' && $FaseNueva > '5' && $ProgamasAdiconales > '0') {
            return $this->StockmayorStockConprogramaConAdicional($tipoFras, $request->all(), $SemanaDespachoAd, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '5' && $FaseNueva === '5') {

            return $this->StockAStockSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '5' && $FaseNueva === '4') {

            return $this->StockAGErmoSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '5' && $FaseNueva > '5') {
            return $this->StockAStockConprogramaSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana, $SemanaDespachoAd, $Cliente1);
        }

        /********************** CAMBIO FASE MULTIPLICACION ********************************/

        if ($FaseActual === '6' && $FaseNueva >= '6' && $ProgamasAdiconales > '0') {
            //dd($request->all());
            return $this->MultiplicacionAMayorIgualMultiplicacionConprogramasAdicionales($tipoFras, $request->all(), $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '6' && $FaseNueva <= '5' && $ProgamasAdiconales > '0') {
            return $this->MultiplicacionAMenorIgualStockConprogramasAdicionales($tipoFras, $request->all(), $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '6' && $FaseNueva > '5') {
            //dd($request->all());
            return $this->MultiplicacionAMayorMultiplicacion($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '6' && $FaseNueva <= '5') {
            return $this->MultiplicacionAMenorMultiplicacion($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        /********************** CAMBIO FASE ENRAIZAMIENTO ********************************/

        if ($FaseActual === '7' && $FaseNueva >= '6' && $ProgamasAdiconales > '0') {
            return $this->EnraizamientoAMayorMutiplicacionConAdicional($tipoFras, $request->all(), $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '7' && $FaseNueva <= '5' && $ProgamasAdiconales > '0') {
            return $this->EnraizamientoAManorMutiplicacionConAdicional($tipoFras, $request->all(), $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual === '7' && $FaseNueva >= '6') {
            return $this->EnraizamientoAMayorMutiplicacionSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '7' && $FaseNueva <= '5') {
            return $this->EnraizamientoAMenorMutiplicacionSinAdicional($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        /********************** CAMBIO FASE INTRODUCCION HASTA GERMO ********************************/

        if ($FaseActual <= '3' && $FaseNueva <= '5' && $ProgamasAdiconales > '0') {
            //dd('if uno');
            return $this->SeguntaTransConAdicionales($tipoFras, $request->all(), $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaEjecucion->AnoYSemana, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3);
        }

        if ($FaseActual <= '3' && $FaseNueva <= '5') {
            //dd('if dos');
            return $this->IntroGermo($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual <= '3' && $FaseNueva === '11') {
            //dd('if dos');
            return $this->TranferenciasAMuestra($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        /********************** CAMBIO FASE DE MUESTRA A MUESTRA O GERMO  ****************************/
        if ($FaseActual === '11' && $FaseNueva === '11') {
            //dd('if dos');
            return $this->MuestraAMuestra($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        if ($FaseActual === '11' && $FaseNueva === '4') {
            //dd('if dos');
            return $this->MuestraAGermo($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        /********************** CAMBIO FASE DE AGRO RHODO *****************************************/
        if ($FaseActual === '12' && $FaseNueva > '5') {
            if ($request->get('SemanaDespachoC') === null) {
                return $this->AgroRhodoAMayorIgualMultiplicacionSinPrograma($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana, $SemanaDespachoAd, $Cliente1);
            } else {
                return $this->AgroRhodoAMayorIgualMultiplicacion($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
            }
        }

        if ($FaseActual === '12' && $FaseNueva <= '5') {
            return $this->AgroRhodoAmenorMultiplicacion($tipoFras, $request->all(), $SemanaEjecucion->AnoYSemana);
        }

        return false;
    }

    /********************** FUNCIONES GERMO PLASMA *********************************/
    public function GermoAGermoConprogramaConAdicional($tipoFras, $reques, $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }
        return $this->Imprimir($radicado, $reques);
    }

    public function GermoMayorGermoConprogramaConAdicional($tipoFras, $reques, $SemanaDespachoAd, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => 0,
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => 4,
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['CantidadAdicional'],
            'CantAdicional' => 0,
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $SemanaDespachoAd,
            'Radicado' => $radicado,
            'Cliente' => $Cliente1,
        ]);

        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }
        return $this->Imprimir($radicado, $reques);
    }

    public function GermoAGermoSinAdicional($tipoFras, $reques, $SemanaActual)
    {

        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function GermoAGermoConprogramaSinAdicional($tipoFras, $reques, $SemanaActual, $SemanaDespachoAd, $Cliente1)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;


        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;
        /*LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $SemanaDespachoAd,
            'Radicado' => $radicado,
            'Cliente' => $Cliente1,
        ]);*/


          LabCambioFaseCh::create([
              'ID_Variedad' => $reques['ID_VariedadC'],
              'Indentificador' => $reques['NumIntroduccionEn'],
              'CantSalidas' => $reques['CantidadSalida'],
              'CantPlantas' => $reques['Cantidad'],
              'CantAdicional' => 0,
              'TipoContenedor' => $tipoFras->TipoContenedor,
              'FaseActual' => $reques['ID_FaseActualC'],
              'FaseNueva' => 4,
              'Flag_Activo' => 1,
              'FechaUltimoMovimiento' => $SemanaActual,
              'FechaEntrada' => $reques['SemanaIngresoC'],
              'FechaDespacho' => null,
              'Radicado' => $radicado,
              'Cliente' => null,
          ]);

          LabCambioFaseCh::create([
              'ID_Variedad' => $reques['ID_VariedadC'],
              'Indentificador' => $reques['NumIntroduccionEn'],
              'CantSalidas' => $reques['CantidadSalida'],
              'CantPlantas' => $reques['CantidadAdicional'],
              'CantAdicional' => 0,
              'TipoContenedor' => $tipoFras->TipoContenedor,
              'FaseActual' => $reques['ID_FaseActualC'],
              'FaseNueva' => $reques['idFaseN'],
              'Flag_Activo' => 1,
              'FechaUltimoMovimiento' => $SemanaActual,
              'FechaEntrada' => $reques['SemanaIngresoC'],
              'FechaDespacho' => $SemanaDespachoAd,
              'Radicado' => $radicado,
              'Cliente' => $Cliente1,
          ]);
        return $this->Imprimir($radicado, $reques);

    }

    /********************** FUNCIONES STOCK ***********************/

    public function StockAStockConprogramaConAdicional($tipoFras, $reques, $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        //dd($SemanaDespacho);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }

        return $this->Imprimir($radicado, $reques);
    }

    public function StockASGermoConprogramaConAdicional($tipoFras, $reques, $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }

        return $this->Imprimir($radicado, $reques);
    }

    public function StockmayorStockConprogramaConAdicional($tipoFras, $reques, $SemanaDespachoAd, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;
        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $SemanaDespachoAd,
            'Radicado' => $radicado,
            'Cliente' => $Cliente1,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }

        return $this->Imprimir($radicado, $reques);
    }

    public function StockAStockSinAdicional($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => 5,
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function StockAGErmoSinAdicional($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => 4,
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function StockAStockConprogramaSinAdicional($tipoFras, $reques, $SemanaActual, $SemanaDespachoAd, $Cliente1)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;
        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $SemanaDespachoAd,
            'Radicado' => $radicado,
            'Cliente' => $Cliente1,
        ]);
        return $this->Imprimir($radicado, $reques);
    }


    /********************** FUNCIONES MULTIPLICACION *********************************/
    public function MultiplicacionAMayorIgualMultiplicacionConprogramasAdicionales($tipoFras, $reques, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        //dd('MultiplicacionAMayorIgualMultiplicacionConprogramasAdicionales', $reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $reques['SemanaDespachoC'],
            'Radicado' => $radicado,
            'Cliente' => $reques['clienteC'],
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }
        return $this->Imprimir($radicado, $reques);
    }

    public function MultiplicacionAMenorIgualStockConprogramasAdicionales($tipoFras, $reques, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }
        return $this->Imprimir($radicado, $reques);
    }

    public function MultiplicacionAMayorMultiplicacion($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $reques['SemanaDespachoC'],
            'Radicado' => $radicado,
            'Cliente' => $reques['clienteC'],
        ]);
        return $this->Imprimir($radicado, $reques);
    }

    public function MultiplicacionAMenorMultiplicacion($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    /********************** FUNCIONES ENRAIZAMIENTO *********************************/
    public function EnraizamientoAMayorMutiplicacionConAdicional($tipoFras, $reques, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $reques['SemanaDespachoC'],
            'Radicado' => $radicado,
            'Cliente' => $reques['clienteC'],
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }

        return $this->Imprimir($radicado, $reques);
    }

    public function EnraizamientoAManorMutiplicacionConAdicional($tipoFras, $reques, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }

        return $this->Imprimir($radicado, $reques);
    }

    public function EnraizamientoAMayorMutiplicacionSinAdicional($tipoFras, $reques, $SemanaActual)
    {
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;
        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $reques['SemanaDespachoC'],
            'Radicado' => $radicado,
            'Cliente' => $reques['clienteC'],
        ]);


        return $this->Imprimir($radicado, $reques);
    }

    public function EnraizamientoAMenorMutiplicacionSinAdicional($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    /********************** FUNCIONES DE INTRO A GERMO  *********************************/

    public function IntroGermo($tipoFras, $reques, $SemanaActual)
    {

        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function SeguntaTransConAdicionales($tipoFras, $reques, $SemanaDespacho, $SemanaDespachoAd1, $SemanaDespachoAd2, $SemanaDespachoAd3, $SemanaActual, $Cliente1, $ClienteAd1, $ClienteAd2, $ClienteAd3)
    {

        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);
        if ($reques['Adicionales'] === '1') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);

        }
        if ($reques['Adicionales'] === '2') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
        }
        if ($reques['Adicionales'] === '3') {
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional1'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi1'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd1,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd1,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional2'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi2'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd2,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd2,
            ]);
            LabCambioFaseCh::create([
                'ID_Variedad' => $reques['ID_VariedadC'],
                'Indentificador' => $reques['NumIntroduccionEn'],
                'CantSalidas' => $reques['CantidadSalida'],
                'CantPlantas' => $reques['CantidadAdicional3'],
                'CantAdicional' => 0,
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $reques['ID_FaseActualC'],
                'FaseNueva' => $reques['idFaseAdi3'],
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $reques['SemanaIngresoC'],
                'FechaDespacho' => $SemanaDespachoAd3,
                'Radicado' => $radicado,
                'Cliente' => $ClienteAd3,
            ]);
        }
        return $this->Imprimir($radicado, $reques);
    }

    public function TranferenciasAMuestra($tipoFras, $reques, $SemanaActual)
    {
        //dd($tipoFras, $reques, $SemanaActual);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function MuestraAMuestra($tipoFras, $reques, $SemanaActual)
    {
        //dd($tipoFras, $reques, $SemanaActual);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function MuestraAGermo($tipoFras, $reques, $SemanaActual)
    {
        //dd($tipoFras, $reques, $SemanaActual);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }


    public function AgroRhodoAMayorIgualMultiplicacion($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $reques['SemanaDespachoC'],
            'Radicado' => $radicado,
            'Cliente' => $reques['clienteC'],
        ]);
        return $this->Imprimir($radicado, $reques);
    }

    public function AgroRhodoAmenorMultiplicacion($tipoFras, $reques, $SemanaActual)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => null,
            'Radicado' => $radicado,
            'Cliente' => null,
        ]);

        return $this->Imprimir($radicado, $reques);
    }

    public function AgroRhodoAMayorIgualMultiplicacionSinPrograma($tipoFras, $reques, $SemanaActual, $SemanaDespachoAd, $Cliente1)
    {
        //dd($reques);
        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;
        LabCambioFaseCh::create([
            'ID_Variedad' => $reques['ID_VariedadC'],
            'Indentificador' => $reques['NumIntroduccionEn'],
            'CantSalidas' => $reques['CantidadSalida'],
            'CantPlantas' => $reques['Cantidad'],
            'CantAdicional' => $reques['CantidadAdicional'],
            'TipoContenedor' => $tipoFras->TipoContenedor,
            'FaseActual' => $reques['ID_FaseActualC'],
            'FaseNueva' => $reques['idFaseN'],
            'Flag_Activo' => 1,
            'FechaUltimoMovimiento' => $SemanaActual,
            'FechaEntrada' => $reques['SemanaIngresoC'],
            'FechaDespacho' => $SemanaDespachoAd,
            'Radicado' => $radicado,
            'Cliente' => $Cliente1,
        ]);
        return $this->Imprimir($radicado, $reques);
    }

    public function Imprimir($radicado, $reques)
    {
        set_time_limit(0);
        $date = new Carbon('yesterday');
        $date2 = $date->format('Y-d-m 05:00:00.000');
        $semaDespa = '';
        $cliente = '';
        $CambioFaseBarcode = DB::statement('SET NOCOUNT ON; EXEC CambioFaseCh ?', array(
            $radicado
        ));

        if (empty($reques['SemanaDespachoC'])) {
            $semaDespa = null;
        } else {
            $semaDespa = $reques['SemanaDespachoC'];
        }
        if (empty($reques['clienteC'])) {
            $cliente = null;
        } else {
            $cliente = $reques['clienteC'];
        }

        $update = DB::table('LabLecturaSalidas as sa')
            ->select('sa.CodigoBarras')
            ->join('GetEtiquetasLabInventario as e', 'e.BarCode', '=', 'sa.CodigoBarras')
            ->where('e.Indentificador', '=', $reques['NumIntroduccionEn'])
            ->whereNull('FlagActivo_CambioFase')
            ->where('id_TipoSalida', '=', 8)
            ->where('SemanaDespacho', '=', $semaDespa)
            ->where('ID_FaseActual', '=', $reques['ID_FaseActualC'])
            ->where('cliente', '=', $cliente)
            ->where('sa.updated_at', '>=', $date2)
            ->where('sa.updated_at', '>=', $date2)
            ->where('sa.Flag_Activo', '=', 1)
            ->get();

        //dd($update);
        foreach ($update as $upd) {
            LabLecturaSalida::where('CodigoBarras', $upd->CodigoBarras)
                ->update([
                    'FlagActivo_CambioFase' => 1,
                ]);
        }

        $impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'URC_Generos.NombreGenero',
                DB::raw('GetEtiquetasLabInventario.ID_FaseActual AS FaseActual'))
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->where('GetEtiquetasLabInventario.Radicado', '=', $radicado)
            ->where('GetEtiquetasLabInventario.Procedencia', '=', 'CambioFase')
            ->orderBy('GetEtiquetasLabInventario.BarCode', 'ASC')
            ->get();

        $pdf = PDF::loadView('barcode', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();
        return $pdf->stream('barcode.pdf');
    }


    /* NEW DESARROLLO*/
    public function SelectFasenueva(Request $request)
    {
        // dd($request->all());

        $var = substr($request->get('Indentificador'), 3, 7);

        $FaseActual = $request->get('FaseActual');

        if ($FaseActual <= '3') {

            if ($var >= 3500000) {
                $FasesLab = TipoFasesLab::all()
                    ->whereIn('id', [2, 3,4,5,11]);
            } else {
                $FasesLab = TipoFasesLab::all()
                    ->whereIn('id', [2, 3, 4,5,11]);
            }

        } elseif ($FaseActual === '11') {
            $cumpleIndex = ModelResultadoMuestrasFitopatologia::query()
                ->select('Identificador')
                ->where('Identificador', $request->get('Indentificador'))
                ->whereNull('ResultadoIndex')
                ->count();

            $cumpleScreenr = ModelResultadoMuestrasFitopatologia::query()
                ->select('Identificador')
                ->where('Identificador', $request->get('Indentificador'))
                ->where('ResultadoIndex', '=', 'OK')
                ->count();

            if ($cumpleIndex === 0 && $cumpleScreenr === 0) {
                $FasesLab = TipoFasesLab::all()
                    ->whereIn('id', [11]);

            } elseif ($cumpleIndex === 0 && $cumpleScreenr >= 1) {
                $cumpleScreen = ModelResultadoMuestrasFitopatologia::query()
                    ->select('Identificador')
                    ->where('Identificador', $request->get('Indentificador'))
                    ->whereNull('MuestrasScreen')
                    ->count();

                if ($cumpleIndex === 0 && $cumpleScreen === 0) {
                    $FasesLab = TipoFasesLab::all()
                        ->whereIn('id', [4, 5]);
                }else{
                    $FasesLab = TipoFasesLab::all()
                        ->whereIn('id', [11]);
                }
            } else {
                $FasesLab = TipoFasesLab::all()
                    ->whereIn('id', [11]);
            }

        } else {
            $FasesLab = TipoFasesLab::all()
                ->whereIn('id', [4, 5, 6, 7, 8, 12]);
        }
        return response()->json(['Data' => $FasesLab]);
    }

}
