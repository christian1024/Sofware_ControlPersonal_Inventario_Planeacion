<?php

namespace App\Http\Controllers;

use App\Model\ClientesLab;
use App\Model\GetEtiquetasLabInventario;
use App\Model\LabCuartos;
use App\Model\LabEtiquetasMigradas;
use App\Model\LabLecturaEntrada;
use EtiquetasMigradas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class CambioEtiquetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewCambioEtiqueta()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        $clientes = ClientesLab::query()->select('id', 'Nombre', 'Indicativo')->where('Flag_Activo', '=', 1)->get();
        return view('Laboratorio.CambioEtiqueta', compact('cuartosAc', 'clientes'));
    }

    public function CargarProgramas(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $Programas = DB::table('LabLecturaEntradas')
                ->select(
                    [DB::raw(
                        'GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                LabLecturaEntradas.id_Cuarto,
                                LabLecturaEntradas.id_estante,
                                LabLecturaEntradas.id_piso,
                                sum(GetEtiquetasLabInventario.CantContenedor)as CantidadPlantas,
                                GetEtiquetasLabInventario.ID_FaseActual'
                    )
                    ])
                ->join('GetEtiquetasLabInventario', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
                ->where('LabLecturaEntradas.id_Cuarto', $request->get('Cuarto'))
                ->where('LabLecturaEntradas.id_estante', $request->get('Estante'))
                ->where('LabLecturaEntradas.id_piso', $request->get('Nivel'))
                ->where('LabLecturaEntradas.Flag_Activo', '=', 1)
                ->groupBy(
                    [DB::raw('GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                LabLecturaEntradas.id_Cuarto,
                                LabLecturaEntradas.id_estante,
                                LabLecturaEntradas.id_piso,
                                GetEtiquetasLabInventario.ID_FaseActual')])
                ->get();
            //dd($Programas);
            return response()->json([
                'Data' => $Programas,
            ]);
        }
    }

    public function Detallesprogramas(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $datoEntrada = $request->get('valor');
            $cuarto = $request->get('Cuarto');
            $estante = $request->get('estante');
            $nivel = $request->get('nivel');
            $DatoCompleto = explode(',', $datoEntrada);
            // dd($DatoCompleto);
            $dato1 = $DatoCompleto[0];
            $dato2 = $DatoCompleto[1];
            $dato3 = $DatoCompleto[2];
            $dato4 = $DatoCompleto[3];
            $dato5 = $DatoCompleto[4];

            //dd($dato2);
            if ($dato3 === 'null' || empty($dato3) || $dato3 === NULL) {
                //dd('en');
                $dato3 = null;
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
                ->join('LabLecturaEntradas', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
                ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'GetEtiquetasLabInventario.ID_FaseActual')
                ->where('GetEtiquetasLabInventario.CodigoVariedad', $dato1)
                ->where('GetEtiquetasLabInventario.Indentificador', $dato2)
                ->where('GetEtiquetasLabInventario.SemanaDespacho', $dato3)
                ->where('GetEtiquetasLabInventario.SemanUltimoMovimiento', $dato4)
                ->where('LabLecturaEntradas.id_Cuarto', '=', $cuarto)
                ->where('LabLecturaEntradas.id_estante', '=', $estante)
                ->where('LabLecturaEntradas.id_piso', '=', $nivel)
                ->where('GetEtiquetasLabInventario.ID_FaseActual', '=', $dato5)
                ->where('LabLecturaEntradas.Flag_Activo', '=', 1)
                ->get();

            //dd($DetallesPrograma);
            return response()->json([
                'Data' => $DetallesPrograma,
            ]);
        }

    }

    public function MigrarEtiqueta(Request $request)
    {


        $EnviarStock = $request->get('EnviarStock');
        $EnviarMultiplicacion = $request->get('EnviarMultiplicacion');
        $EnviarEnraizamiento = $request->get('EnviarEnraizamiento');
        //dd($request->all());
        if ($EnviarStock === '1') {
            return $this->MoverEtqStock($request->all());
        }
        if ($EnviarMultiplicacion === '2') {
            return $this->MoverEtqMultiplicacion($request->all());
        }
        if ($EnviarEnraizamiento === '3') {
            return $this->MoverEtqEnraizamiento($request->all());
        }

        return false;
    }

    public function MoverEtqStock($request)
    {

        $array = $request['CheckedAK'];
        $radicado = DB::table('LabEtiquetasMigradas')->max('CodigoRadicado');
        $radicado++;
        for ($i = 0; $i < count($array); $i++) {

            $consulta = GetEtiquetasLabInventario::query()->where('Barcode', $array[$i])->first();

            /* isnerta en una tabla control */
            $create = LabEtiquetasMigradas::query()
                ->create([
                    'CodigoBarras' => $consulta->BarCode,
                    'SemanaDespacho' => $consulta->SemanaDespacho,
                    'FaseActual' => $consulta->ID_FaseActual,
                    'Identificador' => $consulta->Indentificador,
                    'cliente' => $consulta->cliente,
                    'NewFaseActual' => 5,
                    'Impresa' => 0,
                    'CodigoRadicado' => $radicado
                ]);

            /* Actualiza tabla maestra */
            $update = GetEtiquetasLabInventario::query()
                ->where('Barcode', $array[$i])
                ->update([
                    'SemanaDespacho' => NULL,
                    'cliente' => NULL,
                    'ID_FaseActual' => 5,
                ]);
        }

        //dd($update);
        return response()->json([
            'data' => 1,
            'request' => $array,
        ]);
    }

    public function MoverEtqMultiplicacion($request)
    {
        //dd($request);
        $radicado = DB::table('LabEtiquetasMigradas')->max('CodigoRadicado');
        $radicado++;
        $semdespacho = $request['week'];
        $array = $request['CheckedAK'];
        $semanaD = explode('-W', $semdespacho);
        $dato1 = $semanaD[0];
        $dato2 = $semanaD[1];
        $SemanaDespacho = $dato1 . '' . $dato2;

        $cliente = ClientesLab::query()->select('Indicativo')->where('id', $request['cliente'])->first();

        for ($i = 0; $i < count($array); $i++) {

            $consulta = GetEtiquetasLabInventario::query()->where('Barcode', $array[$i])->first();
            /* isnerta en una tabla control */
            $create = LabEtiquetasMigradas::query()
                ->create([
                    'CodigoBarras' => $consulta->BarCode,
                    'SemanaDespacho' => $consulta->SemanaDespacho,
                    'FaseActual' => $consulta->ID_FaseActual,
                    'Identificador' => $consulta->Indentificador,
                    'cliente' => $consulta->cliente,
                    'NewFaseActual' => 6,
                    'Impresa' => 0,
                    'CodigoRadicado' => $radicado
                ]);
            /* Actualiza tabla maestra */
            $update = GetEtiquetasLabInventario::query()
                ->where('Barcode', $array[$i])
                ->update([
                    'SemanaDespacho' => $SemanaDespacho,
                    'cliente' => $cliente->Indicativo,
                    'ID_FaseActual' => 6,
                ]);
        }
        //dd($update);
        return response()->json([
            'data' => 1,
            'request' => $array,
        ]);

    }

    public function MoverEtqEnraizamiento($request)
    {
        $radicado = DB::table('LabEtiquetasMigradas')->max('CodigoRadicado');
        $radicado++;
        $semdespacho = $request['week'];
        $array = $request['CheckedAK'];


        for ($i = 0; $i < count($array); $i++) {

            $cliente = ClientesLab::query()->select('Indicativo')->where('id', $request['cliente'])->first();

            $semanaD = explode('-W', $semdespacho);
            $dato1 = $semanaD[0];
            $dato2 = $semanaD[1];
            $SemanaDespacho = $dato1 . '' . $dato2;

            $consulta = GetEtiquetasLabInventario::query()
                ->where('Barcode', $array[$i])
                ->first();
            /* isnerta en una tabla control */
            $create = LabEtiquetasMigradas::query()
                ->create([
                    'CodigoBarras' => $consulta->BarCode,
                    'SemanaDespacho' => $consulta->SemanaDespacho,
                    'FaseActual' => $consulta->ID_FaseActual,
                    'Identificador' => $consulta->Indentificador,
                    'cliente' => $consulta->cliente,
                    'NewFaseActual' => 7,
                    'Impresa' => 0,
                    'CodigoRadicado' => $radicado
                ]);
            /* Actualiza tabla maestra */
            $update = GetEtiquetasLabInventario::query()
                ->where('Barcode', $array[$i])
                ->update([
                    'SemanaDespacho' => $SemanaDespacho,
                    'cliente' => $cliente->Indicativo,
                    'ID_FaseActual' => 7,
                ]);
        }
        //dd($update);
        return response()->json([
            'data' => 1,
            'request' => $array,
        ]);
    }

    public function ImprimirEtiquetasMigradas(Request $request)
    {

        $array = explode(',', $request->get('Datos'));

        for ($i = 0; $i < count($array); $i++) {

            /* Actualiza tabla maestra */
            $update = LabEtiquetasMigradas::query()
                ->where('CodigoBarras', $array[$i])
                ->update([
                    'Impresa' => 1,
                ]);
        }
        $impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'URC_Generos.NombreGenero',
                DB::raw('GetEtiquetasLabInventario.ID_FaseActual AS FaseActual'))
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->wherein('GetEtiquetasLabInventario.Barcode',
                $array
            )
            ->orderBy('GetEtiquetasLabInventario.BarCode', 'ASC')
            ->get();

        //dd($impresion);
        $pdf = PDF::loadView('barcode', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();
        return $pdf->stream('barcode.pdf');
        //return view('prueba');
    }


}
