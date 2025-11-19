<?php

namespace App\Http\Controllers;

use App\Model\ClientesLab;
use App\Model\Empleados;
use App\Model\Generos;
use App\Model\GetEtiquetasLabInventario;
use App\Model\LabIngresoIntroduccion;
use App\Model\ModelAnoSemana;
use App\Model\ModelIntroduccionesFuturas;
use App\Model\TipoFrascosLab;
use App\Model\Variedades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class IntroduccionController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewIntroduccion()
    {
        $variedades = Variedades::listTableVariety();
        $clientes = ClientesLab::clientesActivos();
        $contenedores = TipoFrascosLab::ContenedoresActivos();
        $Introducciones = LabIngresoIntroduccion::IntroduccionesAcivas();


        return view('Compras.Introduccion', compact('variedades', 'clientes', 'contenedores', 'Introducciones'));
    }

    public function NewIntroduccion(Request $request)
    {
        $array = $request['array'];

        //array_filter($array);
        //dd($array);

        if ($array > 0) {


            $dateA = Carbon::now();
            $dateMasSema = $dateA->format('Y-m-d');
            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();


            $Codigo = LabIngresoIntroduccion::pluck('CodIntroducion')->last();
            $Codigo = $Codigo + 1;
            $users = auth()->user()->id;


            for ($i = 0; $i < count($array); $i++) {
                //dd($array[$i]['TipoIntro']);
                $contenedor = DB::table('lab_infotecica_tipos_frascos')
                    ->select('id_tipofrasco')
                    ->where('id_Variedad', '=', $array[$i]['IdVariedad'])
                    ->where('id_fase', '=', $array[$i]['TipoIntro'])
                    ->first();
                //dd($contenedor->id_tipofrasco);

                $cretae = LabIngresoIntroduccion::create([
                    'Cantidad' => $array[$i]['Cantidad'],
                    'IdVariedad' => $array[$i]['IdVariedad'],
                    'IdCliente' => $array[$i]['idCliente'],
                    'IdContenedor' => $contenedor->id_tipofrasco,
                    'FechaEntrada' => $SemanaEjecucion->AnoYSemana,
                    'Identificador' => $array[$i]['identificador'],
                    'CodIntroducion' => $Codigo,
                    'IdTipoFase' => $array[$i]['TipoIntro'],
                    'Flag_Activo' => 1,
                    'IdUser' => $users,
                    'Comentario' => $array[$i]['Comentario'],
                ]);
            }
            //dd($identicador);

            return response()->json([
                'data' => 1,
            ]);
        }
    }

    public function DetallesIntroducion(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $Consulta = DB::table('LabIngresoIntroduccions as ingre')
                ->select(
                    'vari.Nombre_Variedad',
                    'ingre.Cantidad',
                    'ingre.Identificador',
                    'conte.TipoContenedor',
                    'ingre.IdTipoFase'
                )
                ->join('clientesYBreeder_labs as clien', 'clien.id', '=', 'ingre.IdCliente')
                ->join('URC_Variedades as vari', 'vari.id', '=', 'ingre.IdVariedad')
                ->join('tipo_Contenedores_labs as conte', 'conte.id', '=', 'ingre.IdContenedor')
                ->where('ingre.CodIntroducion', '=', $request->get('CodigoIntro'))
                ->get();

            $total = DB::table('LabIngresoIntroduccions as ingre')
                ->select(
                    (DB::raw('sum(ingre.Cantidad) as CantidadTotal'))
                )
                ->where('ingre.CodIntroducion', '=', $request->get('CodigoIntro'))
                ->first();

            return response()->json([
                'data' => $Consulta,
                'total' => $total
            ]);
        }
    }

    public function ConsultaIntroducciones(Request $request)
    {

        //dd($request->all());
        if ($request->ajax()) {

            $Fini = (new Carbon($request->get('FeIncial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FeFinal')))->format('Y-d-m');

            $Consulta = DB::table('LabIngresoIntroduccions')
                ->join('clientesYBreeder_labs as clien', 'clien.id', '=', 'LabIngresoIntroduccions.IdCliente')
                ->select(
                    'clien.Nombre',
                    'LabIngresoIntroduccions.CodIntroducion'
                )
                ->whereBetween('LabIngresoIntroduccions.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->groupBy(['LabIngresoIntroduccions.CodIntroducion',
                    'clien.Nombre'])
                ->get();
            return response()->json([
                'data' => $Consulta,
            ]);
        }
    }

    public function procedimiento($codigo)
    {
        set_time_limit(0);

        $produce = DB::statement('SET NOCOUNT ON; EXEC GetEtiquetasintroduccion ?', array(
            $codigo
        ));
        //dd($produce);
        $impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*', 'URC_Variedades.Nombre_Variedad', 'URC_Generos.NombreGenero',
                DB::raw('LabIngresoIntroduccions.IdTipoFase AS FaseActual'))
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('LabIngresoIntroduccions', 'LabIngresoIntroduccions.id', '=', 'GetEtiquetasLabInventario.ID_Inventario')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->where('Radicado', '=', $codigo)
            ->where('Procedencia', '=', 'Introduccion')
            ->get();
        //dd($impresion);

        $pdf = PDF::loadView('barcode', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();
        return $pdf->stream('barcode.pdf');

    }

    public function IntroduciconesFuturasView()
    {
        $variedades = Variedades::listTableVariety();
        $Generos = Generos::all();
        $clientes = ClientesLab::clientesActivos();

        $introducionesfuturas = ModelIntroduccionesFuturas::ReporteIntroducionesFuturas();


        return view('Compras.IntroduccionesFuturas', compact('variedades', 'clientes', 'Generos','introducionesfuturas'));
    }

    public function GuarddarIntroduciconesFuturas(Request $request)
    {
        $array = $request['array'];


        if ($array > 0) {
            $dateA = Carbon::now();
            $dateMasSema = $dateA->format('Y-m-d');
            $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

            $UltLectu = Empleados::PatinadoresUltimalectura($request);
            $patinador = auth()->user()->id_Empleado;


            for ($i = 0; $i < count($array); $i++) {


                $semanaA = explode('-W', $array[$i]['intro']);
                //dd($semanaP);
                $dato1 = $semanaA[0];
                $dato2 = $semanaA[1];
                $Semana = $dato1 . '' . $dato2;


                if (empty($array[$i]['IDGeneroD'])  && $array[$i]['IdVariedad']) {

                    $Genero = DB::table('URC_Variedades')
                        ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
                        ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
                        ->select([
                            'URC_Generos.id',
                        ])
                        ->where('URC_Variedades.id', $array[$i]['IdVariedad'])
                        ->first();
                    $cretae = ModelIntroduccionesFuturas::create([
                        'SemanaIntroduccion' => $Semana,
                        'IdCliente' => $array[$i]['idCliente'],
                        'IdVariedad' => $array[$i]['IdVariedad'],
                        'IdGenero' => $Genero->id,
                        'TipoIntroduccion' => $array[$i]['ValTipoIntro'],
                        'Cantidad' => $array[$i]['Cantidad'],
                        'SemanaCreacion' => $SemanaEjecucion->AnoYSemana,
                        'idusers' => $patinador,

                    ]);
                } else {

                    $cretae = ModelIntroduccionesFuturas::create([
                        'SemanaIntroduccion' => $Semana,
                        'IdCliente' => $array[$i]['idCliente'],
                        'IdGenero' => $array[$i]['IDGeneroD'],
                        'ValTipoIntroduccion' => $array[$i]['ValTipoIntro'],
                        'Cantidad' => $array[$i]['Cantidad'],
                        'SemanaCreacion' => $SemanaEjecucion->AnoYSemana,
                        'idusers' => $patinador,

                    ]);
                }
            }
        }
        return response()->json([
            'data' => 1,
        ]);
    }
}
