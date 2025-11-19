<?php

namespace App\Http\Controllers;

use App\Imports\cargueInventarioImport;
use App\Imports\ImportEtiquetasProduccion;
use App\Imports\ImportsConfirmacionesSiembrasURC;
use App\Model\CargueEtiquetasPro;
use App\Model\GetEtiquetasInventarioProduccionModel;
use App\Model\GetEtiquetasRenewalProduncionModel;
use App\Model\LecturaEntradaCF;
use App\Model\ModelAnoSemana;
use App\Model\ModelConfirmacionesCargueUrc;
use App\Model\ModelPlotsDesmarque;
use App\Model\ProdInventarioRenewalsModel;
use App\Model\ProdLecturaEntradaProduccionCF;
use App\Model\ProdLecturaEntradaRenewals;
use App\Model\ProdLecturaSalidaProduccionCF;
use App\Model\ProdLecturaSalidaRenewals;
use App\Model\urcPropagacionConfirmaciones;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function LecturaEntradaProduccionView()
    {

        return view('Produccion.LecturaEntradaCFProduccion');
    }

    public function LecturaEntradaCFProd(Request $request)
    {
        //dd($request->all());

        //$barcode = $request['Barcode'];
        $barcode = $request->Barcode;
        $letrabarcode = $barcode[0];

        if ($letrabarcode === "A") {
            $existebarcode = ProdLecturaEntradaProduccionCF::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeinventario = GetEtiquetasInventarioProduccionModel::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ultimalectura = DB::table('GetEtiquetasInventarioProduccion as Rev')
                ->join('URC_Variedades as Var', 'var.Codigo', '=', 'Rev.Cod_Integracion_Ventas')
                ->where('Rev.CodigoBarras', '=', $barcode)
                ->select('Var.Nombre_Variedad', 'Rev.NumeroCaja AS Caja', 'Rev.id')
                ->first();

            //dd($ultimalectura);

            if ($existebarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else if (empty($existeinventario)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                ProdLecturaEntradaProduccionCF::create([
                    'CodigoBarras' => $barcode,
                    'idGetEtiquetas' => $ultimalectura->id,
                    'ID_Usuario' => auth()->user()->id_Empleado,
                    'Flag_Activo' => 1,
                ]);

                return response()->json([
                    'ultimalectura' => $ultimalectura,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        } else {
            $CodLavandulas = DB::table('GetEtiquetasRenewalProduncion')
                ->select('GetEtiquetasRenewalProduncion.CodigoBarras')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasRenewalProduncion.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.ID', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.ID', '=', 'URC_Especies.Id_Genero')
                ->where('CodigoBarras', $barcode)
                ->where('URC_Generos.NombreGenero', '=', 'LAVANDULA')
                ->get();

            $CodRosmarinus = DB::table('GetEtiquetasRenewalProduncion')
                ->select('CodigoBarras')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasRenewalProduncion.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.ID', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.ID', '=', 'URC_Especies.Id_Genero')
                ->where('CodigoBarras', $barcode)
                ->where('URC_Generos.NombreGenero', '=', 'ROSMARINUS')
                ->get();

            $CodLITHODORA = DB::table('GetEtiquetasRenewalProduncion')
                ->select('CodigoBarras')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasRenewalProduncion.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.ID', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.ID', '=', 'URC_Especies.Id_Genero')
                ->where('CodigoBarras', $barcode)
                ->where('URC_Generos.NombreGenero', '=', 'LITHODORA')
                ->get();

            $existebarcode = ProdLecturaEntradaRenewals::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeinventario = GetEtiquetasRenewalProduncionModel::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ultimalectura = DB::table('GetEtiquetasRenewalProduncion as Rev')
                ->join('URC_Variedades as Var', 'var.Codigo', '=', 'Rev.CodigoIntegracion')
                ->where('Rev.CodigoBarras', '=', $barcode)
                ->select('Var.Nombre_Variedad', 'Rev.Caja', 'Rev.id')
                ->first();

            //dd($ultimalectura);

            if ($existebarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else if (empty($existeinventario)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else if (count($CodLavandulas) >= 1) {
                return response()->json([
                    'data' => 3,
                ]);
            } else if (count($CodRosmarinus) >= 1) {
                return response()->json([
                    'data' => 4,
                ]);
            } else if (count($CodLITHODORA) >= 1) {
                return response()->json([
                    'data' => 5,
                ]);
            } else {
                ProdLecturaEntradaRenewals::create([
                    'CodigoBarras' => $barcode,
                    'idGetEtiquetas' => $ultimalectura->id,
                    'ID_Usuario' => auth()->user()->id_Empleado,
                    'Flag_Activo' => 1,
                ]);

                return response()->json([
                    'ultimalectura' => $ultimalectura,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function LecturaSalidaRenewalProduccionView()
    {

        return view('Produccion.LecturaSalidaRenewalProduccion');
    }

    public function LecturaSalidaRenewalCFProd(Request $request)
    {
        //dd($request->all());
        //$barcode = $request['BarcodeCaja'];
        $barcodeCaja = $request->BarcodeCaja;
        $barcode = $request->Barcode;
        $letrabarcode = $barcode[0];

        if ($letrabarcode === "R") {

            $numerocaja = GetEtiquetasRenewalProduncionModel::select('CodigoBarrasCaja')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $noleido = ProdLecturaEntradaRenewals::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existebarcode = ProdLecturaSalidaRenewals::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeinventario = GetEtiquetasRenewalProduncionModel::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ultimalectura = DB::table('GetEtiquetasRenewalProduncion as Rev')
                ->join('URC_Variedades as Var', 'var.Codigo', '=', 'Rev.CodigoIntegracion')
                ->where('Rev.CodigoBarras', '=', $barcode)
                ->where('Rev.Flag_Activo', 1)
                ->select('Var.Nombre_Variedad', 'Rev.Caja', 'Rev.id')
                ->first();

            if ($numerocaja->CodigoBarrasCaja === $barcodeCaja) {
                if (empty($noleido)) {
                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);
                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 3,
                    ]);
                } else if ($existebarcode) {
                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 0,
                    ]);
                } else if (empty($existeinventario)) {
                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 2,
                    ]);
                } else {
                    ProdLecturaSalidaRenewals::create([
                        'CodigoBarras' => $barcode,
                        'idGetEtiquetas' => $ultimalectura->id,
                        'ID_TipoSalida' => 2,
                        'ID_Usuario' => auth()->user()->id_Empleado,
                        'Flag_Activo' => 1,
                    ]);

                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'ultimalectura' => $ultimalectura,
                        'data' => 1,
                    ]);
                }
            } else {
                return response()->json([
                    'data' => 5,
                ]);
            }

        } else if ($letrabarcode === "A") {


            $numerocaja = GetEtiquetasInventarioProduccionModel::select('CodigoBarrasCaja')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $noleido = ProdLecturaEntradaProduccionCF::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $doshoras = GetEtiquetasInventarioProduccionModel::select('TiempoCF')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            /*$timpoCF = ProdLecturaEntradaProduccionCF::select(DB::raw('DATEDIFF (MINUTE,created_at,GETDATE()) AS TIEMPOENCF'))
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();*/

            $timpoCF = DB::table('prod_lectura_entrada_produccion_CF AS EN')
                ->select(DB::raw('DATEDIFF (MINUTE,max(EN.created_at),GETDATE()) AS TIEMPOENCF'))
                ->join('GetEtiquetasInventarioProduccion AS ETI1', 'ETI1.CodigoBarras', '=', 'EN.CodigoBarras')
                ->where('ETI1.CodigoBarrasCaja', $numerocaja->CodigoBarrasCaja)
                ->first();

            $existebarcode = ProdLecturaSalidaProduccionCF::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeinventario = GetEtiquetasInventarioProduccionModel::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ultimalectura1 = DB::table('GetEtiquetasInventarioProduccion as Rev')
                ->join('URC_Variedades as Var', 'var.Codigo', '=', 'Rev.Cod_Integracion_Ventas')
                ->where('Rev.CodigoBarras', '=', $barcode)
                ->select('Var.Nombre_Variedad', 'Rev.NumeroCaja as Caja', 'Rev.id')
                ->first();
            //dd($barcodeCaja, $numerocaja->CodigoBarrasCaja);
            if ($numerocaja->CodigoBarrasCaja === $barcodeCaja) {

                if (empty($noleido)) {

                    //return $this->DetalleCajaSalidaProdCF($request->all());

                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 3,
                    ]);
                } else if ($existebarcode) {

                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 0,
                    ]);
                } else if (empty($existeinventario)) {
                    $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                    return response()->json([
                        'detallecaja' => $detallecaja,
                        'data' => 2,
                    ]);
                } else {

                    if ($timpoCF->TIEMPOENCF > $doshoras->TiempoCF) {
                        ProdLecturaSalidaProduccionCF::create([
                            'CodigoBarras' => $barcode,
                            'idGetEtiquetas' => $ultimalectura1->id,
                            'ID_TipoSalida' => 1,
                            'ID_Usuario' => auth()->user()->id_Empleado,
                            'Flag_Activo' => 1,
                        ]);

                        $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                        return response()->json([
                            'detallecaja' => $detallecaja,
                            'ultimalectura' => $ultimalectura1,
                            'data' => 1,
                        ]);
                    } else {
                        //dd($doshoras);
                        $detallecaja = GetEtiquetasRenewalProduncionModel::DetalleCajaSalidaCF($numerocaja->CodigoBarrasCaja);

                        return response()->json([
                            'detallecaja' => $detallecaja,
                            'data' => 4,
                        ]);
                    }
                }
            } else {
                //dd($barcodeCaja);
                return response()->json([
                    'data' => 5,
                ]);
            }
        } else {
            //dd($barcode);
            $ultimalectura2 = DB::table('GetEtiquetasInventarioProduccion as Rev')
                ->join('URC_Variedades as Var', 'var.Codigo', '=', 'Rev.id_Variedad')
                ->where('Rev.CodigoBarrasCaja', '=', $barcode)
                ->select('Var.Nombre_Variedad', 'Rev.NumeroCaja as Caja', 'Rev.id')
                ->first();

            $detallecaja = DB::table('GetEtiquetasInventarioProduccion AS ETI')
                ->select(DB::raw('
                    ETI.NumeroCaja,
                    V.Nombre_Variedad,
                    COUNT(ETI.CodigoBarras) AS CantNecesaria,
                    COUNT(EN.CodigoBarras) AS CantInventario,
                    COUNT(SA.CodigoBarras) AS CantEmpacada
               '))
                ->leftJoin('prod_lectura_entrada_produccion_CF AS EN', 'EN.CodigoBarras', '=', 'ETI.CodigoBarras')
                ->leftJoin('prod_lectura_salida_produccion_CF AS SA', 'SA.CodigoBarras', '=', 'ETI.CodigoBarras')
                ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.id_variedad')
                ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
                ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
                ->where('ETI.CodigoBarrasCaja', $barcode)
                ->groupByRaw('
                    ETI.NumeroCaja,
	                V.Nombre_Variedad
                    ')
                ->get();

            return response()->json([
                'detallecaja' => $detallecaja,
                'ultimalectura2' => $ultimalectura2,
                'data' => 1,
            ]);

        }
    }

    public function VistaEstadoCajasRenewal()
    {
        return view('Produccion.ReporteRenewalProduccion');
    }

    public function ConsultaEstadoCajasRenewal(Request $request)
    {
        set_time_limit(0);


        $Semana = $request->get('semana');

        $semanaP = explode('-W', $Semana);
        $dato1 = $semanaP[0];
        $dato2 = $semanaP[1];
        $SemanaConsulta = $dato1 . '' . $dato2;

        //dd($SemanaConsulta);

        $Consulta = DB::table('GetEtiquetasRenewalProduncion AS ETI')
            ->select(DB::raw('
                ETI.Caja,
                (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                    INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                    INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                    INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                    WHERE ETI1.Flag_Activo = 1  AND ETI1.Caja = ETI.Caja AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') AS CantInventario,
                COUNT(ER.CodigoBarras) AS CantEntradas,
                COUNT(SR.CodigoBarras) AS CantSalidas,
                (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                    INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                    INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                    INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                    WHERE ETI1.Flag_Activo = 0  AND ETI1.Caja = ETI.Caja AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') as Cancelados,
                CASE
                    WHEN (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.Caja = ETI.Caja AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ')
                        = COUNT(ER.CodigoBarras) AND COUNT(SR.CodigoBarras) < COUNT(ER.CodigoBarras) THEN \'Lista Para Entregar\'
                    WHEN (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.Caja = ETI.Caja AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ')
                        = COUNT(ER.CodigoBarras) AND COUNT(SR.CodigoBarras) = COUNT(ER.CodigoBarras) THEN \'Entregada\'
                    WHEN COUNT(ER.CodigoBarras) <
                        (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.Caja = ETI.Caja AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') THEN \'Pendiente\'
                END AS EstadoCaja
            '))
            ->leftJoin('prod_lectura_entrada_renewals AS ER', 'ER.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->leftJoin('prod_lectura_salida_renewals AS SR', 'SR.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
            ->where('ETI.Caja', '>', 0)
            ->where('G.NombreGenero', '<>', 'LAVANDULA')
            ->where('G.NombreGenero', '<>', 'ROSMARINUS')
            ->where('G.NombreGenero', '<>', 'LITHODORA')
            ->where('eti.SemanaActual', '=', $SemanaConsulta)
            ->groupBy('ETI.Caja')
            ->get();

        return response()->json(['data' => $Consulta]);

    }

    public function ConsultaDetallesCajasRenewal(Request $request)
    {
        //dd($request->all());
        $Semana = $request->get('semana');

        $semanaP = explode('-W', $Semana);
        $dato1 = $semanaP[0];
        $dato2 = $semanaP[1];
        $SemanaConsulta = $dato1 . '' . $dato2;

        //dd($SemanaConsulta);

        $DetallesCaja = DB::table('GetEtiquetasRenewalProduncion AS ETI')
            ->select(DB::raw(
                'ETI.Caja,
                ETI.CodigoBarras,
                CONCAT(G.NombreGenero, \' - \', V.Nombre_Variedad) AS NombreVariedad,
                (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                    INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                    INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                    INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                    WHERE ETI1.Flag_Activo = 1  AND ETI1.CodigoBarras = ETI.CodigoBarras AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') AS CantInventario,
                COUNT(ER.CodigoBarras) AS CantEntradas,
                COUNT(SR.CodigoBarras) AS CantSalidas,
                (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                    INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                    INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                    INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                    WHERE ETI1.Flag_Activo = 0  AND ETI1.CodigoBarras = ETI.CodigoBarras AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') as Cancelados,
                CASE
                    WHEN COUNT(ER.CodigoBarras) <>
                            (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.CodigoBarras = ETI.CodigoBarras AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ') THEN \'Pendiente\'
                    WHEN COUNT(ER.CodigoBarras) =
                            (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.CodigoBarras = ETI.CodigoBarras AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ')
                        AND COUNT(ER.CodigoBarras) <> COUNT(SR.CodigoBarras) THEN \'Recibido\'
                    WHEN COUNT(ER.CodigoBarras) =
                            (SELECT COUNT(ETI1.CodigoBarras) FROM GetEtiquetasRenewalProduncion ETI1
                            INNER JOIN URC_Variedades V ON V.Codigo = ETI1.CodigoIntegracion
                            INNER JOIN URC_Especies E ON E.id = V.ID_Especie
                            INNER JOIN URC_Generos G ON G.id = E.Id_Genero
                            WHERE ETI1.Flag_Activo = 1  AND ETI1.CodigoBarras = ETI.CodigoBarras AND G.NombreGenero <> \'LAVANDULA\' AND G.NombreGenero <> \'ROSMARINUS\' AND G.NombreGenero <> \'LITHODORA\' AND ETI1.SemanaActual = ' . $SemanaConsulta . ')
                        AND COUNT(ER.CodigoBarras) = COUNT(SR.CodigoBarras) AND COUNT(ER.CodigoBarras) > 0 THEN \'Entregado\'
                    ELSE \'Cancelado\'
                END AS ESTADOBOLSILLO,
                ETI.Bloque,
                ETI.Nave,
                ETI.Cama,
                IT.Tamano_Esqueje'
            ))
            ->leftJoin('prod_lectura_entrada_renewals AS ER', 'ER.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->leftJoin('prod_lectura_salida_renewals AS SR', 'SR.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
            ->join('prod_informacion_tecnica_variedades AS IT', 'IT.Codigo_Integracion', '=', 'ETI.CodigoIntegracion')
            ->groupBy('ETI.Caja',
                'ETI.CodigoBarras',
                'ETI.Bloque',
                'ETI.Nave',
                'ETI.Cama',
                'G.NombreGenero',
                'V.Nombre_Variedad',
                'IT.Tamano_Esqueje',
                'ETI.Flag_Activo')
            ->orderByRaw('ETI.Bloque,
                ETI.Nave,
                ETI.Cama')
            ->where('G.NombreGenero', '<>', 'LAVANDULA')
            ->where('G.NombreGenero', '<>', 'ROSMARINUS')
            ->where('G.NombreGenero', '<>', 'LITHODORA')
            ->where('ETI.Caja', '=', $request->get('data'))
            ->where('eti.SemanaActual', '=', $SemanaConsulta)
            //->whereRaw('CONCAT(DATEPART(YEAR,eti.created_at),DATEPART(ISO_WEEK,eti.created_at)) = ' . $SemanaConsulta . '')
            ->get();

        return response()->json(['data' => $DetallesCaja]);
    }

    public function VistaEstadoCajasDespacho()
    {
        return view('Produccion.ReporteCajasDespachoProd');
    }


    /*PLAN B*/
    public function VistaCargueEtiquetas()
    {
        $totalRegistro = CargueEtiquetasPro::query()->count();
        return view('Produccion.CargueEtiquetas', compact('totalRegistro'));
    }

    public function LoadInventoryEtq(Request $request)
    {
        set_time_limit(0);
        (new ImportEtiquetasProduccion())->import($request->file('LoadInventoryEtq'));
        return redirect(route('VistaCargueEtiquetas'));
    }

    public function Truncatetable(Request $request)
    {
        CargueEtiquetasPro::query()->truncate();
        $count = CargueEtiquetasPro::query()->count();
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

    public function VistaLecturaEntradaCuarto()
    {
        return view('Produccion.LecturaEntradaCuartoFrio');
    }

    public function VistaLecturaSalidaCuarto()
    {
        return view('Produccion.LecturaSalidaCuartoFrio');
    }

    public function LecturaEntradaCuarto(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'CodigoBarras' => 'required',
            ]);
            $codigoBarras = $request->get('CodigoBarras');

            $existeEtiqueta = CargueEtiquetasPro::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $codigoBarras)
                ->first();

            $ExisteLeida = LecturaEntradaCF::query()
                ->where('CodigoBarras', $codigoBarras)
                ->first();

            $patinador = auth()->user()->id_Empleado;

            if (empty($existeEtiqueta)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else if ($ExisteLeida) {
                return response()->json([
                    'data' => 3,
                ]);
            } else {
                LecturaEntradaCF::query()
                    ->create([
                        'Idpatinador' => $patinador,
                        'CodigoBarras' => $codigoBarras,
                        'Flag_Activo' => 1,
                    ]);

                return response()->json([
                    'CodigoBarras' => $codigoBarras,
                    'data' => 1,
                ]);
            }
        }
    }

    public function LecturaSalidaCuarto(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'CodigoBarras' => 'required',
                'CodigoBarrasCaja' => 'required',
            ]);
            $CodigoBarrasCaja = $request->get('CodigoBarrasCaja');
            $CodigoBarras = $request->get('CodigoBarras');

            $TieneEntrada = LecturaEntradaCF::query()
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            $EstadoCaja = CargueEtiquetasPro::query()
                ->select(
                    [DB::raw('
                    count(lecturaEntradaCuartoFrios.CodigoBarras) as CountEntrada,
                    count(CargueEtiquetasPros.CodigoBarras) as CountTotal
                    ')]
                )
                ->join('lecturaEntradaCuartoFrios', 'lecturaEntradaCuartoFrios.CodigoBarras', '=', 'CargueEtiquetasPros.CodigoBarras', 'left outer')
                ->where('CodigoBarrasCaja', $CodigoBarrasCaja)
                ->groupBy('CodigoBarrasCaja')
                ->get();

            dd($EstadoCaja);

        }
    }


    /********************************************SIEMBRAS***************************************************************/
    public function ReporteSiembrasConfirmadas()
    {

        $lunesuno = new Carbon('monday');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $lunesuno)->first();

        $Users = auth()->user()->id_Empleado;
        //dd($Users);
        if ($Users === '1943') {//fredy
            $siembras = urcPropagacionConfirmaciones::query()
                ->select([
                    'inf.Bloque_siembra_Producción',
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->join('GetEtiquetasRenewalProduncion as gt', 'gt.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'gt.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
                ->leftJoin('URCLecturaSalidaPropagacion as sl', 'sl.PlotID', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_informacion_tecnica_variedades as inf', 'inf.Codigo_Integracion', '=', 'URC_Variedades.Codigo')
                //->where('semanaConfirmacionModificada',202133)
                ->whereIn('semanaConfirmacionModificada', [$SemanaEjecucion->AnoYSemana])
                ->whereIn('inf.Bloque_siembra_Producción', ['6', '8', '9', '14', '15'])
                ->groupBy([
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'inf.Bloque_siembra_Producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->get();
        } elseif ($Users === '2004') {
            $siembras = urcPropagacionConfirmaciones::query()
                ->select([
                    'inf.Bloque_siembra_Producción',
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->join('GetEtiquetasRenewalProduncion as gt', 'gt.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'gt.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
                ->leftJoin('URCLecturaSalidaPropagacion as sl', 'sl.PlotID', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_informacion_tecnica_variedades as inf', 'inf.Codigo_Integracion', '=', 'URC_Variedades.Codigo')
                //->where('semanaConfirmacionModificada',202133)
                ->whereIn('semanaConfirmacionModificada', [$SemanaEjecucion->AnoYSemana])
                ->whereIn('inf.Bloque_siembra_Producción', ['1', '2', '3', '4', '7','7E'])
                ->groupBy([
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'inf.Bloque_siembra_Producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->get();
        } else {
            $siembras = urcPropagacionConfirmaciones::query()
                ->select([
                    'inf.Bloque_siembra_Producción',
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->join('GetEtiquetasRenewalProduncion as gt', 'gt.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'gt.CodigoIntegracion')
                ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
                ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
                ->leftJoin('URCLecturaSalidaPropagacion as sl', 'sl.PlotID', '=', 'urcPropagacionConfirmaciones.PlotId')
                ->join('prod_informacion_tecnica_variedades as inf', 'inf.Codigo_Integracion', '=', 'URC_Variedades.Codigo')
                //->where('semanaConfirmacionModificada',202133)
                ->whereIn('semanaConfirmacionModificada', [$SemanaEjecucion->AnoYSemana])
                ->groupBy([
                    'urcPropagacionConfirmaciones.PlotId',
                    'Codigo',
                    'plantasconfirmadas',
                    'pro.Legalizar',
                    'Nombre_Variedad',
                    'NombreGenero',
                    'urcPropagacionConfirmaciones.semanaConfirmacionModificada',
                    'NombreEspecie',
                    'pro.Procedencia',
                    'Plantas_X_Canastilla',
                    'inf.Horas_luz_producción',
                    'inf.Bloque_siembra_Producción',
                    'tipo_de_bandeja',
                    'urcPropagacionConfirmaciones.Flag_Activo'
                ])
                ->get();
        }
        return view('Produccion.ReporteConfirmacionSiembras', compact('siembras'));
    }


    public function Viewcarguesiembrasurc()
    {

        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

        $datos = ModelConfirmacionesCargueUrc::query()
            ->select(
                'URCConfirmacionesCargueUrc.*',
                'pr.SemanaCosecha')
            ->leftJoin('prod_inventario_renewals as pr', 'pr.PlotIDNuevo', '=', 'URCConfirmacionesCargueUrc.PlotID')
            ->where('SemanaCargue', $SemanaEjecucion->AnoYSemana)
            ->get();
        return view('Produccion.carguesiembrasurc', compact('datos'));
    }

    public function Carguesiembrasurc(Request $request)
    {
        set_time_limit(0);
        (new ImportsConfirmacionesSiembrasURC())->import($request->file('cargueconfirmaciones'));
        return redirect(route('Viewcarguesiembrasurc'));

    }

    public function ViewSiembrasProximasEntregas()
    {

        $lunesuno = new Carbon('next monday');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $lunesuno)->first();

        $siembrasFutura = ProdInventarioRenewalsModel::query()
            ->select(
                'pr.PlotId',
                'Codigo',
                'Nombre_Variedad',
                'NombreGenero',
                'NombreEspecie',
                'inf.Bloque_siembra_Producción',
                'prod_inventario_renewals.Procedencia',
                'Plantas_X_Canastilla',
                'inf.Horas_luz_producción',
                'tipo_de_bandeja'
            )
            ->join('urcPropagacionsRegistroPlotID as pr', 'pr.PlotId', '=', 'prod_inventario_renewals.PlotIDNuevo')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'prod_inventario_renewals.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
            ->join('prod_informacion_tecnica_variedades as inf', 'inf.Codigo_Integracion', '=', 'V.Codigo')
            ->where('prod_inventario_renewals.SemanaCosecha', $SemanaEjecucion->AnoYSemana)
            ->where('pr.Flag_Activo', 1)
            ->get();

        $dateA = Carbon::now();
        $dateMasSema = $dateA->format('Y-m-d');
        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();


        $novedadesSemanaActual = ModelPlotsDesmarque::query()
            ->select(
                'pro.PlotIDNuevo',
                'Codigo',
                'Nombre_Variedad',
                'NombreGenero',
                'NombreEspecie',
                'inf.Bloque_siembra_Producción',
                'pro.Procedencia',
                'Plantas_X_Canastilla',
                'inf.Horas_luz_producción',
                'tipo_de_bandeja')
            ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'URCPropagacionPlotDesmarque.PlotID')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'pro.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
            ->join('prod_informacion_tecnica_variedades as inf', 'inf.Codigo_Integracion', '=', 'V.Codigo')
            ->where('SemanaCreacion', $SemanaEjecucion->AnoYSemana)
            ->get();

        return view('Produccion.SiembrasProximasEntregas', compact('siembrasFutura', 'novedadesSemanaActual'));

    }
}

