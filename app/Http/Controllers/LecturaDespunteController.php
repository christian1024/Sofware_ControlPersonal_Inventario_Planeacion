<?php

namespace App\Http\Controllers;

use App\Model\Empleados;
use App\Model\LabCambioFaseCh;
use App\Model\LabLecturaAjusteInv;
use App\Model\LabLecturaEntrada;
use App\Model\LabLecturaSalida;
use App\Model\LecturaDespunteModel;
use App\Model\ModelAnoSemana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class LecturaDespunteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewLecturaDespunte()
    {
        return view('Laboratorio.LecturaDespunte');
    }

    public function DetallesDespunte(Request $request)
    {
        //dd($request->all());
        $date = new Carbon('yesterday');
        $date2 = $date->format('Y-d-m 05:00:00.000');
        $semanaDespacho = $request->get('SemanaDespachoDespunte');
        $cliente = $request->get('clienteDespunte');


        if (empty($semanaDespacho)) {
            $semanaDespacho = null;
        }
        if (empty($cliente)) {
            $cliente = null;
        }
        $DetallesIntroduccion = DB::table('LabLecturaDespunte as DE')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'DE.CodigoBarras')
            ->join('URC_Variedades as varr', 'varr.Codigo', '=', 'ETI.CodigoVariedad')
            ->select([
                'DE.CodigoBarras',
                'varr.Nombre_Variedad',
                'ETI.TipoContenedor',
                'ETI.SemanaDespacho',
                'ETI.CantContenedor',
                'ETI.Cliente',
            ])
            ->where('ETI.Indentificador', '=', $request->get('valorDespunte'))
            ->where('ETI.ID_FaseActual', '=', $request->get('faseDespunte'))
            ->where('ETI.SemanaDespacho', '=', $semanaDespacho)
            ->where('ETI.cliente', '=', $cliente)
            ->where('DE.Flag_Activo', '=', 1)
            ->where('DE.updated_at', '>=', $date2)
            ->get();
        //dd($DetallesIntroduccion);
        return response()->json([
            'datos' => $DetallesIntroduccion,
        ]);
    }

    public function LecturaEntradaDespunte(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $patinador = auth()->user()->id_Empleado;
            $request->validate([
                'Operario' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];

            $UltLectu = Empleados::PatinadoresUltimalectura($request);
            $UbiExis = DB::table('GetEtiquetasLabInventario as GetEti')
                ->select(
                    [DB::raw(
                        'GetEti.id,
                        GetEti.CantContenedor,
                        GetEti.Barcode,
                        CONCAT
                        (Cuar.N_Cuarto, \'.\', Estan.N_Estante, \'.\', Niv.N_Nivel) as Ubicacion'
                    )
                    ])
                ->join('lab_cuartos as Cuar', 'Cuar.id', '=', 'GetEti.id_Cuarto', 'left outer')
                ->join('lab_estantes as Estan', 'Estan.id', '=', 'GetEti.id_Estante', 'left outer')
                ->join('lab_nivels as Niv', 'Niv.id', '=', 'GetEti.id_Nivel', 'left outer')
                ->where('GetEti.BarCode', $request->get('Barcode'))
                ->first();

            $TieneSalidaAc = LabLecturaSalida::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $request->get('Barcode'))
                ->where('Flag_Activo', 1)
                ->first();

            $existeBarcodeInac = LabLecturaSalida::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 0)
                ->first();

            $dateA = Carbon::now();
            $dateMasSema = $dateA->format('Y-m-d');
            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

            if ($UbiExis && empty($TieneSalidaAc)) {
                if ($existeBarcodeInac) {
                    LecturaDespunteModel::create([
                        'id_Patinador' => $patinador,
                        'CodigoBarras' => $request['Barcode'],
                        'CodOperario' => $request['Operario'],
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                    ]);
                    LabLecturaSalida::query()
                        ->where('CodigoBarras', $barcode)
                        ->update([
                            'Flag_Activo' => 1,
                        ]);
                    LabLecturaEntrada::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);

                    LabLecturaAjusteInv::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);
                } else {
                    LecturaDespunteModel::query()
                        ->create([
                            'id_Patinador' => $patinador,
                            'CodigoBarras' => $request['Barcode'],
                            'CodOperario' => $request['Operario'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                        ]);
                    LabLecturaSalida::query()
                        ->create([
                            'id_Patinador' => $patinador,
                            'id_TipoSalida' => 7,
                            'CodigoBarras' => $request['Barcode'],
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                        ]);
                    LabLecturaEntrada::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);

                    LabLecturaAjusteInv::query()
                        ->where('CodigoBarras', $barcode)
                        ->update(['Flag_Activo' => 0]);
                }

            } else {
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 0,
                ]);
            }

            return response()->json([
                'consulta' => $UltLectu,
                'barcode' => $barcode,
                'data' => 1,
            ]);
        }
    }

    public function EtiquetasDespunte(Request $request)
    {
        //dd($request->all());
        /*$request->validate([
            'IdPatinador' => 'required',
            'Operario' => 'required',
            'Barcode' => 'required',
        ]);*/
        $semdespacho = $request->GET('SemDespachoDespunte');

        $radicado = DB::table('LabCambioFasesCh')->max('Radicado');
        $radicado++;

        $tipoFras = DB::table('lab_infotecica_tipos_frascos as tp')
            ->join('tipo_Contenedores_labs as tc', 'tc.id', 'tp.id_tipofrasco')
            ->select('tc.TipoContenedor')
            ->where('tp.id_Variedad', $request['ID_VariedadCDespunte'])
            ->where('tp.id_fase', $request['ID_FaseActualCDespunte'])
            ->first();
        $now = Carbon::now();
        $yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;
        $SemanaActual = $yearAc . '' . $SemanaAc;

        $semanaP = explode('-W', $semdespacho);
        //dd($semanaP);
        $dato1 = $semanaP[0];
        $dato2 = $semanaP[1];
        $SemanaDespacho = $dato1 . '' . $dato2;

        LabCambioFaseCh::query()
            ->create([
                'ID_Variedad' => $request['ID_VariedadCDespunte'],
                'Indentificador' => $request['NumIntroduccionEnDespunte'],
                'CantSalidas' => $request['CantidadSalidaDespunte'],
                'CantPlantas' => $request['CantidadDespunte'],
                'CantAdicional' => $request['CantidadAdicionalDespunte'],
                'TipoContenedor' => $tipoFras->TipoContenedor,
                'FaseActual' => $request['ID_FaseActualCDespunte'],
                'FaseNueva' => 8,
                'Flag_Activo' => 1,
                'FechaUltimoMovimiento' => $SemanaActual,
                'FechaEntrada' => $request['SemanaIngresoCDespunte'],
                'FechaDespacho' => $SemanaDespacho,
                'Radicado' => $radicado,
                'Cliente' => $request['ClienteDespunte'],
            ]);
        return $this->Imprimir($radicado, $request->all());
    }

    public function Imprimir($radicado, $reques)
    {

        //dd($reques);
        set_time_limit(0);
        $date = new Carbon('yesterday');
        $date2 = $date->format('Y-d-m 05:00:00.000');
        $semaDespa = '';
        $cliente = '';
        $CambioFaseBarcode = DB::statement('SET NOCOUNT ON; EXEC CambioFaseCh ?', array(
            $radicado
        ));

        if (empty($reques['SemanaDespachoCDespunte'])) {
            $semaDespa = null;
        } else {
            $semaDespa = $reques['SemanaDespachoCDespunte'];
        }
        if (empty($reques['clienteCDespunte'])) {
            $cliente = null;
        } else {
            $cliente = $reques['clienteCDespunte'];
        }

        $update = DB::table('LabLecturaDespunte as DE')
            ->select('DE.CodigoBarras')
            ->join('GetEtiquetasLabInventario as e', 'e.BarCode', '=', 'DE.CodigoBarras')
            ->where('e.Indentificador', '=', $reques['NumIntroduccionEnDespunte'])
            ->where('SemanaDespacho', '=', $semaDespa)
            ->where('ID_FaseActual', '=', $reques['ID_FaseActualCDespunte'])
            ->where('cliente', '=', $cliente)
            ->where('DE.updated_at', '>=', $date2)
            ->where('DE.Flag_Activo', '=', 1)
            ->get();

        //dd($update);
        foreach ($update as $upd) {
            LecturaDespunteModel::where('CodigoBarras', $upd->CodigoBarras)
                ->update([
                    'Flag_Activo' => 0,
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

}
