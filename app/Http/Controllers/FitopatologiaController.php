<?php

namespace App\Http\Controllers;

use App\Model\ModelResultadoMuestrasFitopatologia;
use App\Model\ModelTipoVirusFitopatogenos;
use Illuminate\Http\Request;
use Monolog\Handler\IFTTTHandler;
use PHPUnit\Framework\Constraint\Count;

class FitopatologiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewConsultarEtiquetas()
    {
        $virus = ModelTipoVirusFitopatogenos::all();
        return view('Fitopatologia.VirusFitopatologia', compact('virus'));
    }

    public function viewmuestraslaboratorio()
    {

        $IdendificadoresMuestras = ModelResultadoMuestrasFitopatologia::query()
            ->select('Identificador')
            ->join('GetEtiquetasLabInventario', 'CodigoBarras', '=', 'Barcode')
            ->groupBy('Identificador')
            ->get();

        return view('Fitopatologia.Muestraslaboratorio', compact('IdendificadoresMuestras'));
    }

    static function EstadoIndex($Identificador)
    {
        $MuestrasIndex = ModelResultadoMuestrasFitopatologia::query()
            ->select('ResultadoIndex')
            ->whereNull('ResultadoIndex')
            ->where('identificador', $Identificador)
            ->count();

        if ($MuestrasIndex >= '1') {
            return $MuestrasIndex = 1;
        } else {
            return $MuestrasIndex = 0;
        }

    }

    static function EstadoScreen($Identificador)
    {
        $MuestrasScreen = ModelResultadoMuestrasFitopatologia::query()
            ->select('MuestrasScreen')
            ->whereNull('MuestrasScreen')
            ->where('ResultadoIndex','=','OK')
            ->where('identificador', $Identificador)
            ->count();
        // dd($MuestrasScreen);
        if ($MuestrasScreen >= '1') {
            return $MuestrasScreen = 1;
        } else {
            return $MuestrasScreen = 0;
        }
    }

    public function viewmuestraslaboratorioDetallado($Identificador)
    {
        $virus = ModelTipoVirusFitopatogenos::all();
        $IdentificadorC = decrypt($Identificador);
        $DetallesIntro = ModelResultadoMuestrasFitopatologia::query()
            ->select('CodigoBarras',
                'SemanaActual',
                'ResultadoIndex',
                'MuestrasScreen',
                'PositivosMuestrasScreen',
                'AgroRhodoPruebaUno')
            ->where('Identificador', $IdentificadorC)
            ->get();

        return view('Fitopatologia.MuestraslaboratorioDetallado', compact('virus', 'DetallesIntro', 'IdentificadorC'));
    }

    public function IndexPositivo($Codigo)
    {

        $CodigoB = decrypt($Codigo);

        $actualizar = ModelResultadoMuestrasFitopatologia::query()
            ->where('CodigoBarras', $CodigoB)
            ->update([
                'ResultadoIndex' => 'POSITIVO',
            ]);

        $Identificador = ModelResultadoMuestrasFitopatologia::query()->select('Identificador')->where('CodigoBarras', $CodigoB)->first();
        return redirect(route('viewmuestraslaboratorioDetallado', ['Identificador' => encrypt($Identificador->Identificador)]));

    }

    public function IndexNegativo($Codigo)
    {
        $CodigoB = decrypt($Codigo);

        $actualizar = ModelResultadoMuestrasFitopatologia::query()
            ->where('CodigoBarras', $CodigoB)
            ->update([
                'ResultadoIndex' => 'NEGATIVO',
            ]);

        $Identificador = ModelResultadoMuestrasFitopatologia::query()->select('Identificador')->where('CodigoBarras', $CodigoB)->first();
        return redirect(route('viewmuestraslaboratorioDetallado', ['Identificador' => encrypt($Identificador->Identificador)]));
    }

    public function ResultadoScreen(Request $request)
    {
        //dd($request->all());
        $array1 = $request->get('MuestraRealizadas');
        $array1 = implode(', ', $array1);
        $array2 = $request->get('MuestraRealizadasPositivas');
        $array3 = $request->get('MuestraRealizadasPositivasRestringidos');


        if ($array2 > 0) {
            $array2 = implode(', ', $array2);
        } else {
            $array2 = NULL;
        }

        if ($array3 > 0) {
            $array3 = implode(', ', $array3);
        } else {
            $array3 = NULL;
        }
        $actualizar = ModelResultadoMuestrasFitopatologia::query()
            ->where('CodigoBarras', $request->get('CodigoBarras'))
            ->update([
                'MuestrasScreen' => $array1,
                'PositivosMuestrasScreen' => $array2,
                'PositivosMuestrasScreenRestringidas' => $array3,
            ]);

        $Identificador = ModelResultadoMuestrasFitopatologia::query()->select('Identificador')->where('CodigoBarras', $request->get('CodigoBarras'))->first();
        return redirect(route('viewmuestraslaboratorioDetallado', ['Identificador' => encrypt($Identificador->Identificador)]));

    }

    public function SelectRestingidos(Request $request)
    {
        $siglas = $request->get('Muestra');
        //$array1 = implode(', ', $siglas);

        $virus = ModelTipoVirusFitopatogenos::query()
            ->wherein('Siglas', $siglas)
            ->get();

        return response()->json(['Data' => $virus]);
    }

    public function ResultadoIndexMasivo(Request $request)
    {
        //dd($request->all());

        $MuestrasIndex = ModelResultadoMuestrasFitopatologia::query()
            ->select('CodigoBarras')
            ->whereNull('ResultadoIndex')
            ->where('identificador', $request->get('Identificador'))
            ->get();

        //dd($MuestrasIndex->CodigoBarras);

        for ($i = 0; $i < count($MuestrasIndex); $i++) {

            if ($request->get('radio') === '1') {
                $update = ModelResultadoMuestrasFitopatologia::query()
                    ->wherein('CodigoBarras', $MuestrasIndex[$i])
                    ->update([
                        'ResultadoIndex' => 'POSITIVO',
                    ]);

            } else {
                $update = ModelResultadoMuestrasFitopatologia::query()
                    ->wherein('CodigoBarras', $MuestrasIndex[$i])
                    ->update([
                        'ResultadoIndex' => 'NEGATIVO',
                    ]);
            }
        }

        $Identificador = ModelResultadoMuestrasFitopatologia::query()->select('Identificador') ->where('identificador', $request->get('Identificador'))->first();
        return redirect(route('viewmuestraslaboratorioDetallado', ['Identificador' => encrypt($Identificador->Identificador)]));

    }

    public function ResultadoScreenMasivo(Request $request)
    {

        //dd($request->all());
        $MuestrasScreen = ModelResultadoMuestrasFitopatologia::query()
            ->select('CodigoBarras')
            ->whereNull('MuestrasScreen')
            ->where('identificador', $request->get('Identificador'))
            ->get();

        $array1 = $request->get('MuestraRealizadasMa');
        $array1 = implode(', ', $array1);
        $array2 = $request->get('MuestraRealizadasPositivasMa');
        $array3 = $request->get('MuestraRealizadasPositivasRestringidosMa');


        if ($array2 > 0) {
            $array2 = implode(', ', $array2);
        } else {
            $array2 = NULL;
        }

        if ($array3 > 0) {
            $array3 = implode(', ', $array3);
        } else {
            $array3 = NULL;
        }
        //dd($MuestrasScreen);

        for ($i = 0; $i < count($MuestrasScreen); $i++) {

            //echo $MuestrasScreen[$i];
            $actualizar = ModelResultadoMuestrasFitopatologia::query()
                ->whereIN('CodigoBarras', $MuestrasScreen[$i])
                ->update([
                    'MuestrasScreen' => $array1,
                    'PositivosMuestrasScreen' => $array2,
                    'PositivosMuestrasScreenRestringidas' => $array3,
                ]);

        }

       $Identificador = ModelResultadoMuestrasFitopatologia::query()->select('Identificador') ->where('identificador', $request->get('Identificador'))->first();
        return redirect(route('viewmuestraslaboratorioDetallado', ['Identificador' => encrypt($Identificador->Identificador)]));
    }

}
