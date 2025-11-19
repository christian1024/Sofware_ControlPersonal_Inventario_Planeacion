<?php

namespace App\Http\Controllers;

use App\Model\CargueInventario;
use App\Model\LabCuartos;
use App\Model\LabEstante;
use App\Model\LabNivel;
use App\Model\TipoFasesLab;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneracionEtiquetasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewGenerarEtiquetas()
    {
        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        $etapas = TipoFasesLab::all();

        return view('Laboratorio.GeneracionEtiquetas', compact('cuartosAc', 'etapas'));
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

    public function GenerarEtiquetasInventario(Request $request)
    {
        set_time_limit(0);

        $inventario = DB::table('cargue_inventario')
            ->select('id_Cuarto', 'id_Estante', 'id_Nivel', 'FaseActual', 'Cantidad')
            ->where('id_Cuarto', $request->get('IDCuarto'))
            ->where('id_Estante', $request->get('IDEstante'))
            ->where('id_Nivel', $request->get('IDPiso'))
            ->where('FaseActual', $request->get('id_Etapa'))
            ->first();

        $consulta = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.id_Cuarto', 'GetEtiquetasLabInventario.id_Estante', 'GetEtiquetasLabInventario.id_Nivel', 'cargue_inventario.FaseActual')
            ->join('cargue_inventario','cargue_inventario.id','=','GetEtiquetasLabInventario.ID_Inventario')
            ->where('GetEtiquetasLabInventario.id_Cuarto', $request->get('IDCuarto'))
            ->where('GetEtiquetasLabInventario.id_Estante', $request->get('IDEstante'))
            ->where('GetEtiquetasLabInventario.id_Nivel', $request->get('IDPiso'))
            ->where('cargue_inventario.FaseActual',$request->get('id_Etapa'))
            ->first();

        if ($inventario) {
            if ($consulta) {
                session()->flash('impreso', 'impreso');
                return back()->with('impreso', '');
            } else {
                $procedimiento = DB::statement('SET NOCOUNT ON; EXEC GetEtiquetasInventarioLaboratorio ?,?,?,?,?,?', array(
                    $request->get('IDCuarto'),
                    $request->get('IDEstante'),
                    $request->get('IDPiso'),
                    2,
                    1,
                    $request->get('id_Etapa')
                ));
                $impresion = DB::table('GetEtiquetasLabInventario')
                    ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'cargue_inventario.FaseActual','URC_Generos.NombreGenero')
                    ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
                    ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
                    ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
                    ->join('cargue_inventario', 'cargue_inventario.id', '=', 'GetEtiquetasLabInventario.ID_Inventario')
                    ->where('GetEtiquetasLabInventario.id_Cuarto', $request->get('IDCuarto'))
                    ->where('GetEtiquetasLabInventario.id_Estante', $request->get('IDEstante'))
                    ->where('GetEtiquetasLabInventario.id_Nivel', $request->get('IDPiso'))
                    ->get();
                //dd($impresion);

                $pdf = PDF::loadView('barcode', compact('impresion'));
                $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
                ob_get_clean();

                return $pdf->stream('barcode.pdf');
            }
        } else {
            session()->flash('noexiste', 'noexiste');
            return back()->with('noexiste', '');
        }

    }

    public function GenerarEtiquetasInventario1(Request $request)
    {
        $radicado = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.Radicado')
            ->where('GetEtiquetasLabInventario.Radicado', $request->get('NumRadicado'))
            ->first();

        $existe = CargueInventario::select('NumeroRadicado', 'CodigoVariedad')
            ->where('NumeroRadicado', $request->get('NumRadicado'))
            ->first();

        if ($radicado) {
            session()->flash('radicado', 'radicado');
            return back()->with('radicado', '');
        } else {
            if ($existe) {
                DB::statement('SET NOCOUNT ON; EXEC GetEtiquetasInventarioLaboratorio ?,?,?,?,?,?', array(
                    1,
                    1,
                    1,
                    1,
                    $request->get('NumRadicado'),
                    1
                ));
                session()->flash('creado', 'creado');
                return back()->with('creado', '');

            } else {
                session()->flash('existe', 'existe');
                return back()->with('existe', '');
            }
        }
    }
}


