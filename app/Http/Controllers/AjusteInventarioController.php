<?php

namespace App\Http\Controllers;

use App\Model\Empleados;
use App\Model\LabCuartos;
use App\Model\LabLecturaAjusteInv;
use App\Model\LabLecturaEntrada;
use App\Model\LabLecturaSalida;
use App\Model\LabTipSalida_AjusteInvetario;
use App\Model\ModelAnoSemana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjusteInventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AjusteInventario()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        $TipInventarios = DB::table('LabTipSalida_AjusteInvetarios')
            ->select('id', 'TipoSalida_Ajuste')
            ->whereIn('id', [2, 3])->get();

        //dd($TipInventarios);

        $patinadores = Empleados::PatinadoresActivos();
        return view('Laboratorio.AjusteInventario', compact('cuartosAc', 'patinadores', 'TipInventarios'));
    }

    public function LecAjusteInventarioTraslado(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'id_TipoSalidaT' => 'required',
                'IDCuartoT3' => 'required',
                'IDEstanteT3' => 'required',
                'IDPisoT3' => 'required',
                'BarcodeT' => 'required',
            ]);

            $barcode = $request['BarcodeT'];
            $lecturaEntrada = LabLecturaEntrada::query()->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $YaUbicado = LabLecturaEntrada::query()->select('id_Cuarto','id_estante','id_piso')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $existeBarcode = LabLecturaAjusteInv::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $UltLectu = Empleados::SAjusteinvTraslado($request);

            if (empty($lecturaEntrada)) {
                return response()->json([
                    'data' => 2,
                ]);
            }else if($YaUbicado->id_Cuarto===$request['IDCuartoT3'] && $YaUbicado->id_estante===$request['IDEstanteT3'] && $YaUbicado->id_piso===$request['IDPisoT3'] ){
                return response()->json([
                    'data' => 0,
                ]);
            }
            else if ($existeBarcode && $lecturaEntrada) {
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
//'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE

                LabLecturaEntrada::where('CodigoBarras', $barcode)
                    ->update([
                        'id_Patinador' => $patinador,
                        'id_Cuarto' => $request['IDCuartoT3'],
                        'id_estante' => $request['IDEstanteT3'],
                        'id_piso' => $request['IDPisoT3'],
                    ]);
                LabLecturaAjusteInv::where('CodigoBarras', $barcode)
                    ->update([
                        'Flag_Activo' => 0
                    ]);

                LabLecturaAjusteInv::create([
                    'id_Patinador' => $patinador,
                    'id_TipoSalida' => $request['id_TipoSalidaT'],
                    'id_Cuarto' => $request['IDCuartoT3'],
                    'id_estante' => $request['IDEstanteT3'],
                    'id_piso' => $request['IDPisoT3'],
                    'CodigoBarras' => $request['BarcodeT'],
                    'Flag_Activo' => 1,
                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                ]);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            } else if (empty($existeBarcode) && $lecturaEntrada) {
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                LabLecturaEntrada::where('CodigoBarras', $barcode)
                    ->update([
                        'id_Patinador' => $patinador,
                        'id_Cuarto' => $request['IDCuartoT3'],
                        'id_estante' => $request['IDEstanteT3'],
                        'id_piso' => $request['IDPisoT3'],
                    ]);

                LabLecturaAjusteInv::create([
                    'id_Patinador' => $patinador,
                    'id_TipoSalida' => $request['id_TipoSalidaT'],
                    'id_Cuarto' => $request['IDCuartoT3'],
                    'id_estante' => $request['IDEstanteT3'],
                    'id_piso' => $request['IDPisoT3'],
                    'CodigoBarras' => $request['BarcodeT'],
                    'Flag_Activo' => 1,
                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                ]);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }

        }
    }

    public function LecAjusteInventarioRetorno(Request $request)
    {
        //dd($request->all());
        $patinador = auth()->user()->id_Empleado;
        if ($request->ajax()) {
            $request->validate([
                'id_TipoSalidaR' => 'required',
                'IDCuarto2' => 'required',
                'IDEstante2' => 'required',
                'IDPiso2' => 'required',
                'BarcodeR' => 'required',
            ]);

            $barcode = $request['BarcodeR'];

            $lecturaEntrada = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();

            $lecturaSalida = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->wherein('id_TipoSalida', [7,8])
                ->where('Flag_Activo', 1)
                ->first();
            //dd($lecturaEntrada, $lecturaSalida);
            $UltLectu = Empleados::RetornoInventario($request);

            if (empty($lecturaEntrada) || empty($lecturaSalida)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                LabLecturaEntrada::
                query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'id_Cuarto' => $request['IDCuarto2'],
                        'id_estante' => $request['IDEstante2'],
                        'id_piso' => $request['IDPiso2'],
                        'Flag_Activo' => 1,
                    ]);
                LabLecturaSalida::
                query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Flag_Activo' => 0,
                    ]);

                LabLecturaAjusteInv::create([
                    'id_Patinador' => $patinador,
                    'id_TipoSalida' => $request['id_TipoSalidaR'],
                    'id_Cuarto' => $request['IDCuarto2'],
                    'id_estante' => $request['IDEstante2'],
                    'id_piso' => $request['IDPiso2'],
                    'CodigoBarras' => $request['BarcodeR'],
                    'Flag_Activo' => 1,
                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE

                ]);

                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);

            }
        }
    }
}
