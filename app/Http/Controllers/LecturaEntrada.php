<?php

namespace App\Http\Controllers;

use App\Model\Empleados;
use App\Model\FichaTecnicaEmpleados;
use App\Model\GetEtiquetasLabInventario;
use App\Model\LabCuartos;
use App\Model\LabEstante;
use App\Model\LabLecturaEntrada;
use App\Model\LabLecturaSalida;
use App\Model\LabNivel;
use App\Model\ModelAnoSemana;
use App\Model\ModelResultadoMuestrasFitopatologia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class LecturaEntrada extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function readinginput()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();


        return view('Laboratorio.LecturaEntrada', compact('cuartosAc'));
    }

    public function SelectCuarto($id)
    {
        $LabEstante = LabEstante::where('id_Cuarto', $id)->get();
        return response()->json(['Data' => $LabEstante]);
    }

    public function SelectEstante($id)
    {
        $labpiso = LabNivel::where('id_Estante', $id)->get();
        return response()->json(['Data' => $labpiso]);
    }

    public function LecturaEntrada(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'IDCuarto' => 'required',
                'IDEstante' => 'required',
                'IDPiso' => 'required',
                'Operario' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];

            $existeBarcode = LabLecturaEntrada::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $UbiExis = DB::table('GetEtiquetasLabInventario as GetEti')
                ->select('GetEti.CantContenedor',
                    'GetEti.Indentificador',
                    'GetEti.Barcode',
                    'GetEti.ID_FaseActual'
                )
                ->where('GetEti.BarCode', $request->get('Barcode'))
                ->first();


            if ($existeBarcode || $ExisBarcoSalida) {
                return response()->json([
                    'data' => 0,
                ]);
            } else if (empty($UbiExis)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {

                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();



                $UltLectu = Empleados::PatinadoresUltimalectura($request);
                $patinador = auth()->user()->id_Empleado;

                LabLecturaEntrada::create([
                    'id_Patinador' => $patinador,
                    'id_Cuarto' => $request['IDCuarto'],
                    'id_estante' => $request['IDEstante'],
                    'id_piso' => $request['IDPiso'],
                    'Plantas' => $UbiExis->CantContenedor,
                    'CodigoBarras' => $request['Barcode'],
                    'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE CAMBIAR
                    'CodOperario' => $request['Operario'],
                    'Flag_Activo' => 1,
                ]);
                if ($UbiExis->ID_FaseActual === '11') {
                    $UltimoRegistromuetras = ModelResultadoMuestrasFitopatologia::Query()
                        ->where('Identificador', $UbiExis->Indentificador)
                        ->first();
                    if ($UltimoRegistromuetras === null) {

                        ModelResultadoMuestrasFitopatologia::Query()
                            ->create([
                                'Identificador' => $UbiExis->Indentificador,
                                'CodigoBarras' => $UbiExis->Barcode,
                                'SemanaActual' => $SemanaEjecucion->AnoYSemana,
                                'MuestrasScreen' => 'N/A',
                                'PositivosMuestrasScreen' => 'N/A',
                                'AgroRhodoPruebaUno' => 'N/A',
                                'AgroRhodoPruebaDos' => 'N/A',
                                'AgroRhodoPruebaTres' => 'N/A',
                                'AgroRhodoPruebaCuatro' => 'N/A',
                            ]);
                    } else {
                        //dd('no null');
                        $UltimoRegistromuetras = ModelResultadoMuestrasFitopatologia::Query()
                            ->where('Identificador', $UbiExis->Indentificador)
                            ->first();

                        //dd($UltimoRegistromuetras);
                        if ($UltimoRegistromuetras->ResultadoIndex === NULL && $UltimoRegistromuetras->MuestrasScreen === 'N/A') {
                            ModelResultadoMuestrasFitopatologia::Query()
                                ->create([
                                    'Identificador' => $UbiExis->Indentificador,
                                    'CodigoBarras' => $UbiExis->Barcode,
                                    'SemanaActual' => $SemanaEjecucion->AnoYSemana,
                                    'MuestrasScreen' => 'N/A',
                                    'PositivosMuestrasScreen' => 'N/A',
                                    'AgroRhodoPruebaUno' => 'N/A',
                                    'AgroRhodoPruebaDos' => 'N/A',
                                    'AgroRhodoPruebaTres' => 'N/A',
                                    'AgroRhodoPruebaCuatro' => 'N/A',
                                ]);
                        } else {
                            ModelResultadoMuestrasFitopatologia::Query()
                                ->create([
                                    'Identificador' => $UbiExis->Indentificador,
                                    'CodigoBarras' => $UbiExis->Barcode,
                                    'SemanaActual' => $SemanaEjecucion->AnoYSemana,
                                    'ResultadoIndex' => 'OK',
                                    'AgroRhodoPruebaUno' => 'N/A',
                                    'AgroRhodoPruebaDos' => 'N/A',
                                    'AgroRhodoPruebaTres' => 'N/A',
                                    'AgroRhodoPruebaCuatro' => 'N/A',
                                ]);
                        }
                    }

                } elseif ($UbiExis->ID_FaseActual === '12') {
                    $UltimoRegistromuetras = ModelResultadoMuestrasFitopatologia::Query()
                        ->where('Identificador', $UbiExis->Indentificador)
                        ->first();
                    if ($UltimoRegistromuetras === null) {
                        ModelResultadoMuestrasFitopatologia::Query()
                            ->create([
                                'Identificador' => $UbiExis->Indentificador,
                                'CodigoBarras' => $UbiExis->Barcode,
                                'SemanaActual' => $SemanaEjecucion->AnoYSemana,
                                'ResultadoIndex' => 'N/A',
                                'MuestrasScreen' => 'N/A',
                                'PositivosMuestrasScreen' => 'N/A',
                                'AgroRhodoPruebaDos' => 'N/A',
                                'AgroRhodoPruebaTres' => 'N/A',
                                'AgroRhodoPruebaCuatro' => 'N/A',
                            ]);
                    }
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
