<?php

namespace App\Http\Controllers;

use App\Model\CargueEtiquetasPro;
use App\Model\Empleados;
use App\Model\GetEtiquetasRenewalProduncionModel;
use App\Model\ModelEntradaCuartoMonitore;
use App\Model\ModelEntradaSalidaPersonalMonitoreo;
use App\Model\ModelLecturaControlMonitoreo;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoreoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function VistaLecturaEntradaCuarto()
    {
        return view('Monitoreo.LecturaEntradaCuarto');
    }

    public function DatosLecturaEntradaCuarto(Request $request)
    {
        //CargueEtiquetasPro
        // dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'Barcode' => 'required',
            ]);
            $CodigoBarras = $request['Barcode'];
            $letrabarcode = $CodigoBarras[0];

            //dd($letrabarcode);

            if ($letrabarcode === 'A') {
                $CodigoCargado = CargueEtiquetasPro::select('CodigoBarras')
                    ->where('CodigoBarras', $CodigoBarras)
                    ->first();

                $YaRegistrado = ModelEntradaCuartoMonitore::select('CodigoBarras')
                    ->where('CodigoBarras', $CodigoBarras)
                    ->first();

                if (empty($CodigoCargado) || $YaRegistrado) {
                    return response()->json([
                        'data' => 0,
                    ]);
                    //dd('if');
                } else {
                    // dd('else');

                    $patinador = auth()->user()->id_Empleado;

                    $Exito = ModelEntradaCuartoMonitore::create([
                        'CodigoBarras' => $CodigoBarras,
                        'IdUsers' => $patinador,
                        'Flag_Activo' => 1,
                    ]);

                    //dd($Exito);
                    $UltLectu = ModelEntradaCuartoMonitore::UltimaLecturaEntradaCuartoMonitoreo($request);
                    return response()->json([
                        'consulta' => $UltLectu,
                        'barcode' => $CodigoBarras,
                        'data' => 1,
                    ]);
                }
            } else {

                $renewallExite = GetEtiquetasRenewalProduncionModel::select('CodigoBarras')
                    ->where('CodigoBarras', $CodigoBarras)
                    ->first();

                $YaRegistrado = ModelEntradaCuartoMonitore::select('CodigoBarras')
                    ->where('CodigoBarras', $CodigoBarras)
                    ->first();

                if (empty($renewallExite) || $YaRegistrado) {
                    return response()->json([
                        'data' => 0,
                    ]);
                    //dd('if');
                } else {
                    // dd('else');

                    $patinador = auth()->user()->id_Empleado;

                    $Exito = ModelEntradaCuartoMonitore::create([
                        'CodigoBarras' => $CodigoBarras,
                        'IdUsers' => $patinador,
                        'Flag_Activo' => 1,
                    ]);

                    //dd($Exito);
                    $UltLectu = ModelEntradaCuartoMonitore::UltimaLecturaEntradaCuartoMonitoreoR($request);
                    return response()->json([
                        'consulta' => $UltLectu,
                        'barcode' => $CodigoBarras,
                        'data' => 1,
                    ]);
                }
            }
        }
    }

    public function VistaControlEntradaMonitoreoOperario()
    {
        return view('Monitoreo.LecturaInicioOperacion');
    }

    public function DatosControlEntradaMonitoreoOperario(Request $request)
    {

        if ($request->ajax()) {
            $request->validate([
                'CodOperario' => 'required',
            ]);

            $date = Carbon::today();
            $date = $date->format('Y-d-m 00:00:00.000');

            $CodOperario = $request['CodOperario'];

            $CodigoCargado = Empleados::all()
                ->where('Codigo_Empleado', $CodOperario)
                ->first();

            $YaRegistrado = ModelEntradaSalidaPersonalMonitoreo::all()
                ->where('CodigoEmpleado', $CodOperario)
                ->where('created_at', '>=', $date)
                ->first();

            // dd($YaRegistrado);


            if (empty($CodigoCargado) || $YaRegistrado) {
                return response()->json([
                    'data' => 2,
                ]);
                //dd('if');
            } else {
                // dd('else');

                $patinador = auth()->user()->id_Empleado;

                $Exito = ModelEntradaSalidaPersonalMonitoreo::create([
                    'CodigoEmpleado' => $CodOperario,
                    'IDPatinadorEntrada' => $patinador,
                    'Flag_ActivoEntrada' => 1

                ]);

                return response()->json([
                    'consulta' => $CodigoCargado,
                    'data' => 1,
                ]);
            }
        }

    }

    public function VistaControlFinMonitoreoOperario()
    {
        return view('Monitoreo.LecturaFinOperacion');
    }

    public function DatosControlFinMonitoreoOperario(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'CodOperario' => 'required',
            ]);

            $date = Carbon::today();
            $date = $date->format('Y-d-m 00:00:00.000');
            $CodOperario = $request['CodOperario'];


            $YaRegistrado = ModelEntradaSalidaPersonalMonitoreo::all()
                ->where('CodigoEmpleado', $CodOperario)
                ->where('created_at', '>=', $date)
                ->where('Flag_ActivoEntrada', '=', 1)
                ->first();

            if (empty($YaRegistrado)) {
                return response()->json([
                    'data' => 0,
                ]);
                //dd('if');
            } else {
                // dd('else');z
                $patinador = auth()->user()->id_Empleado;
                $Exito = ModelEntradaSalidaPersonalMonitoreo::
                where('CodigoEmpleado', $CodOperario)
                    ->where('created_at', '>=', $date)
                    ->where('Flag_ActivoEntrada', '=', 1)
                    ->update([
                        'Flag_ActivoEntrada' => 0,
                        'IDPatinadorSalida' => $patinador,
                    ]);
                $CodigoCargado = Empleados::all()
                    ->where('Codigo_Empleado', $CodOperario)
                    ->first();
                return response()->json([
                    'consulta' => $CodigoCargado,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaLecturaInicioMonitoreo()
    {
        return view('Monitoreo.LecturaEntradaMonitoreo');
    }

    public function DatosLecturaInicioMonitoreo(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'Operario' => 'required',
                'Barcode' => 'required',
            ]);
            $CodigoBarras = $request['Barcode'];

            $YaRegistrado = ModelLecturaControlMonitoreo::select('CodigoBarras')
                ->where('CodigoBarras', $CodigoBarras)
                ->first();

            if ($YaRegistrado) {
                return response()->json([
                    'data' => 0,
                ]);
                //dd(
            } else {
                $inicial = substr($CodigoBarras, -9, 1);
                if ($inicial === 'A') {

                    $Produccion = CargueEtiquetasPro::all()
                        ->where('CodigoBarras', $CodigoBarras)
                        ->first();

                    if (empty($Produccion)) {
                        return response()->json([
                            'data' => 0,
                        ]);
                        //dd(
                    } else {
                        $patinador = auth()->user()->id_Empleado;
                        $Exito = ModelLecturaControlMonitoreo::create([
                            'CodigoBarras' => $CodigoBarras,
                            'CodOperarioRevision' => $request['Operario'],
                            'IdPatinadorEntrada' => $patinador,
                            'Flag_ActivoEntrada' => 1,
                        ]);
                        $UltLectu = ModelLecturaControlMonitoreo::UltimaLecturaInicioMonitoreoProduccion($request);
                        return response()->json([
                            'consulta' => $UltLectu,
                            'barcode' => $CodigoBarras,
                            'data' => 1,
                        ]);
                    }


                } else {
                    $Renewall = GetEtiquetasRenewalProduncionModel::all()
                        ->where('CodigoBarras', $CodigoBarras)
                        ->first();

                    if (empty($Renewall)) {
                        return response()->json([
                            'data' => 0,
                        ]);
                        //dd(
                    } else {
                        $patinador = auth()->user()->id_Empleado;
                        $Exito = ModelLecturaControlMonitoreo::create([
                            'CodigoBarras' => $CodigoBarras,
                            'CodOperarioRevision' => $request['Operario'],
                            'IdPatinadorEntrada' => $patinador,
                            'Flag_ActivoEntrada' => 1,
                        ]);

                        $UltLectu = ModelLecturaControlMonitoreo::UltimaLecturaInicioMonitoreoRenewall($request);
                        return response()->json([
                            'consulta' => $UltLectu,
                            'barcode' => $CodigoBarras,
                            'data' => 1,
                        ]);
                    }


                }
            }
        }
    }

    /*salida*/


    public function VistaLecturaSalidaMonitoreo()
    {
        return view('Monitoreo.LecturaSalidaMonitoreo');
    }

    public function DatosLecturaSalidaMonitoreo(Request $request)
    {
        if ($request->ajax()) {
            $request->validate([
                'Barcode' => 'required',
            ]);
            $CodigoBarras = $request['Barcode'];

            $YaRegistrado = ModelLecturaControlMonitoreo::select('CodigoBarras')
                ->where('CodigoBarras', $CodigoBarras)
                ->where('Flag_ActivoEntrada', 1)
                ->first();

            if (empty($YaRegistrado)) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $patinador = auth()->user()->id_Empleado;
                $Exito = ModelLecturaControlMonitoreo::
                where('CodigoBarras', $CodigoBarras)
                    ->update([
                        'Flag_ActivoEntrada' => 0,
                        'IdPatinadorSalida' => $patinador
                    ]);

                $inicial = substr($CodigoBarras, -9, 1);
                if ($inicial === 'A') {
                    $UltLectu = ModelLecturaControlMonitoreo::UltimaLecturaSalidaMonitoreoProduccion($request);
                } else {
                    $UltLectu = ModelLecturaControlMonitoreo::UltimaLecturaInicioMonitoreoRenewall($request);
                }
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $CodigoBarras,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaReportesMonitoreos()
    {
        return view('Monitoreo.ReportesControlMonitoreo');
    }

    public function ReporteEstandarMonitoreo(Request $request)
    {
        $FechaIni = (new Carbon($request->get('FechaInicial')))->format('Y-d-m 00:00');
        $FechaFin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m 23:59');

        $reporteGeneralC = DB::select('exec ReporteEstandarMonitoreo ?,?', array($FechaIni, $FechaFin));

        return response()->json(['data' => $reporteGeneralC]);
    }

    public function ReporteEstandarMonitoreoDespacho(Request $request)
    {
        // dd($request->all());
        $FechaIni = (new Carbon($request->get('FechaInicial')))->format('Y-d-m 00:00:00');
        $FechaFin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m 23:59:59');

        $entro = ModelEntradaCuartoMonitore::query()
            ->select('vari.Nombre_Variedad',
                'gen.NombreGenero', 'NombreEspecie', 'vari.Codigo', 'LecturaEntradaCuartoMonitoreo.CodigoBarras', 'LecturaEntradaCuartoMonitoreo.Flag_Activo')
            ->join('CargueEtiquetasPros as cr', 'cr.CodigoBarras', '=', 'LecturaEntradaCuartoMonitoreo.CodigoBarras')
            ->join('URC_Variedades as vari', 'cr.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->whereBetween('LecturaEntradaCuartoMonitoreo.created_at', [$FechaIni, $FechaFin])
            ->get();

        return response()->json(['data' => $entro]);


    }

    public function ReporteRendimeintoMonitoreo(Request $request)
    {
        // dd($request->all());
        $FechaIni = (new Carbon($request->get('FechaInicial')))->format('Y-d-m 00:00');
        $FechaFin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m 23:59');

        $monitoreoRenewall = ModelLecturaControlMonitoreo:: Query()
            ->select('LecturaControlMonitoreo.CodigoBarras',
                'vari.Nombre_Variedad',
                'gen.NombreGenero',
                'vari.Codigo',
                'Flag_ActivoEntrada',
                'LecturaControlMonitoreo.created_at',
                'LecturaControlMonitoreo.updated_at',
                DB::raw('CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as Monitor')
            )
            ->join('GetEtiquetasRenewalProduncion as gtr', 'gtr.CodigoBarras', '=', 'LecturaControlMonitoreo.CodigoBarras')
            ->join('URC_Variedades as vari', 'gtr.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('RRHH_empleados as Em', 'LecturaControlMonitoreo.CodOperarioRevision', '=', 'Em.Codigo_Empleado')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->whereBetween('LecturaControlMonitoreo.created_at', [$FechaIni, $FechaFin]);

        $monitoreoDespa = ModelLecturaControlMonitoreo:: Query()
            ->select('LecturaControlMonitoreo.CodigoBarras',
                'vari.Nombre_Variedad',
                'gen.NombreGenero',
                'vari.Codigo',
                'Flag_ActivoEntrada',
                'LecturaControlMonitoreo.created_at',
                'LecturaControlMonitoreo.updated_at',
                DB::raw('CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as Monitor')
            )
            ->join('CargueEtiquetasPros as gtr', 'gtr.CodigoBarras', '=', 'LecturaControlMonitoreo.CodigoBarras')
            ->join('URC_Variedades as vari', 'gtr.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('RRHH_empleados as Em', 'LecturaControlMonitoreo.CodOperarioRevision', '=', 'Em.Codigo_Empleado')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->unionAll($monitoreoRenewall)
            ->whereBetween('LecturaControlMonitoreo.created_at', [$FechaIni, $FechaFin])
           // ->where('LecturaControlMonitoreo.CodigoBarras','A05777475')
            ->get();

        //dd($monitoreoDespa);

        return response()->json(['data' => $monitoreoDespa]);
    }
}
