<?php

namespace App\Http\Controllers;

use App\Model\LabCuartos;
use App\Model\Variedades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;
use PDF;

class ConsultarEtiquetaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewConsultarEtiquetas()
    {

        $cuartosAc = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->get();
        return view('Laboratorio.ConsultaEtiquetas', compact('cuartosAc'));
    }

    public function ImprimirEtq()
    {

        set_time_limit(0);

        $impresion = DB::select('SET NOCOUNT ON; EXEC consulta');

        $pdf = PDF::loadView('barcode', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();

        return $pdf->stream('barcode.pdf');
    }

    public function ImprimirEtqSA()
    {

        set_time_limit(0);
        $impresion = DB::select('SET NOCOUNT ON; EXEC [consultaSA]');

        //dd($impresion);


        $pdf = PDF::loadView('Invernadero.EtiquetasAdaptacion', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();
        return $pdf->stream('barcode.pdf');



    }

    public function s(Request $request)
    {

        //dd($request->all());
        set_time_limit(0);
        /*$impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'cargue_inventario.FaseActual','URC_Generos.NombreGenero')
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->join('cargue_inventario', 'cargue_inventario.id', '=', 'GetEtiquetasLabInventario.ID_Inventario')
            ->where('GetEtiquetasLabInventario.id_Cuarto', $request->get('IDCuarto2'))
            ->where('GetEtiquetasLabInventario.id_Estante', $request->get('IDEstante2'))
            ->where('GetEtiquetasLabInventario.id_Nivel', $request->get('IDPiso2'))
            ->where('GetEtiquetasLabInventario.Indentificador', $request->get('Idetinficador'))
            ->get();*/
        //dd($impresion);

        $impresion = DB::select('SET NOCOUNT ON; EXEC consulta');

        /*$impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'URC_Generos.NombreGenero',
                DB::raw('GetEtiquetasLabInventario.ID_FaseActual AS FaseActual'))
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')

            ->wherein('GetEtiquetasLabInventario.Barcode', [
                'A00342953'
            ])
            ->orderBy('GetEtiquetasLabInventario.BarCode', 'ASC')
            ->get();*/
        /* ->join('cargue_inventario', 'cargue_inventario.id', '=', 'GetEtiquetasLabInventario.ID_Inventario')*/
        /*->where('GetEtiquetasLabInventario.Indentificador', '=','BLL3502436201449')*/
        /*->where('GetEtiquetasLabInventario.SemanaDespacho', '=','202027')
        ->where('GetEtiquetasLabInventario.SemanUltimoMovimiento', '=','20209')
        ->wherein('GetEtiquetasLabInventario.Procedencia',['CambioFase','CargueInventario'])
        ->where('GetEtiquetasLabInventario.Procedencia','=','CambioFase')
        ->where('GetEtiquetasLabInventario.ID_Inventario', '=','5975')*/


        //dd($impresion);

        $pdf = PDF::loadView('barcode', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();

        return $pdf->stream('barcode.pdf');
    }

    public function VistaUbicacionVariedades()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        return view('Laboratorio.UbicacionVariedades', compact('VariedadesActivas'));
    }

    public function DestallesUbicacionVariedades(Request $request)
    {
        //dd($request->all());
        $ubica = DB::table('LabLecturaEntradas as entre')
            ->select(
                [DB::raw(
                    'CONCAT (entre.id_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as ubicacion,
                    Indentificador,
                    fas.NombreFase,
                    count(entre.id) as CantContenedores'
                )
                ])
            ->join('lab_estantes as est', 'entre.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'entre.id_piso', '=', 'nilv.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'entre.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('tipo_fases_labs as fas', 'fas.id', '=', 'GetEt.ID_FaseActual')
            ->where('ID_Variedad', $request->get('variedad'))
            ->where('entre.Flag_Activo', 1)
            ->groupBy([
                'Indentificador',
                'NombreFase',
                'ID_Variedad',
                'entre.id_Cuarto',
                'est.N_Estante',
                'nilv.N_Nivel'
            ])
            ->orderBy('ubicacion')
            ->get();

        return response()->json(['data' => $ubica]);
    }

}
