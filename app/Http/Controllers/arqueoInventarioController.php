<?php

namespace App\Http\Controllers;

use App\Model\arqueoInventarioModel;
use App\Model\Empleados;
use App\Model\LabCuartos;
use App\Model\LabLecturaEntrada;
use App\Model\LabLecturaSalida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class arqueoInventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewArqueoInventario()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        $Arqueo = DB::select('SET NOCOUNT ON; EXEC ArqueoInventario');
        //dd($Arqueo);
        return view('Laboratorio.ArqueoInventario', compact('cuartosAc','Arqueo'));
    }

    public function LecturaEntradaArqueo(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'IDCuarto' => 'required',
                'IDEstante' => 'required',
                'IDPiso' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];
//d($barcode);
            $existeBarcode = arqueoInventarioModel::select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $GeneracionCodigo = DB::table('GetEtiquetasLabInventario')
                ->select('Barcode')
                ->where('BarCode', '=', $barcode)
                ->first();

            if ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else if (empty($GeneracionCodigo)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {//no entra aquí
                arqueoInventarioModel::create([
                    'id_Cuarto' => $request['IDCuarto'],
                    'id_estante' => $request['IDEstante'],
                    'id_piso' => $request['IDPiso'],
                    'CodigoBarras' => $barcode,
                ]);
                return response()->json([
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function FaltanteInventario()
    {
        $Arqueo = DB::select('SET NOCOUNT ON; EXEC ArqueoInventario');
        //return response()->json(['data' => $Arqueo]);
        return view('Laboratorio.ArqueoInventario', compact('Arqueo'));
    }
}
