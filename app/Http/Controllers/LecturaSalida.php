<?php

namespace App\Http\Controllers;

use App\Model\Empleados;
use App\Model\GetEtiquetasLabInventario;
use App\Model\LabCausalesDescarte;
use App\Model\LabCuartos;
use App\Model\LabLecturaAjusteInv;
use App\Model\LabLecturaEntrada;
use App\Model\LabLecturaSalida;
use App\Model\ModelAnoSemana;
use App\Model\ModelResultadoMuestrasFitopatologia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturaSalida extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function readingexit()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        $causales = DB::table('labCausalesDescartes')
            ->select('id', 'CausalDescarte')
            ->whereIn('id', [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 24, 26])->get();
        //dd($causales);

        $TipSalidas = DB::table('LabTipSalida_AjusteInvetarios')
            ->select('id', 'TipoSalida_Ajuste')
            ->whereIn('id', [4, 5, 6, 8, 9])->get();

        //dd($TipSalidas);

        return view('Laboratorio.LecturaSalida', compact('cuartosAc', 'causales', 'TipSalidas'));
    }

    public function SalidaXCancelacion(Request $request)
    {

        if ($request->ajax()) {

            $barcode = $request['BarcodeC'];

            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $existeBarcode = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();

            /* este es para mostrar datos de la ultima lectura*/
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'idCausalDañoC' => 'required',
                'BarcodeC' => 'required',
                'id_TipoSalidaC' => 'required',
            ]);

            $UltLectu = Empleados::SalidaCaUltimalectura($request);

            if ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } elseif (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                LabLecturaEntrada::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                LabLecturaAjusteInv::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                if ($existeBarcodeInac) {

                    LabLecturaSalida::where('CodigoBarras', $barcode)
                        ->update([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => $request['id_TipoSalidaC'],
                            'id_TipoCancelado' => $request['idCausalDañoC'],
                            'CodigoBarras' => $request['BarcodeC'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        ]);
                } else {
                    LabLecturaSalida::create([
                        'id_Patinador' => $patinador,
                        'id_TipoSalida' => $request['id_TipoSalidaC'],
                        'id_TipoCancelado' => $request['idCausalDañoC'],
                        'CodigoBarras' => $request['BarcodeC'],
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                }


                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);

            }
        }
    }

    public function SalidaXDanoMaterial(Request $request)
    {
        if ($request->ajax()) {
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'id_TipoDañodm' => 'required',
                'Barcodedm' => 'required',
                'id_TipoSalidadm' => 'required',
            ]);

            $barcode = $request['Barcodedm'];
            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();
            $existeBarcode = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();
            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();

            $UltLectu = Empleados::SalidaXDanoMaterial($request);
            if (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            } elseif ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                LabLecturaEntrada::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                LabLecturaAjusteInv::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                if ($existeBarcodeInac) {

                    LabLecturaSalida::where('CodigoBarras', $barcode)
                        ->update([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => $request['id_TipoSalidadm'],
                            'id_TipoCancelado' => $request['id_TipoDañodm'],
                            'CodigoBarras' => $request['Barcodedm'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        ]);
                } else {
                    LabLecturaSalida::create([
                        'id_Patinador' => $patinador,
                        'id_TipoSalida' => $request['id_TipoSalidadm'],
                        'id_TipoCancelado' => $request['id_TipoDañodm'],
                        'CodigoBarras' => $request['Barcodedm'],
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                }

                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function SalidaXDespacho(Request $request)
    {

        if ($request->ajax()) {

            $barcode = $request['Barcoded'];

            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $existeBarcode = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();
            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();
            /* este es para mostrar datos de la ultima lectura*/
            $UltLectu = Empleados::SalidaDespacho($request);
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'id_TipoSalida_d' => 'required',
                'Barcoded' => 'required',
            ]);
            if (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            } elseif ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                LabLecturaEntrada::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                LabLecturaAjusteInv::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                //'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE

                if ($existeBarcodeInac) {

                    LabLecturaSalida::where('CodigoBarras', $barcode)
                        ->update([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => $request['id_TipoSalida_d'],
                            'CodigoBarras' => $request['Barcoded'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        ]);
                } else {
                    LabLecturaSalida::create([
                        'id_Patinador' => $patinador,
                        'id_TipoSalida' => $request['id_TipoSalida_d'],
                        'CodigoBarras' => $request['Barcoded'],
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                }


                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function SalidaAProduccion(Request $request)
    {

        if ($request->ajax()) {
            /* este es para mostrar datos de la ultima lectura*/
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);
            $patinador = auth()->user()->id_Empleado;

            $request->validate([
                'id_TipoSalidap' => 'required',
                'BarcodeP' => 'required'
            ]);

            $barcode = $request['BarcodeP'];
            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();
            $existeBarcode = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();


            if (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            } elseif ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {

                $faseActual = GetEtiquetasLabInventario::query()->select('ID_FaseActual')->where('Barcode', $barcode)->first();

                if ($faseActual->ID_FaseActual === '11') {
                    $ResultadoIndex = ModelResultadoMuestrasFitopatologia::query()
                        ->select('ResultadoIndex')
                        ->where('CodigoBarras', $barcode)
                        ->first();

                    if ($ResultadoIndex->ResultadoIndex === null) {
                        return response()->json([
                            'data' => 3,
                        ]);
                    } elseif ($ResultadoIndex->ResultadoIndex === 'NEGATIVO') {
                        $UltLectu = Empleados::SalidaProduccion($request);
                        LabLecturaEntrada::query()
                            ->where('CodigoBarras', $barcode)
                            ->update(['Flag_Activo' => 0]);

                        LabLecturaAjusteInv::query()
                            ->where('CodigoBarras', $barcode)
                            ->update(['Flag_Activo' => 0]);
                        $dateA = Carbon::now();
                        $dateMasSema = $dateA->format('Y-m-d');
                        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                        //'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        if ($existeBarcodeInac) {
                            LabLecturaSalida::query()
                                ->where('CodigoBarras', $barcode)
                                ->update([
                                    'id_Patinador' => $patinador,
                                    'id_TipoSalida' => $request['id_TipoSalidap'],
                                    'CodigoBarras' => $request['BarcodeP'],
                                    'Flag_Activo' => 1,
                                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                                ]);
                        } else {
                            //dd('entro else');
                            LabLecturaSalida::create([
                                'id_Patinador' => $patinador,
                                'id_TipoSalida' => $request['id_TipoSalidap'],
                                'CodigoBarras' => $request['BarcodeP'],
                                'Flag_Activo' => 1,
                                'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                            ]);
                        }
                        return response()->json([
                            'consulta' => $UltLectu,
                            'barcode' => $barcode,
                            'data' => 1,
                        ]);
                    } elseif ($ResultadoIndex->ResultadoIndex === 'POSITIVO') {
                        return response()->json([
                            'data' => 4,
                        ]);
                    } elseif ($ResultadoIndex->ResultadoIndex === 'OK') {

                        $ResultadoScreen = ModelResultadoMuestrasFitopatologia::query()
                            ->select('MuestrasScreen', 'PositivosMuestrasScreenRestringidas')
                            ->where('CodigoBarras', $barcode)
                            ->first();

                        // dd($ResultadoScreen->MuestrasScreen);
                        if ($ResultadoScreen->MuestrasScreen === null) {
                            return response()->json([
                                'data' => 3,
                            ]);
                        } elseif ($ResultadoScreen->MuestrasScreen != null && $ResultadoScreen->PositivosMuestrasScreenRestringidas === null) {
                            $UltLectu = Empleados::SalidaProduccion($request);
                            LabLecturaEntrada::query()
                                ->where('CodigoBarras', $barcode)
                                ->update(['Flag_Activo' => 0]);

                            LabLecturaAjusteInv::query()
                                ->where('CodigoBarras', $barcode)
                                ->update(['Flag_Activo' => 0]);
                            $dateA = Carbon::now();
                            $dateMasSema = $dateA->format('Y-m-d');
                            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                            //'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                            if ($existeBarcodeInac) {
                                LabLecturaSalida::query()
                                    ->where('CodigoBarras', $barcode)
                                    ->update([
                                        'id_Patinador' => $patinador,
                                        'id_TipoSalida' => $request['id_TipoSalidap'],
                                        'CodigoBarras' => $request['BarcodeP'],
                                        'Flag_Activo' => 1,
                                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                                    ]);
                            } else {
                                //dd('entro else');
                                LabLecturaSalida::create([
                                    'id_Patinador' => $patinador,
                                    'id_TipoSalida' => $request['id_TipoSalidap'],
                                    'CodigoBarras' => $request['BarcodeP'],
                                    'Flag_Activo' => 1,
                                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                                ]);
                            }
                            return response()->json([
                                'consulta' => $UltLectu,
                                'barcode' => $barcode,
                                'data' => 1,
                            ]);
                        } elseif ($ResultadoScreen->MuestrasScreen != null && $ResultadoScreen->PositivosMuestrasScreenRestringidas != null) {
                            return response()->json([
                                'data' => 4,
                            ]);
                        }

                    }

                } else {
                    $UltLectu = Empleados::SalidaProduccion($request);
                    LabLecturaEntrada::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);

                    LabLecturaAjusteInv::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);
                    $dateA = Carbon::now();
                    $dateMasSema = $dateA->format('Y-m-d');
                    $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                    //'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    if ($existeBarcodeInac) {
                        LabLecturaSalida::query()
                            ->where('CodigoBarras', $barcode)
                            ->update([
                                'id_Patinador' => $patinador,
                                'id_TipoSalida' => $request['id_TipoSalidap'],
                                'CodigoBarras' => $request['BarcodeP'],
                                'Flag_Activo' => 1,
                                'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                            ]);
                    } else {
                        //dd('entro else');
                        LabLecturaSalida::create([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => $request['id_TipoSalidap'],
                            'CodigoBarras' => $request['BarcodeP'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        ]);
                    }
                    return response()->json([
                        'consulta' => $UltLectu,
                        'barcode' => $barcode,
                        'data' => 1,
                    ]);
                }
            }
        }
    }

    public function SalidaXsobrantes(Request $request)
    {

        if ($request->ajax()) {
            /* este es para mostrar datos de la ultima lectura*/
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'id_TipoSalidaS' => 'required',
                'BarcodeS' => 'required',
            ]);

            $barcode = $request['BarcodeS'];
            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();
            $existeBarcode = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();

            if (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            } elseif ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                LabLecturaEntrada::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                LabLecturaAjusteInv::query()
                    ->where('CodigoBarras', $barcode)
                    ->update(['Flag_Activo' => 0]);

                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                if ($existeBarcodeInac) {

                    LabLecturaSalida::where('CodigoBarras', $barcode)
                        ->update([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => $request['id_TipoSalidaS'],
                            'CodigoBarras' => $request['BarcodeS'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        ]);
                } else {

                    LabLecturaSalida::create([
                        'id_Patinador' => $patinador,
                        'id_TipoSalida' => $request['id_TipoSalidaS'],
                        'CodigoBarras' => $request['BarcodeS'],
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                }

                return response()->json([
                    /*'consulta' => $UltLectu,*/
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }
}
