<?php

namespace App\Http\Controllers;


use App\Exports\ExportarDescartesPlotPropagacion;
use App\Exports\ExportarSalidasPlotPropagacion;
use App\Exports\ExportConfirmacionesEntregadas;
use App\Exports\ExportReportePropagacionAgrupado;
use App\Exports\ExportReportePropagacionDescriminado;
use App\Imports\InventarioRenewalProduccionImport;
use App\Imports\UrcProgramasweekRenewallImport;
use App\model\arqueoInventarioModel;
use App\Model\CancelacionesRenewalCodigosModel;
use App\Model\GetEtiquetasRenewalProduncionModel;
use App\Model\ModelAnoSemana;
use App\Model\ModelCausalesFitosanidad;
use App\Model\ModelPlotsDesmarque;
use App\Model\ProdInventarioRenewalsModel;
use App\Model\ProdLecturaSalidaRenewals;
use App\Model\RegistroPLotIDPropagacion;
use App\Model\RenewallModificadosModel;
use App\Model\TipoCancelacionRenewalModel;
use App\Model\urcCausalEntregaParcialModel;
use App\Model\URCCausalSalidaModel;
use App\Model\URCLecturaAlistamientoPropagacionModel;
use App\Model\urcLecturaArqueoPropagacion;
use App\Model\UrcLecturaDescarteRenewallProduccionModel;
use App\Model\URCLecturaDevolucionPropagacionModel;
use App\Model\UrcLecturaEntradaPropagacionModel;
use App\Model\URCLecturaEntregaParcialPropagacionModel;
use App\Model\urcLecturaHormonaPropagacionModel;
use App\Model\UrcLecturaSalidaRenewallProduccionModel;
use App\Model\urcPropagacionConfirmaciones;
use App\Model\URCPropagacionModel;
use App\Model\Variedades;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use CreateGetEtiquetasRenewalProduncionsTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PropagacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function VistaLecturaEntradaPropagacion()
    {
        $ubicaciones = URCPropagacionModel::all();
        return view('Propagacion.LecturaEntrada', compact('ubicaciones'));
    }

    public function LecturaEntradaProgpagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'idUbicacion' => 'required',
                'Operario' => 'required',
                'CodigoBarras' => 'required',
            ]);
            $patinador = auth()->user()->id_Empleado;


            $SalidaCuartoFrio = '';
            $CodigoBarras = $request['CodigoBarras'];

            $GeneracionCodigo = GetEtiquetasRenewalProduncionModel::query()
                ->select('CodigoBarras', 'EsquejesXBolsillo', 'PlotIDNuevo', 'CodigoIntegracion')
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            $YaleidoEntrada = UrcLecturaEntradaPropagacionModel::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            if ($GeneracionCodigo) {

                $variedad = DB::table('URC_Variedades')
                    ->select('gen.id as idGenero')
                    ->join('URC_Especies as esp', 'esp.id', '=', 'ID_Especie')
                    ->join('URC_Generos as gen', 'gen.id', '=', 'esp.Id_Genero')
                    ->where('Codigo', '=', $GeneracionCodigo->CodigoIntegracion)
                    ->first();
                if ($variedad->idGenero === '64' || $variedad->idGenero === '94' || $variedad->idGenero === '67') {
                    //$SalidaCuartoFrio ==='';
                } else {
                    $SalidaCuartoFrio = ProdLecturaSalidaRenewals::query()
                        ->select('CodigoBarras')
                        ->where('CodigoBarras', $CodigoBarras)
                        ->where('Flag_Activo', 1)
                        ->first();
                }
                if ($YaleidoEntrada) {
                    return response()->json([
                        'data' => 3,
                    ]);
                }
                if ($SalidaCuartoFrio === null) {
                    //aqui valido si es lavandula
                    return response()->json([
                        'data' => 4,
                    ]);
                } else {
                    $Plotyaleido = GetEtiquetasRenewalProduncionModel::query()
                        ->join('URCLecturaEntradaPropagacion', 'URCLecturaEntradaPropagacion.CodigoBarras', '=', 'GetEtiquetasRenewalProduncion.CodigoBarras')
                        ->where('PlotIDNuevo', $GeneracionCodigo->PlotIDNuevo)
                        ->where('GetEtiquetasRenewalProduncion.Flag_Activo', 1)
                        ->first();

                    $BandejasTotalPlot = GetEtiquetasRenewalProduncionModel::query()
                        ->where('PlotIDNuevo', $GeneracionCodigo->PlotIDNuevo)
                        ->count();
//                    dd($Plotyaleido);
                    if (empty($Plotyaleido)) {
                        //dd('emtro al if');
                        $espacioTotal = URCPropagacionModel::query()
                            ->select('CapacidadBandejas')
                            ->where('id', '=', $request->get('idUbicacion'))
                            ->first();
                        //dd($Ubicacion);
                        $espacioDisponible = UrcLecturaEntradaPropagacionModel::query()
                            ->where('idUbicacion', $request->get('idUbicacion'))
                            ->where('Flag_Activo', '=', 1)
                            ->count();

                        $disponibilidad = $espacioTotal->CapacidadBandejas - $espacioDisponible;


                        if ($disponibilidad >= $BandejasTotalPlot) {
                            // dd('guarda el primer plot');
                            $dateA = Carbon::now();
                            $dateMasSema = $dateA->format('Y-m-d');
                            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                            UrcLecturaEntradaPropagacionModel::query()
                                ->create([
                                    'id_Patinador' => $patinador,
                                    'idUbicacion' => $request['idUbicacion'],
                                    'Plantas' => $GeneracionCodigo->EsquejesXBolsillo,
                                    'CodigoBarras' => $request['CodigoBarras'],
                                    'CodOperario' => $request['Operario'],
                                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                                    'PlotId' => $GeneracionCodigo->PlotIDNuevo,
                                    'Flag_Activo' => 1

                                ]);
                            $UltLectu = GetEtiquetasRenewalProduncionModel::UltimalecturaEntradaPropagacion($request);
                            //dd($UltLectu);
                            RegistroPLotIDPropagacion::query()
                                ->where('PlotId', $UltLectu->PlotIDNuevo)
                                ->update([
                                    'CantidaPlantasPropagacionInicial' => $UltLectu->PLantas,
                                    'CantidaPlantasPropagacionInventario' => $UltLectu->PLantas,
                                ]);
                            return response()->json([
                                'consulta' => $UltLectu,
                                'data' => 1,
                            ]);
                        } else {
                            /* no disponibilidad*/
                            return response()->json([
                                'data' => 5,
                            ]);
                        }
                    } else {
                        //dd('ya hay plot no valida');
                        $dateA = Carbon::now();
                        $dateMasSema = $dateA->format('Y-m-d');
                        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                        $patinador = auth()->user()->id_Empleado;
                        UrcLecturaEntradaPropagacionModel::query()
                            ->create([
                                'id_Patinador' => $patinador,
                                'idUbicacion' => $request['idUbicacion'],
                                'Plantas' => $GeneracionCodigo->EsquejesXBolsillo,
                                'CodigoBarras' => $request['CodigoBarras'],
                                'CodOperario' => $request['Operario'],
                                'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                                'PlotId' => $GeneracionCodigo->PlotIDNuevo,
                                'Flag_Activo' => 1

                            ]);
                        $UltLectu = GetEtiquetasRenewalProduncionModel::UltimalecturaEntradaPropagacion($request);
                        RegistroPLotIDPropagacion::query()
                            ->where('PlotId', $UltLectu->PlotIDNuevo)
                            ->update([
                                'CantidaPlantasPropagacionInicial' => $UltLectu->PLantas,
                                'CantidaPlantasPropagacionInventario' => $UltLectu->PLantas,
                            ]);

                        //dd($UltLectu);
                        return response()->json([
                            'consulta' => $UltLectu,
                            'data' => 1,
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'data' => 2,
                ]);
            }
        }
    }

    public function VistaLecturaTraladoPropagacion()
    {
        $ubicaciones = URCPropagacionModel::all();
        return view('Propagacion.LecturaTraslado', compact('ubicaciones'));
    }

    public function LecturatrasladoPropagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'IdUbicacion' => 'required',
                'PlotId' => 'required',
            ]);
            $PlotId = $request['PlotId'];
            $ubicacion = $request['IdUbicacion'];

            //dd($request->all());

            $BandejasTotalPlotActivas = GetEtiquetasRenewalProduncionModel::query()
                ->join('URCLecturaEntradaPropagacion as en', 'en.CodigoBarras', '=', 'GetEtiquetasRenewalProduncion.CodigoBarras')
                ->where('PlotIDNuevo', $PlotId)
                ->where('en.Flag_Activo', '=', 1)
                ->count();

            $espacioTotal = URCPropagacionModel::query()
                ->select('CapacidadBandejas')
                ->where('id', '=', $ubicacion)
                ->first();

            $espacioDisponible = UrcLecturaEntradaPropagacionModel::query()
                ->where('idUbicacion', $ubicacion)
                ->where('Flag_Activo', '=', 1)
                ->count();
            //dd($espacioDisponible);
            $espacioDisponibleBanco = $espacioTotal->CapacidadBandejas - $espacioDisponible;

            if ($espacioDisponibleBanco >= $BandejasTotalPlotActivas) {

                $BandejasMover = GetEtiquetasRenewalProduncionModel::query()
                    ->select('en.CodigoBarras')
                    ->join('URCLecturaEntradaPropagacion as en', 'en.CodigoBarras', '=', 'GetEtiquetasRenewalProduncion.CodigoBarras')
                    ->where('PlotIDNuevo', $PlotId)
                    ->where('en.Flag_Activo', '=', 1)
                    ->get();

                //dd($BandejasMover->CodigoBarras);
                foreach ($BandejasMover as $codigo) {
                    UrcLecturaEntradaPropagacionModel::query()
                        ->where('CodigoBarras', $codigo->CodigoBarras)
                        ->update([
                            'idUbicacion' => $ubicacion,
                        ]);
                }
                return response()->json([
                    'data' => 1,
                ]);
            } else {
                return response()->json([
                    'data' => 2,
                ]);
            }
        } else {
            return response()->json([
                'data' => 3,
            ]);
        }
    }

    public function VistaLecturaDescartePropagacion()
    {
        $causaleSalidas = URCCausalSalidaModel::query()
            ->select('id', 'CausalDescarte')
            ->where('Flag_Activo', 1)
            ->get();
        //dd($causaleSalidas);
        return view('Propagacion.LecturaDescarte', compact('causaleSalidas'));
    }

    public function LecturaDescartePropagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'PlotIdD' => 'required',
                'idCausalDescarte' => 'required',
                'PlantasDescarte' => 'required',
            ]);
            $PlotIdD = $request['PlotIdD'];
            $PlantasDescarte = $request['PlantasDescarte'];
            $idCausalDescarte = $request['idCausalDescarte'];

            $activoPlot = RegistroPLotIDPropagacion::query()
                ->where('PlotId', $PlotIdD)
                ->where('Flag_Activo', 1)
                ->first();

            if ($activoPlot) {
                $cantidadTotal = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);

                if ($PlantasDescarte > $cantidadTotal->CantidaPlantasPropagacionInventario) {
                    return response()->json([
                        'data' => 3
                    ]);
                } else {
                    while ($PlantasDescarte > 0) {

                        $bandejasActivasPlots = UrcLecturaEntradaPropagacionModel::query()
                            ->select([
                                'URCLecturaEntradaPropagacion.CodigoBarras',
                                'URCLecturaEntradaPropagacion.Plantas'])
                            ->join('GetEtiquetasRenewalProduncion as gt', 'gt.CodigoBarras', '=', 'URCLecturaEntradaPropagacion.CodigoBarras')
                            ->where('URCLecturaEntradaPropagacion.Flag_Activo', 1)
                            ->where('gt.PlotIDNuevo', $PlotIdD)
                            ->orderBy('URCLecturaEntradaPropagacion.created_at', 'DESC')
                            ->get();

                        foreach ($bandejasActivasPlots as $bandejasActivasPlot) {

                            if ($bandejasActivasPlot->Plantas >= $PlantasDescarte) {
                                $PlantasDescarte = $bandejasActivasPlot->Plantas - $PlantasDescarte;

                                if ($PlantasDescarte === 0) {
                                    UrcLecturaEntradaPropagacionModel::query()
                                        ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                        ->update([
                                            'Plantas' => 0,
                                            'Flag_Activo' => 0,
                                        ]);
                                    $PlantasDescarte = 0;
                                } else {

                                    UrcLecturaEntradaPropagacionModel::query()
                                        ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                        ->update([
                                            'Plantas' => $PlantasDescarte,
                                        ]);
                                    $PlantasDescarte = 0;
                                }
                            } else {

                                $PlantasDescarte = $PlantasDescarte - $bandejasActivasPlot->Plantas;
                                UrcLecturaEntradaPropagacionModel::query()
                                    ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                    ->update([
                                        'Plantas' => 0,
                                        'Flag_Activo' => 0,
                                    ]);
                            }

                        }
                        $patinador = auth()->user()->id_Empleado;
                        $dateA = Carbon::now();
                        $dateMasSema = $dateA->format('Y-m-d');
                        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                        UrcLecturaDescarteRenewallProduccionModel::query()
                            ->create([
                                'idPatinador' => $patinador,
                                'PlotId' => $PlotIdD,
                                'CausalDescarte' => $idCausalDescarte,
                                'PlantasDescartadas' => $request['PlantasDescarte'],
                                'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                            ]);
                        $total = RegistroPLotIDPropagacion::query()
                            ->select('CantidaPlantasPropagacionInventario')
                            ->where('PlotId', $PlotIdD)
                            ->first();

                        $totalInv = $total->CantidaPlantasPropagacionInventario - $request['PlantasDescarte'];

                        if ($totalInv === 0) {
                            RegistroPLotIDPropagacion::query()
                                ->where('PlotId', $PlotIdD)
                                ->update([
                                    'CantidaPlantasPropagacionInventario' => $totalInv,
                                    'Flag_Activo' => 0
                                ]);
                        } else {
                            RegistroPLotIDPropagacion::query()
                                ->where('PlotId', $PlotIdD)
                                ->update([
                                    'CantidaPlantasPropagacionInventario' => $totalInv
                                ]);
                        }

                        $UltLectu = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);
                        return response()->json([
                            'consulta' => $UltLectu,
                            'data' => 1,
                        ]);
                    }
                }

            } else {
                return response()->json([
                    'data' => 2,
                ]);
            }
        }
    }

    public function ConsultarBandeja(Request $request)
    {

        //dd($request->all());
        $UltLectu = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);

        if ($UltLectu) {
            return response()->json([
                'consulta' => $UltLectu,
                'data' => 1,
            ]);
        } else {
            return response()->json([
                'data' => 2,
            ]);
        }
    }

    public function ViewConfirmacionesPropagacion()
    {
        return view('Propagacion.ConfirmacionesPropagacion');
    }

    public function ConsultarPlotConfiracion(Request $request)
    {
        // dd($request->all());
        $existe = urcPropagacionConfirmaciones::query()->where('PlotId', $request['PlotIdD'])->first();

        if ($existe) {
            return response()->json([
                'data' => 2,
            ]);
        } else {
            $UltLectu = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);
            if ($UltLectu->CantidaPlantasPropagacionInventario != null) {
                return response()->json([
                    'consulta' => $UltLectu,
                    'data' => 1,
                ]);
            } else {
                return response()->json([
                    'data' => 3,
                ]);
            }
        }
    }

    public function GuardaConfirmacionesPropagacion(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'PlotId' => 'required',
            'PlantasDisponibles' => 'required',
            'CantConfirmaciones' => 'required',
        ]);
        $count = $request['CantConfirmaciones'];
        $now = Carbon::now();
        $yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;

        if (strlen($SemanaAc) === 1) {
            $SemanaAc = '0' . $SemanaAc;
        }

        $SemanaActual = $yearAc . '' . $SemanaAc;
        for ($i = 1; $i <= $count; $i++) {
            $semanaC = $request['SemanaConfirmacion-' . $i];

            $semanaCN = explode('-W', $semanaC);
            $dato1 = $semanaCN[0];
            $dato2 = $semanaCN[1];

            if (strlen($dato2) === 1) {
                $dato2 = '0' . $dato2;
            }
            $SemanaDespacho = $dato1 . '' . $dato2;

            if ($SemanaDespacho === $SemanaActual) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $create = urcPropagacionConfirmaciones::query()
                    ->create([
                        'PlotId' => $request['PlotId'],
                        'PlantasdisponiblesInicales' => $request['PlantasDisponibles'],
                        'plantasconfirmadas' => $request['CantidadAdicional-' . $i],
                        'semanaConfirmacion' => $SemanaDespacho,
                        'semanaConfirmacionModificada' => $SemanaDespacho,
                        'SemanaCreado' => $SemanaActual,
                        'Descargado' => 1,
                        'Flag_Activo' => 1,
                    ]);
                return response()->json([
                    'data' => 1,
                ]);

            }

        }
        return response()->json([
            'data' => 1,
        ]);
    }

    public function ConfirmacionesSalidasPlot(Request $request)
    {
        // dd($request->all());
        $confirmaciones = GetEtiquetasRenewalProduncionModel::PropagacionConfirmacionesSalidas($request);

        if ($confirmaciones) {
            return response()->json([
                'consulta' => $confirmaciones,
                'data' => 1,
            ]);
        } else {
            return response()->json([
                'data' => 2,
            ]);
        }
    }

    public function VistaLecturaSalidaPropagacion()
    {
        return view('Propagacion.LecturaSalida');
    }

    public function LecturaSalidaDespachoPropagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'PlotIdD' => 'required',
                'CantPlantas' => 'required',
            ]);
            $PlotID = $request['PlotIdD'];
            $CantPlantas = $request['CantPlantas'];
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);


            $badejasTotales = GetEtiquetasRenewalProduncionModel::query()
                ->select([
                    DB::raw('sum (plantas) as plantas'),
                    DB::raw('count (en.CodigoBarras) as totalBandejas'),
                ])
                ->join('URCLecturaEntradaPropagacion as en', 'en.CodigoBarras', '=', 'GetEtiquetasRenewalProduncion.CodigoBarras')
                ->where('GetEtiquetasRenewalProduncion.PlotIDNuevo', $PlotID)
                ->where('en.Flag_Activo', 1)
                ->groupBy('GetEtiquetasRenewalProduncion.PlotIDNuevo')
                ->get();

            $TipoBandejaPLot = GetEtiquetasRenewalProduncionModel::query()
                ->select('PlotIDNuevo')
                ->where('GetEtiquetasRenewalProduncion.PlotIDNuevo', $PlotID)
                ->groupBy('PlotIDNuevo')
                ->get();

            $cantidadTotal = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);

            if ($CantPlantas > $cantidadTotal->CantidaPlantasPropagacionInventario) {
                return response()->json([
                    'data' => 2
                ]);
            } else {
                while ($CantPlantas > 0) {

                    $bandejasActivasPlots = UrcLecturaEntradaPropagacionModel::query()
                        ->select([
                            'URCLecturaEntradaPropagacion.CodigoBarras',
                            'URCLecturaEntradaPropagacion.Plantas'])
                        ->join('GetEtiquetasRenewalProduncion as gt', 'gt.CodigoBarras', '=', 'URCLecturaEntradaPropagacion.CodigoBarras')
                        ->where('URCLecturaEntradaPropagacion.Flag_Activo', 1)
                        ->where('gt.PlotIDNuevo', $PlotID)
                        ->orderBy('URCLecturaEntradaPropagacion.created_at', 'DESC')
                        ->get();

                    foreach ($bandejasActivasPlots as $bandejasActivasPlot) {

                        if ($bandejasActivasPlot->Plantas >= $CantPlantas) {
                            $CantPlantas = $bandejasActivasPlot->Plantas - $CantPlantas;

                            if ($CantPlantas === 0) {
                                UrcLecturaEntradaPropagacionModel::query()
                                    ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                    ->update([
                                        'Plantas' => 0,
                                        'Flag_Activo' => 0,
                                    ]);
                                $CantPlantas = 0;
                            } else {

                                UrcLecturaEntradaPropagacionModel::query()
                                    ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                    ->update([
                                        'Plantas' => $CantPlantas,
                                    ]);
                                $CantPlantas = 0;
                            }
                        } else {

                            $CantPlantas = $CantPlantas - $bandejasActivasPlot->Plantas;
                            UrcLecturaEntradaPropagacionModel::query()
                                ->where('CodigoBarras', $bandejasActivasPlot->CodigoBarras)
                                ->update([
                                    'Plantas' => 0,
                                    'Flag_Activo' => 0,
                                ]);
                        }

                    }
                    $dateA = Carbon::now();
                    $dateMasSema = $dateA->format('Y-m-d');
                    $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                    $patinador = auth()->user()->id_Empleado;
                    UrcLecturaSalidaRenewallProduccionModel::query()
                        ->create([
                            'id_Patinador' => $patinador,
                            'PlotID' => $PlotID,
                            'CantPlantas' => $request['CantPlantas'],
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                            'Flag_Activo' => 1,

                        ]);

                    urcPropagacionConfirmaciones::query()
                        ->where('PlotId', $PlotID)
                        ->where('semanaConfirmacionModificada', $SemanaEjecucion->AnoYSemana)
                        ->where('Flag_Activo', 1)
                        ->update([
                            'Flag_Activo' => 0
                        ]);


                    $total = RegistroPLotIDPropagacion::query()
                        ->select('CantidaPlantasPropagacionInventario')
                        ->where('PlotId', $PlotID)
                        ->first();


                    $totalInv = $total->CantidaPlantasPropagacionInventario - $request['CantPlantas'];
                    //dd($totalInv);
                    if ($totalInv === 0) {
                        RegistroPLotIDPropagacion::query()
                            ->where('PlotId', $PlotID)
                            ->update([
                                'CantidaPlantasPropagacionInventario' => $totalInv,
                                'Flag_Activo' => 0
                            ]);
                    } else {
                        RegistroPLotIDPropagacion::query()
                            ->where('PlotId', $PlotID)
                            ->update([
                                'CantidaPlantasPropagacionInventario' => $totalInv
                            ]);
                    }

                    $UltLectu = GetEtiquetasRenewalProduncionModel::CosultarPlotId($request);
                    return response()->json([
                        'consulta' => $UltLectu,
                        'data' => 1,
                    ]);
                }
            }


        }
    }

    public function EspacioBancos(Request $request)
    {

        //dd($request->all());

        $UbicacionView = $request->get('dato');

        $Ubicacion = URCPropagacionModel::query()
            ->select('Ubicacion')
            ->where('id', '=', $UbicacionView)
            ->first();
        //dd($Ubicacion);
        $consulta = UrcLecturaEntradaPropagacionModel::query()
            ->select(
                DB::raw('COUNT(id) as CantidadBandejas'))
            ->where('idUbicacion', $UbicacionView)
            ->where('Flag_Activo', '=', 1)
            ->groupBy('idUbicacion')
            ->first();

        $dato1 = '116';
        $dato2 = '133';
        $dato3 = '208';
        $dato4 = '232';
        $dato5 = '266';
        if ($Ubicacion->Ubicacion === '13-1-8' || $Ubicacion->Ubicacion === '13-1-9') {
            if ($consulta->CantidadBandejas === $dato1 || $consulta->CantidadBandejas > $dato1) {
                return response()->json([
                    'ok' => 1
                ]);
            } else {
                return response()->json([
                    'ok' => 2
                ]);
            }
        } else if ($Ubicacion->Ubicacion === '13-1-24' || $Ubicacion->Ubicacion === '13-1-25') {

            if ($consulta->CantidadBandejas === $dato2 || $consulta->CantidadBandejas > $dato2) {
                return response()->json([
                    'ok' => 1
                ]);
            } else {
                return response()->json([
                    'ok' => 2
                ]);
            }
        } else if ($Ubicacion->Ubicacion === '13-1-1') {
            if ($consulta->CantidadBandejas === $dato3 || $consulta->CantidadBandejas > $dato3) {
                return response()->json([
                    'ok' => 1
                ]);
            } else {
                return response()->json([
                    'ok' => 2
                ]);
            }
        } else if ($Ubicacion->Ubicacion === '13-1-2' || $Ubicacion->Ubicacion === '13-1-3' || $Ubicacion->Ubicacion === '13-1-4' || $Ubicacion->Ubicacion === '13-1-5' || $Ubicacion->Ubicacion === '13-1-6' || $Ubicacion->Ubicacion === '13-1-7'
            || $Ubicacion->Ubicacion === '13-1-10' || $Ubicacion->Ubicacion === '13-1-11' || $Ubicacion->Ubicacion === '13-1-12' || $Ubicacion->Ubicacion === '13-1-13' || $Ubicacion->Ubicacion === '13-1-14' || $Ubicacion->Ubicacion === '13-1-15' || $Ubicacion->Ubicacion === '13-1-16') {
            //dd($consulta->CantidadBandejas, $dato4);232 === 232
            if ($consulta->CantidadBandejas === $dato4 || $consulta->CantidadBandejas > $dato4) {
                return response()->json([
                    'ok' => 1
                ]);
            } else {
                return response()->json([
                    'ok' => 2
                ]);
            }
        } else if ($Ubicacion->Ubicacion === '13-1-17' || $Ubicacion->Ubicacion === '13-1-18' || $Ubicacion->Ubicacion === '13-1-19' || $Ubicacion->Ubicacion === '13-1-20' || $Ubicacion->Ubicacion === '13-1-21' || $Ubicacion->Ubicacion === '13-1-22'
            || $Ubicacion->Ubicacion === '13-1-23' || $Ubicacion->Ubicacion === '13-1-26' || $Ubicacion->Ubicacion === '13-1-27' || $Ubicacion->Ubicacion === '13-1-28' || $Ubicacion->Ubicacion === '13-1-29' || $Ubicacion->Ubicacion === '13-1-30' ||
            $Ubicacion->Ubicacion === '13-1-31' || $Ubicacion->Ubicacion === '13-1-32') {
            // dd($consulta->CantidadBandejas === $dato5 || $consulta->CantidadBandejas > $dato5);
            if ($consulta->CantidadBandejas === $dato5 || $consulta->CantidadBandejas > $dato5) {
                return response()->json([
                    'ok' => 1
                ]);
            } else {
                return response()->json([
                    'ok' => 2
                ]);
            }
        } else {
            return 0;
        }
    }

    public function CargueInventarioRenewalProduccion()
    {
        $date = Carbon::now()->format('Y-d-m' . " 00:00:00");
        $Renewal = DB::table('prod_inventario_renewals')
            ->select(
                'Semana',
                'Fecha',
                'PlotIDNuevo',
                'PlotIDOrigen',
                'SubPlotID',
                'CodigoIntegracion',
                'Cantidad',
                'CantidadBolsillos',
                'Bloque',
                'Nave',
                'Cama',
                'Procedencia',
                'SemanaCosecha',
                'prod_inventario_renewals.created_at',
                DB::raw('CONCAT(URC_Generos.NombreGenero,\' - \', URC_Variedades.Nombre_Variedad) as NombreVariedad')
            )
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'prod_inventario_renewals.CodigoIntegracion')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.ID_Genero')
            ->where('prod_inventario_renewals.Flag_Activo', '=', 1)
            ->where('prod_inventario_renewals.created_at', '>=', $date)
            ->get();

        $radicado = GetEtiquetasRenewalProduncionModel::query()->select('Radicado')->get()->max();

        if (empty($radicado)) {
            $radicado = 0;

            $EtiquetasGeneradas = DB::table('GetEtiquetasRenewalProduncion AS G')
                ->select(DB::raw('
                    G.id,
                    G.SemanaActual,
                    G.Fecha,
                    G.PlotIDNuevo,
                    G.PlotIDOrigen,
                    G.CodigoIntegracion,
                    CONCAT(GE.NombreGenero ,\' - \' , V.Nombre_Variedad) AS NombreVariedad,
                    G.Cantidad,
                    G.CantidadBolsillos,
                    CONCAT(G.Bloque,\'.\', G.Nave,\'.\',G.Cama) as Localizacion,
                    G.ProcedenciaInv,
                    G.Caja,
                    G.CodigoBarrasCaja,
                    G.SemanaCosecha,
                    G.CodigoBarras,
                    G.EsquejesXBolsillo
                '))
                ->join('URC_Variedades AS V', 'V.Codigo', '=', 'G.CodigoIntegracion')
                ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
                ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
                ->where('Radicado', $radicado)
                ->orderBy('G.id')
                ->get();
        } else {
            $radicado = GetEtiquetasRenewalProduncionModel::query()->select('Radicado')->get()->max();

            $EtiquetasGeneradas = DB::table('GetEtiquetasRenewalProduncion AS G')
                ->select(DB::raw('
                    G.id,
                    G.SemanaActual,
                    G.Fecha,
                    G.PlotIDNuevo,
                    G.PlotIDOrigen,
                    G.CodigoIntegracion,
                    CONCAT(GE.NombreGenero ,\' - \' , V.Nombre_Variedad) AS NombreVariedad,
                    G.Cantidad,
                    G.CantidadBolsillos,
                    CONCAT(G.Bloque,\'.\', G.Nave,\'.\',G.Cama) as Localizacion,
                    G.ProcedenciaInv,
                    G.Caja,
                    G.CodigoBarrasCaja,
                    G.SemanaCosecha,
                    G.CodigoBarras,
                    G.EsquejesXBolsillo
                '))
                ->join('URC_Variedades AS V', 'V.Codigo', '=', 'G.CodigoIntegracion')
                ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
                ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
                ->where('Radicado', $radicado->Radicado)
                ->orderBy('G.id')
                ->get();
        }
        return view('Propagacion.CargueRenewalProduccion', compact('Renewal', 'EtiquetasGeneradas'));
    }

    public function LoadInventoryRenewall(Request $request)
    {
        set_time_limit(0);
        $array = $request['Cargue_Renewal'];

        $spreadsheet = IOFactory::load($request['Cargue_Renewal']);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        $guardar = '';

        for ($i = 1; $i < count($sheetData); $i++) {
            $plotExiste = ProdInventarioRenewalsModel::query()->where('PlotIDNuevo', '=', $sheetData[$i]['A'])->first();
            if ($plotExiste) {
                return redirect(route('CargueInventarioRenewalProduccion'));
            }
        }
       // dd('algo paso')

        (new InventarioRenewalProduccionImport())->import($request->file('Cargue_Renewal'));

        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();


        $plots = ProdInventarioRenewalsModel::query()
            ->select([
                'PlotIDNuevo',
                'Cantidad'
            ])
            ->where('Semana', $SemanaEjecucion->AnoYSemana)
            ->where('Flag_Activo', 1)
            ->get();
        foreach ($plots as $plot) {
            RegistroPLotIDPropagacion::query()
                ->create([
                    'PlotId' => $plot->PlotIDNuevo,
                    'CantidaInicialPlantasProgramadas' => $plot->Cantidad,
                    'Flag_Activo' => 1,
                ]);
        }
        return redirect(route('CargueInventarioRenewalProduccion'));


    }

    public function GenerarEtiquetasRenewal(Request $request)
    {

        set_time_limit(0);

        $existe = ProdInventarioRenewalsModel::query()
            ->select('id')
            ->whereRaw('CONVERT(DATE, prod_inventario_renewals.created_at) = CONVERT (DATE, GETDATE())')
            ->whereRaw('prod_inventario_renewals.Flag_Activo = 1')
            ->first();

        if ($existe) {
            $EtiquetasRenewal = DB::statement('SET NOCOUNT ON; EXEC GetEtiquetasInventarioRenewall');
            return redirect(route('CargueInventarioRenewalProduccion'));
        } else {
            return redirect(route('CargueInventarioRenewalProduccion'));
        }

    }

    public function VistaEspacioPropagacion()
    {

        $espacios = DB::table('URCLecturaEntradaPropagacion AS ENTREPRO')
            ->join('URC_Propagacion AS PRO', 'PRO.id', '=', 'ENTREPRO.idUbicacion')
            ->select([
                'pro.Ubicacion',
                'pro.CapacidadBandejas',
                DB::raw('COUNT(idUbicacion) as cantidadBandejas'),
                DB::raw('(pro.CapacidadBandejas-COUNT(idUbicacion)) as Disponibilida')
            ])
            ->where('ENTREPRO.Flag_Activo', 1)
            ->groupBy('idUbicacion', 'CapacidadBandejas', 'Ubicacion')
            ->orderBy('idUbicacion')
            ->get();
        //dd($espacios);
        return view('Propagacion.EspacioPropagacion', compact('espacios'));
    }

    public function VistaLecturaDevolucionesPropagacion()
    {
        $causaleSalidas = URCCausalSalidaModel::query()
            ->select('id', 'CausalDescarte')
            ->whereIn('id', [13, 14, 15, 16, 17, 18, 19, 20, 21, 22])
            ->get();
        return view('Propagacion.LecturaDevoluciones', compact('causaleSalidas'));
    }

    public function LecturaDevolucionPropagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'idCausalDevolucion' => 'required',
                'CodigoBarras' => 'required',
            ]);
            $CodigoBarras = $request['CodigoBarras'];

            $existeGe = GetEtiquetasRenewalProduncionModel::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            $YaLeido = URCLecturaDevolucionPropagacionModel::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            // dd($existeGe,$YaLeido);

            if (empty($existeGe) || $YaLeido) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $patinador = auth()->user()->id_Empleado;
                URCLecturaDevolucionPropagacionModel::query()
                    ->create([
                        'id_Patinador' => $patinador,
                        'idCausalDevolucion' => $request->get('idCausalDevolucion'),
                        'CodigoBarras' => $request->get('CodigoBarras')
                    ]);
                return response()->json([
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaReportePropagacion()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        $Arqueo = DB::select('SET NOCOUNT ON; EXEC ArqueoPropagacion');
        //return response()->json(['data' => $Arqueo]);

        return view('Propagacion.ReporteInventario', compact('VariedadesActivas', 'Arqueo'));
    }

    public function VistaUpdateEtiqueta()
    {
        return view('Propagacion.consultarEtiqueta');
    }

    public function DetallesEtiqueta(Request $request)
    {
        if ($request->ajax()) {
            $consulta = DB::table('GetEtiquetasRenewalProduncion as GetEt')
                ->select(
                    ['vari.Nombre_Variedad',
                        'gen.NombreGenero',
                        'PlotIDNuevo',
                        'PlotIDOrigen',
                        'CodigoIntegracion',
                        'CodigoBarras',
                        'ProcedenciaInv',
                        'SemanaCosecha as SemaDespacho',

                    ])
                ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->where('GetEt.CodigoBarras', $request->get('CodigoBarras'))
                ->get();
            return response()->json([
                'Data' => $consulta,
            ]);
        }
    }

    public function UpdatePlotIdOrigen(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'PlotIDOrigenNuevo' => 'required',
                'ProcedenciaNueva' => 'required',
                'IdCodigoBarras' => 'required',
            ]);

            $consultaCodigo = GetEtiquetasRenewalProduncionModel::query()
                ->select('PlotIDNuevo', 'ProcedenciaInv')
                ->where('CodigoBarras', $request->get('IdCodigoBarras'))
                ->first();

            if ($consultaCodigo) {
                RenewallModificadosModel::query()
                    ->create([
                        'CodigoBarras' => $request->get('IdCodigoBarras'),
                        'PlotIdCargado' => $consultaCodigo->PlotIDNuevo,
                        'ProcedenciaCargada' => $consultaCodigo->ProcedenciaInv
                    ]);
                GetEtiquetasRenewalProduncionModel::query()
                    ->where('CodigoBarras', $request->get('IdCodigoBarras'))
                    ->update([
                        'PlotIDOrigen' => $request->get('PlotIDOrigenNuevo'),
                        'ProcedenciaInv' => $request->get('ProcedenciaNueva'),
                    ]);
                return response()->json([
                    'Data' => 1,
                ]);
            } else {
                return response()->json([
                    'Data' => 2,
                ]);
            }


        }
    }

    public function ReporteEntradaPropagacionEsta(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            /*$Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');*/
            $SemanaConsulta = $request->get('FechaInicial');
            $semanaIC = explode('-W', $SemanaConsulta);
            $year = $semanaIC[0];
            $week = $semanaIC[1];
            $fecha = $year . '' . $week;

            $ReporEntrada = DB::table('URCLecturaEntradaPropagacion as entra')
                ->select(
                    ['vari.Nombre_Variedad',
                        'gen.NombreGenero',
                        'PlotIDNuevo',
                        'CodigoIntegracion',
                        'pr.CantidaInicialPlantasProgramadas as Programadas',
                        'pr.CantidaPlantasPropagacionInicial as Ingresadas',
                        'pr.CantidaPlantasPropagacionInventario as actuales',
                        'ubi.Ubicacion'
                    ])
                ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
                ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('urcPropagacionsRegistroPlotID as pr', 'pr.PlotId', '=', 'GetEt.PlotIDNuevo')
                ->join('URC_Propagacion as ubi', 'ubi.id', '=', 'entra.idUbicacion')
                ->where('SemanaLectura', $fecha)
                /*  ->where(DB::raw('DATEPART (yy, entra.created_at)'), $year)
                  ->where(DB::raw('DATEPART (ISO_WEEK, entra.created_at)'), $week)*/
                ->where('entra.Flag_Activo', 1)
                ->groupBy('vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'CodigoIntegracion',
                    'pr.CantidaPlantasPropagacionInventario',
                    'pr.CantidaInicialPlantasProgramadas',
                    'pr.CantidaPlantasPropagacionInicial',
                    'Ubicacion'
                )
                ->get();
            //dd($ReporEntrada);
            return response()->json(['data' => $ReporEntrada]);

        }

    }

    public function ReporteSalidaPropagacionEsta(Request $request)
    {
        if ($request->ajax()) {
            /* $Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
             $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');*/
            //dd($Ffin);
            $SemanaConsulta = $request->get('FechaInicial');
            $semanaIC = explode('-W', $SemanaConsulta);
            $year = $semanaIC[0];
            $week = $semanaIC[1];

            $ReporSalida = DB::table('URCLecturaSalidaPropagacion as sali')
                ->select(
                    ['vari.Nombre_Variedad',
                        'gen.NombreGenero',
                        'PlotIDNuevo',
                        'CodigoIntegracion',
                        'SemanaCosecha as SemaDespacho',
                        'sali.SemanaLectura',
                        'sali.CantPlantas',
                    ])
                ->join('GetEtiquetasRenewalProduncion as GetEt', 'GetEt.PlotIDNuevo', '=', 'sali.PlotID')
                ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->where(DB::raw('DATEPART (yy, sali.created_at)'), $year)
                ->where(DB::raw('DATEPART (ISO_WEEK, sali.created_at)'), $week)
                ->where('sali.Flag_Activo', 1)
                ->groupBy('vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'CodigoIntegracion',
                    'SemanaCosecha',
                    'sali.CantPlantas',
                    'sali.SemanaLectura')
                ->get();
            return response()->json(['data' => $ReporSalida]);

        }
    }

    public function ReporteDescartesPropagacionEsta(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            /*$Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');*/
            //dd($Ffin);
            $SemanaConsulta = $request->get('FechaInicial');
            $semanaIC = explode('-W', $SemanaConsulta);
            $year = $semanaIC[0];
            $week = $semanaIC[1];

            $ReporDescarte = DB::table('URCLecturaDescartePropagacion as dess')
                ->select(
                    ['vari.Nombre_Variedad',
                        'gen.NombreGenero',
                        'PlotIDNuevo',
                        'Semana',
                        'cau.CausalDescarte',
                        DB::RAW('sum(dess.PlantasDescartadas) as PlantasDescartadas'),
                        DB::RAW('CONCAT(year(dess.created_at), DATEPART(ISO_WEEK, dess.created_at)) as SemanaDescarte')
                    ])
                ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'dess.PlotId')
                ->join('URC_CausalesDescartesPropagacion as cau', 'cau.id', '=', 'dess.CausalDescarte')
                ->join('URC_Variedades as vari', 'pro.CodigoIntegracion', '=', 'vari.Codigo')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->where(DB::raw('DATEPART (yy, dess.created_at)'), $year)
                ->where(DB::raw('DATEPART (ISO_WEEK, dess.created_at)'), $week)
                ->groupBy([
                    'PlotIDNuevo',
                    'Nombre_Variedad',
                    'cau.CausalDescarte',
                    'NombreGenero',
                    'Semana',
                    DB::RAW('CONCAT(year(dess.created_at), DATEPART(ISO_WEEK, dess.created_at))')
                ])
                ->get();
            return response()->json(['data' => $ReporDescarte]);

        }

    }

    public function ExportInventarioTotal()
    {
        set_time_limit(0);
        return Excel::download(new ExportReportePropagacionDescriminado(), 'Reporte Inventario-' . Carbon::now()->format('Y-m-d') . '.xlsx');

    }

    public function ExportInventarioAgrupado()
    {
        set_time_limit(0);
        return Excel::download(new ExportReportePropagacionAgrupado(), 'Reporte Inventario Agrupado-' . Carbon::now()->format('Y-m-d') . '.xlsx');

    }

    public function ExportSalidasPlot()
    {
        set_time_limit(0);
        return Excel::download(new ExportarSalidasPlotPropagacion(), 'Reporte Salidas-' . Carbon::now()->format('Y-m-d') . '.xlsx');

    }

    public function ExportInventarioDescartado()
    {
        set_time_limit(0);
        return Excel::download(new ExportarDescartesPlotPropagacion(), 'Reporte Descartes-' . Carbon::now()->format('Y-m-d') . '.xlsx');

    }

    public function VistaTablasMaestrasPropagacion()
    {
        $causalDescartes = URCCausalSalidaModel::all();
        return view('Propagacion.tablasMaestras', compact('causalDescartes'));
    }

    public function InactivarCausalDescarte($id)
    {
        //dd($id);
        $update = URCCausalSalidaModel::query()
            ->where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 0,
            ]);
        session()->flash('Inactivo', 'Inactivo');
        return back()->with('Inactivo', '');
    }

    public function ActivarCausalDescarte($id)
    {
        $update = URCCausalSalidaModel::query()
            ->where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 1,
            ]);
        session()->flash('Activado', 'Activado');
        return back()->with('Activado', '');
    }

    public function ModificarCausalDescarte(Request $request)
    {
        $update = URCCausalSalidaModel::query()
            ->where('id', $request->get('idCausal'))
            ->update([
                'CausalDescarte' => strtoupper($request->get('CausalDescarte')),
            ]);
        session()->flash('Modificado', 'Modificado');
        return back()->with('Modificado', '');
    }

    public function CrearCausalDescarte(Request $request)
    {
        $update = URCCausalSalidaModel::query()
            ->create([
                'CausalDescarte' => strtoupper($request->get('CausalDescarteN')),
                'Flag_Activo' => 1,
            ]);
        session()->flash('new', 'new');
        return back()->with('new', '');
    }

    public function VistaProgramasSemanalesRenewall()
    {


        $lunesuno = new Carbon('next monday');
        $date2 = $lunesuno->addDays(7);
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $date2)->first();

        $confirmaciones = urcPropagacionConfirmaciones::query()
            ->select(
                'urcPropagacionConfirmaciones.id',
                'GE.NombreGenero',
                'v.Codigo',
                'v.Nombre_Variedad',
                'gettR.PlotIDNuevo',
                'semanaConfirmacionModificada',
                'plantasconfirmadas',
                'Descargado',
                'CausalDescarte',
                'urcPropagacionConfirmaciones.Flag_Activo'
            )
            ->join('GetEtiquetasRenewalProduncion as gettR', 'gettR.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'gettR.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
            //->where('semanaConfirmacionModificada', '>=', $SemanaFinal)
            ->where('semanaConfirmacionModificada', '<=', $SemanaEjecucion->AnoYSemana)
            ->where('urcPropagacionConfirmaciones.Flag_Activo', '=', 1)
            ->groupBy([
                'urcPropagacionConfirmaciones.id',
                'GE.NombreGenero',
                'v.Nombre_Variedad',
                'v.Codigo',
                'gettR.PlotIDNuevo',
                'semanaConfirmacionModificada',
                'plantasconfirmadas',
                'urcPropagacionConfirmaciones.Flag_Activo',
                'Descargado',
                'CausalDescarte',
            ])
            ->get();

        //dd($ReporteProgramas);
        return view('Propagacion.ProgramasRenewall', compact('confirmaciones'));
    }

    public function ModificarConfirmacion(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'idItem' => 'required',
            'semanaEntregaUpdate' => 'required',
            'CausalMovimiento' => 'required',
        ]);

        $SemanaConsulta = $request->get('semanaEntregaUpdate');
        $semanaIC = explode('-W', $SemanaConsulta);
        $year = $semanaIC[0];
        $week = $semanaIC[1];

        $newweek = $year . '' . $week;
        // dd($newweek);
        $update = urcPropagacionConfirmaciones::query()
            ->where('id', $request->get('idItem'))
            ->update([
                'semanaConfirmacionModificada' => $newweek,
                'CausalMovimiento' => $request->get('CausalMovimiento'),
            ]);
        session()->flash('Modificado', 'Modificado');
        return back()->with('Modificado', '');
    }

    public function CancelarConfirmacion(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'idItemDelete' => 'required',
            'CausalCancelar' => 'required',
        ]);

        $update = urcPropagacionConfirmaciones::query()
            ->where('id', $request->get('idItemDelete'))
            ->update([
                'CausalDescarte' => $request->get('CausalCancelar'),
                'Flag_Activo' => 0,
            ]);

        //dd($update);
        session()->flash('Modificado', 'Modificado');
        return back()->with('Modificado', '');
    }

    public function VistaLecturaArqueoPropagacion()
    {
        $ubicaciones = URCPropagacionModel::all();
        return view('Propagacion.LecturaArqueo', compact('ubicaciones'));
    }

    public function LecturaArqueoProgpagacion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'idUbicacion' => 'required',
                'CantidadPlantas' => 'required',
                'PlotIdD' => 'required',
            ]);
            $plotid = $request->get('PlotIdD');
            $ubicacion = $request->get('idUbicacion');
            $CantidadPLantas = $request->get('CantidadPlantas');

            $yaleido = urcLecturaArqueoPropagacion::query()
                ->select('PlotId')
                ->where('PlotId', $plotid)
                ->first();

            $PLotExiste = GetEtiquetasRenewalProduncionModel::query()
                ->select('PlotIDNuevo')
                ->where('PlotIDNuevo', $plotid)
                ->first();

            //dd($PLotExiste);
            if ($yaleido || empty($PLotExiste)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $patinador = auth()->user()->id_Empleado;
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                urcLecturaArqueoPropagacion::query()
                    ->create([
                        'id_Patinador' => $patinador,
                        'idUbicacion' => $ubicacion,
                        'Plantas' => $CantidadPLantas,
                        'PlotId' => $plotid,
                        'Semana' => $SemanaEjecucion->AnoYSemana,
                    ]);
                $UltLectu = GetEtiquetasRenewalProduncionModel::CosultarPlotIdArqueo($request);

                return response()->json([
                    'data' => 1,
                    'consulta' => $UltLectu,
                ]);
            }
        }
    }

    public function LoadInventora(Request $request)
    {
        // dd($request->all());
        // Excel::import(new UrcProgramasweekRenewallImport, 'programassemanales.xlsx');
        //$array = Excel::toArray(new UrcProgramasweekRenewallImport, 'programassemanales.xlsx');
        DB::table('URCProgramasSemanalesRenewall')->truncate();
        (new UrcProgramasweekRenewallImport())->import($request->file('CargarProgramas'));

        return redirect(route('VistaProgramasSemanalesRenewall'));

    }

    public function ReporteEntradaPropagacionDianmico($FechaInicial)
    {
        //dd($FechaInicial, $FechaFinal);
        //$FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        //$FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');
        //dd($Ffin);

        $SemanaConsulta = $FechaInicial;
        $semanaIC = explode('-W', $SemanaConsulta);
        $year = $semanaIC[0];
        $week = $semanaIC[1];

        $semanaConsulta = $year . '' . $week;

        $ReporEntrada = DB::table('URCLecturaEntradaPropagacion as entra')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'PlotIDOrigen',
                    'CodigoIntegracion',
                    'entra.CodigoBarras',
                    'entra.created_at',
                    DB::raw('FORMAT(entra.created_at, \'yyyy-MM-dd\') as Fecha'),
                    'Ubicacion',
                    'ProcedenciaInv',
                    'SemanaCosecha as SemaDespacho',
                    'Plantas',
                    DB::raw(
                        'CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                       CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario'
                    )
                ])
            ->join('RRHH_empleados as Em', 'entra.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'entra.CodOperario')
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('URC_Propagacion as pro', 'pro.id', '=', 'entra.idUbicacion')
            //->whereBetween('entra.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->where('entra.SemanaLectura', $semanaConsulta)
            ->where('entra.Flag_Activo', 1)
            ->get();
        return response()->json(['data' => $ReporEntrada]);
    }

    public function ViewCancelacionRenewall()
    {


        //dd($fecha);
        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//$SemanaEjecucion->AnoYSemana


        $TPCancelaciones = TipoCancelacionRenewalModel::all();

        $cajas = DB::table('GetEtiquetasRenewalProduncion')
            ->select('Caja')
            ->where('Caja', '>', 0)
            ->where('SemanaActual', '=', $SemanaEjecucion->AnoYSemana)
            ->orderBy('Caja')
            //->havingRaw('MAX(DATEPART(ISO_WEEK,created_at)) = DATEPART(ISO_WEEK,GETDATE())')
            ->groupBy('Caja')
            ->get();
        // dd($cajas);

        return view('Propagacion.CancelacionRenewall', compact('cajas', 'TPCancelaciones'));
    }

    public function DetallesCajaCancelacionRenewall(Request $request)
    {
        $caja = $request->get('caja');

        $detallescaja = DB::table('GetEtiquetasRenewalProduncion as ETI')
            ->select(DB::raw('
                    ETI.Caja,
                    ETI.CodigoBarras,
                    CONCAT(G.NombreGenero,\' - \', V.Nombre_Variedad) AS NombreVariedad,
                    ETI.Bloque,
                    ETI.Nave,
                    ETI.Cama,
                    ETI.Flag_Activo
                '))
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
            ->where('ETI.Flag_Activo', '=', 1)
            ->where('ETI.Caja', $caja)
            ->havingRaw('MAX(DATEPART(ISO_WEEK,ETI.created_at)) = DATEPART(ISO_WEEK,GETDATE())')
            ->groupBy('ETI.Caja', 'ETI.CodigoBarras', 'G.NombreGenero', 'V.Nombre_Variedad',
                'ETI.Bloque', 'ETI.Nave', 'ETI.Cama', 'ETI.Flag_Activo')
            ->get();
        return response()->json([
            'Data' => $detallescaja,
        ]);
    }

    public function CancelacionRenewall(Request $request)
    {

        //dd($request->all());
        $array = $request['CheckedAK'];
        $user = auth()->user()->id_Empleado;
        for ($i = 0; $i < count($array); $i++) {

            $create = CancelacionesRenewalCodigosModel::query()
                ->create([
                    'idUser' => $user,
                    'idTipoCancelacion' => $request->get('TpCancelacion'),
                    'CodigoBarras' => $array[$i],
                ]);

            /* Actualiza tabla maestra */
            $tabla = GetEtiquetasRenewalProduncionModel::query()
                ->where([
                    'CodigoBarras' => $array[$i]
                ])
                ->update(['Flag_Activo' => 0]);
        }

        //dd($update);
        return response()->json([
            'data' => 1,
        ]);
    }

    public function ReporteAlistamientioPropagacionEsta(Request $request)
    {
        if ($request->ajax()) {
            /*$Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');*/
            //dd($Ffin);

            $SemanaConsulta = $request->get('FechaInicial');
            $semanaIC = explode('-W', $SemanaConsulta);
            $year = $semanaIC[0];
            $week = $semanaIC[1];

            $ReporEntrada = DB::table('URCLecturaEntradaPropagacion as entra')
                ->select(
                    ['vari.Nombre_Variedad',
                        'gen.NombreGenero',
                        'PlotIDNuevo',
                        'PlotIDOrigen',
                        'CodigoIntegracion',
                        'entra.CodigoBarras',
                        'entra.created_at',
                        DB::raw('FORMAT(entra.created_at, \'yyyy-MM-dd\') as Fecha'),
                        'CodigoBarrasCaja',
                        'Ubicacion',
                        'ProcedenciaInv',
                        'SemanaCosecha as SemaDespacho',
                        'Plantas',
                        DB::raw(
                            'CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                       CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario'
                        )
                    ])
                ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
                ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('URC_Propagacion as pro', 'pro.id', '=', 'entra.idUbicacion')
                ->join('urcLecturaAlistamientoPropagacion as alis', 'alis.CodigoBarras', '=', 'entra.CodigoBarras')
                ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'alis.CodOperario')
                ->join('RRHH_empleados as Em', 'alis.id_Patinador', '=', 'Em.id')
                //->whereBetween('alis.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->where(DB::raw('DATEPART (yy, alis.created_at)'), $year)
                ->where(DB::raw('DATEPART (ISO_WEEK, alis.created_at)'), $week)
                ->where('entra.Flag_Activo', 1)
                ->get();
            return response()->json(['data' => $ReporEntrada]);

        }
    }

    public function ReporteDevolucionPropagacionEsta(Request $request)
    {
        if ($request->ajax()) {
            $SemanaConsulta = $request->get('FechaInicial');
            $semanaIC = explode('-W', $SemanaConsulta);
            $year = $semanaIC[0];
            $week = $semanaIC[1];

            $ReporDevo = DB::table('urclecturaDevoculionPropagacion as dev')
                ->select(
                    ['vari.Nombre_Variedad',
                        'ca.CausalDescarte',
                        'GetEt.CodigoBarras',
                    ])
                ->join('GetEtiquetasRenewalProduncion as GetEt', 'dev.CodigoBarras', '=', 'GetEt.CodigoBarras')
                ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
                ->join('URC_CausalesDescartesPropagacion as ca', 'ca.id', '=', 'dev.idCausalDevolucion ')
                ->where(DB::raw('DATEPART (yy, dev.created_at)'), $year)
                ->where(DB::raw('DATEPART (ISO_WEEK, dev.created_at)'), $week)
                ->get();
            return response()->json(['data' => $ReporDevo]);

        }
    }

    public function IniciarArqueo(Request $request)
    {

        urcLecturaArqueoPropagacion::query()->truncate();
        $count = urcLecturaArqueoPropagacion::query()->count();
        if ($count === '0' || $count === 0) {
            return response()->json([
                'ok' => 1,
            ]);
        } else {
            return response()->json([
                'ok' => 2,
            ]);
        }

    }

    public function Estadoplotidentrega()
    {

        $estradoplotsids = GetEtiquetasRenewalProduncionModel::EstadoPlotIdentregas();

        //dd($estradoplotsids);
        return view('Propagacion.Estadoplotidentrega', compact('estradoplotsids'));
    }

    public function ExportConfirmacionesEntregadas()
    {
        set_time_limit(0);
        return Excel::download(new ExportConfirmacionesEntregadas(), 'Reporte Confirmaciones-' . Carbon::now()->format('Y-m-d') . '.xlsx');

    }

    public function VistaEntregasNovedadesRenewall()
    {
        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

        $plots = RegistroPLotIDPropagacion::query()
            ->select('PlotId')
            ->where('Flag_Activo', 1)
            ->get();

        $causalesFito = ModelCausalesFitosanidad::all();

        $plotNovedades = ModelPlotsDesmarque::query()
            ->select('URCPropagacionPlotDesmarque.PlotID',
                'Codigo',
                'Nombre_Variedad',
                'NombreGenero',
                'NombreEspecie',
                'CantidadPlantas')
            ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'URCPropagacionPlotDesmarque.PlotID')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'pro.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
            ->where('SemanaCreacion', $SemanaEjecucion->AnoYSemana)
            ->get();
        return view('Propagacion.NovedadesDesmarquesPlot', compact('plots', 'plotNovedades', 'causalesFito'));
    }

    public function newNovedadRenewall(Request $request)
    {

        $request->validate([
            'plot' => 'required',
            'causalDesmarque' => 'required',
            'CantidadPlantas' => 'required',
        ]);

        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

        $usuario = auth()->user()->id_Empleado;

        $create = ModelPlotsDesmarque::query()
            ->create([
                'PlotID' => $request->get('plot'),
                'CausalDesmarte' => $request->get('causalDesmarque'),
                'CantidadPlantas' => $request->get('CantidadPlantas'),
                'SemanaCreacion' => $SemanaEjecucion->AnoYSemana,
                'IdUsuario' => $usuario,
            ]);

        if ($create->save()) {
            return redirect()->route('VistaEntregasNovedadesRenewall')->with('Exitoso', '');
        } else {
            return redirect()->route('VistaEntregasNovedadesRenewall')->with('error', '');
        }

        //return dd('a');


    }
}
