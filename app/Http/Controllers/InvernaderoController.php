<?php

namespace App\Http\Controllers;

use App\Exports\EntregaParcialExport;
use App\Exports\ExportarDescartesInvernader;
use App\Exports\reportetotalInvernadero;
use App\Model\AlistamientoInvernadero;
use App\Model\ClientesLab;
use App\Model\Empleados;
use App\Model\GetEtiquetasLabInventario;
use App\Model\InvCamasModel;
use App\Model\InvCausalesDescarteModel;
use App\Model\InvSeccionCamasModel;
use App\Model\LabAdaptacionInvernaderoModel;
use App\Model\LecturaDescarteInvernaderoModel;
use App\Model\LecturaEntradasInvernaderoModel;
use App\Model\LecturaSalidasdInvernadero;
use App\Model\LecturaTrasladoInvernaderoModel;
use App\Model\ModelAnoSemana;
use App\Model\TipoFrascosLab;
use App\Model\Variedades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;
use Maatwebsite\Excel\Facades\Excel;


class InvernaderoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function VistaLecturaEntradaInvernadero()
    {
        $camas = InvCamasModel::select('id', 'N_Cama')
            ->where('Flag_Activo', 1)
            ->where('N_Cama', '<=', 12)
            ->get();
        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.LecturaEntradaInvernadero', compact('camas', 'patinadores'));
    }

    public function LecturaEntradaInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'IDCama' => 'required',
                'idValvula' => 'required',
                'Operario' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);

            $existeBarcode = LecturaEntradasInvernaderoModel::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $UbiExis = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                ->first();
//dd($UbiExis->ID);

            if ($existeBarcode) {
                return response()->json([
                    'data' => 0,
                ]);
            } else if (empty($UbiExis)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else if ($ExisBarcoSalida) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {//no entra aquí
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                $patinador1  = auth()->user()->id_Empleado;
                LecturaEntradasInvernaderoModel::query()
                    ->create([
                        'id_Patinador' => $patinador1,
                        'id_Cama' => $request['IDCama'],
                        'id_SeccionCama' => $request['idValvula'],
                        'Plantas' => $UbiExis->CantContenedor,
                        'CodigoBarras' => $request['Barcode'],
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                        'CodOperario' => $request['Operario'],
                        'Flag_Activo' => 1,
                    ]);
                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);
                //dd($UltLectu);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaLecturaTrasladoInvernadero()
    {
        $camas = InvCamasModel::select('id', 'N_Cama')
            ->where('Flag_Activo', 1)
            ->where('N_Cama', '>', 12)
            ->get();
        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.LecturaTrasladoInvernadero', compact('camas', 'patinadores'));
    }

    public function LecturatrasladoInvernadero(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'IDCama' => 'required',
                'idValvula' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];

            $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);

            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();
            //dd($UltLectu);
            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $ExisteGenerado = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                /*->where('ID_FaseActual', '=', 8)
                ->orWhere('ID_FaseActual', '=', 10)*/
                ->first();

            $existesTraslado = LecturaTrasladoInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->first();

            if ($ExisBarcoSalida || empty($ExisteGenerado) || empty($ExisteEntrada) || $ExisteEntrada->Plantas === '0' || $existesTraslado) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                LecturaTrasladoInvernaderoModel::query()
                    ->create([
                        'CodigoBarras' => $barcode,
                        'id_CamaInicial' => $ExisteEntrada->id_Cama,
                        'id_SeccionCamaInicial' => $ExisteEntrada->id_SeccionCama,
                    ]);

                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'id_Cama' => $request['IDCama'],
                        'id_SeccionCama' => $request['idValvula'],
                    ]);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaLecturaDescarteInvernadero()
    {
        $camas = InvCamasModel::select('id', 'N_Cama')
            ->where('Flag_Activo', 1)
            ->where('N_Cama', '>', 12)
            ->get();
        $patinadores = Empleados::PatinadoresActivosInver();
        $Descartes = InvCausalesDescarteModel::query()
            ->select('id', 'CausalDescarte')
            ->wherein('id', [1, 2, 3, 4, 5, 7, 8, 9, 10, 12])
            ->where('Flag_Activo', '=', '1')
            ->get();
        //dd($Descartes);

        return view('Invernadero.LecturaDescarteInvernadero', compact('camas', 'patinadores', 'Descartes'));
    }

    public function LecturaDescarteInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'idCausalDescarte' => 'required',
                'Barcode' => 'required',
                'PlantasDescarte' => 'required',
            ]);
            $barcode = $request['Barcode'];


            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $PlantasTotal = $ExisteEntrada->Plantas - $request['PlantasDescarte'];
            //dd($UltLectu);
            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $ExisteGenerado = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                ->first();

            // dd($ExisteEntrada,$PlantasTotal,$ExisBarcoSalida,$ExisteGenerado);
//

            if ($ExisBarcoSalida || empty($ExisteGenerado) || empty($ExisteEntrada) || $ExisteEntrada->Plantas <= '0' || $PlantasTotal < 0) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $patinador1  = auth()->user()->id_Empleado;
                $PlantasTotal = $ExisteEntrada->Plantas - $request['PlantasDescarte'];

                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Plantas' => $PlantasTotal,
                    ]);

                $plantasTotalRestantes = LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->first();
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                LecturaDescarteInvernaderoModel::query()
                    ->create([
                        'CodigoBarras' => $barcode,
                        'CausalDescarte' => $request['idCausalDescarte'],
                        'PlantasDescartadas' => $request['PlantasDescarte'],
                        'idPatinador' => $patinador1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                    ]);

                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);

                if ($plantasTotalRestantes->Plantas === '0') {
                    LecturaEntradasInvernaderoModel::query()
                        ->where('CodigoBarras', $barcode)
                        ->update([
                            'Flag_Activo' => 0,
                        ]);
                    $dateA = Carbon::now();
                    $dateMasSema = $dateA->format('Y-m-d');
                    $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                    LecturaSalidasdInvernadero::query()
                        ->create([
                            'id_Patinador' => $patinador1,
                            'id_TipoSalida' => 1,
                            'id_TipoCancelado' => 13,
                            'CodigoBarras' => $barcode,
                            'Flag_Activo' => 1,
                            'SemanaLectura' => $SemanaEjecucion->AnoYSemana,
                        ]);
                }

                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }


    public function VistaLecturaCanecelacionInvernadero()
    {

        $patinadores = Empleados::PatinadoresActivosInver();
        $Descartes = InvCausalesDescarteModel::query()
            ->select('id', 'CausalDescarte')
            ->wherein('id', [6, 11])
            ->where('Flag_Activo', '=', '1')
            ->get();
        //dd($Descartes);

        return view('Invernadero.LecturaSalidaCancelacion', compact('patinadores', 'Descartes'));
    }

    public function LecturaCanecelacionInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'idCausalDescarte' => 'required',
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];

            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();


            if ($ExisBarcoSalida || empty($ExisteEntrada)) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $patinador1  = auth()->user()->id_Empleado;
                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Flag_Activo' => 0,
                    ]);
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();

                LecturaSalidasdInvernadero::query()
                    ->create([
                        'id_Patinador' => $patinador1,
                        'id_TipoSalida' => 1,
                        'id_TipoCancelado' => $request['idCausalDescarte'],
                        'CodigoBarras' => $barcode,
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);

                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);

                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function Servicioadaptacion()
    {
        $variedades = Variedades::listTableVariety();
        $clientes = ClientesLab::clientesActivos();
        $contenedores = TipoFrascosLab::ContenedoresActivos();

        $adaptacionespendetientes = LabAdaptacionInvernaderoModel::AdaptacionesActivas();

        return view('Invernadero.GenerarServicioAdaptacion', compact('variedades', 'clientes', 'contenedores', 'adaptacionespendetientes'));
    }

    public function NewAdaptacion(Request $request)
    {
        $array = $request['array'];

        //array_filter($array);
        //dd($array);
        if ($array > 0) {

            $radicado = LabAdaptacionInvernaderoModel::query()->max('CodAdaptacion');
            $radicado++;
            $users = auth()->user()->id;


            for ($i = 0; $i < count($array); $i++) {
                //dd($array[$i]['TipoIntro']);
                $contenedor = DB::table('lab_infotecica_tipos_frascos')
                    ->select('id_tipofrasco')
                    ->where('id_Variedad', '=', $array[$i]['IdVariedad'])
                    ->where('id_fase', '=', 8)
                    ->first();
                //dd($contenedor->id_tipofrasco);

                $cretae = LabAdaptacionInvernaderoModel::query()
                    ->create([
                        'Cantidad' => $array[$i]['Cantidad'],
                        'IdVariedad' => $array[$i]['IdVariedad'],
                        'IdCliente' => $array[$i]['idCliente'],
                        'IdContenedor' => $contenedor->id_tipofrasco,
                        'SemanaEntrada' => $array[$i]['semanaReal'],
                        'SemanaDespacho' => $array[$i]['semanaRealDes'],
                        'Identificador' => $array[$i]['identificador'],
                        'IdTipoFase' => 10,
                        'IdUser' => $users,
                        'CodAdaptacion' => $radicado,
                        'CodigoInterno' => $array[$i]['CodigoInterno'],
                        'Flag_Activo' => 1,
                    ]);
            }
            //dd($identicador);

            return response()->json([
                'data' => 1,
            ]);
        }
    }

    public function DetallesAdaptacion(Request $request)
    {
        if ($request->ajax()) {

            $Consulta = DB::table('Labadaptacioninvernadero as ingre')
                ->select(
                    'vari.Nombre_Variedad',
                    'ingre.Cantidad',
                    'ingre.Identificador',
                    'conte.TipoContenedor',
                    'ingre.CodigoInterno',
                    'ingre.IdTipoFase'
                )
                ->join('clientesYBreeder_labs as clien', 'clien.id', '=', 'ingre.IdCliente')
                ->join('URC_Variedades as vari', 'vari.id', '=', 'ingre.IdVariedad')
                ->join('tipo_Contenedores_labs as conte', 'conte.id', '=', 'ingre.IdContenedor')
                ->where('ingre.CodAdaptacion', '=', $request->get('CodigoIntro'))
                ->get();

            $total = DB::table('Labadaptacioninvernadero as ingre')
                ->select(
                    (DB::raw('sum(ingre.Cantidad) as CantidadTotal'))
                )
                ->where('ingre.CodAdaptacion', '=', $request->get('CodigoIntro'))
                ->first();

            return response()->json([
                'data' => $Consulta,
                'total' => $total
            ]);
        }
    }

    public function procedimientoAdaptacion($codigo)
    {
        set_time_limit(0);
        //dd($codigo);
        $produce = DB::statement('SET NOCOUNT ON; EXEC GetEtiquetasadaptacion ?', array(
            $codigo
        ));
        //dd($produce);
        $impresion = DB::table('GetEtiquetasLabInventario')
            ->select('GetEtiquetasLabInventario.*',
                'URC_Variedades.Nombre_Variedad',
                'URC_Generos.NombreGenero',
                'Labadaptacioninvernadero.CodigoInterno'
            )
            ->join('URC_Variedades', 'URC_Variedades.Codigo', '=', 'GetEtiquetasLabInventario.CodigoVariedad')
            ->join('Labadaptacioninvernadero', 'Labadaptacioninvernadero.id', '=', 'GetEtiquetasLabInventario.ID_Inventario')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'URC_Variedades.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->where('Radicado', '=', $codigo)
            ->where('Procedencia', '=', 'ServicioAdaptacion')
            ->get();
        //dd($impresion);

        $pdf = PDF::loadView('Invernadero.EtiquetasAdaptacion', compact('impresion'));
        $pdf->setPaper(array(25, -45, 315, 20), 'portrait');
        ob_get_clean();
        return $pdf->stream('barcode.pdf');

    }

    public function VistaReportesInvernadero()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        return view('Invernadero.ReportesInvernadero', compact('VariedadesActivas'));
    }

    public function ReporteEntradaInvernadero(Request $request)
    {
        if ($request->ajax()) {
            $Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');
            //dd($Ffin);
            $ReporEntrada = DB::table('LabLecturaEntradasInvernadero')
                ->select(
                    [DB::raw(
                        'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradasInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          LabLecturaEntradasInvernadero.created_at,
                        CONCAT(year(LabLecturaEntradasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaEntradasInvernadero.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        LabLecturaEntradasInvernadero.Plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                    )
                    ])
                ->join('RRHH_empleados as Em', 'LabLecturaEntradasInvernadero.id_Patinador', '=', 'Em.id')
                ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradasInvernadero.CodOperario', 'left outer')
                ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
                ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
                ->join('inv_camas', 'inv_camas.id', '=', 'LabLecturaEntradasInvernadero.id_Cama')
                ->join('inv_seccionCamas', 'inv_seccionCamas.id', '=', 'LabLecturaEntradasInvernadero.id_SeccionCama')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
                ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
                ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
                ->whereBetween('LabLecturaEntradasInvernadero.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->where('LabLecturaEntradasInvernadero.Flag_Activo', 1)
                ->get();
            //dd($ReporEntrada);
            return response()->json(['data' => $ReporEntrada]);

        }

    }

    public function ReporteSalidaInvernadero(Request $request)
    {
        if ($request->ajax()) {
            $Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');
            //dd($Ffin);

            $ReporSalida = DB::table('LabLecturaSalidasInvernadero')
                ->select(
                    [DB::raw(
                        'vari.Codigo,
                         CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                        gen.NombreGenero,
                        LabLecturaSalidasInvernadero.CodigoBarras,
                        GetEt.Indentificador,
                        GetEt.SemanUltimoMovimiento,
                        fac.NombreFase,
                        LabLecturaSalidasInvernadero.created_at,
                        GetEt.TipoContenedor,
                        lectEntr.Plantas,
                        Tsalida.TipoSalida,
                        ca.CausalDescarte,
                         GetEt.SemanaDespacho,
                        lectEntr.Plantas,
                        CONCAT(year(LabLecturaSalidasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaSalidasInvernadero.created_at)) as SemanaSalida,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(oper.Primer_Nombre,\' \',oper.Segundo_Nombre,\' \',oper.Primer_Apellido,\' \',oper.Segundo_Apellido,\' \') as NombreOperario,
                         cli.Nombre as NombreCliente'
                    )
                    ])
                ->join('RRHH_empleados as Em', 'LabLecturaSalidasInvernadero.id_Patinador', '=', 'Em.id')
                ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaSalidasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
                ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id')
                ->join('LabLecturaEntradasInvernadero as lectEntr', 'lectEntr.CodigoBarras', '=', 'LabLecturaSalidasInvernadero.CodigoBarras')
                ->join('RRHH_empleados as oper', 'oper.Codigo_Empleado', '=', 'lectEntr.CodOperario')/*aqui*/
                ->join('InvernaderoTipoSalida as Tsalida', 'Tsalida.id', '=', 'LabLecturaSalidasInvernadero.id_TipoSalida', 'left outer')
                ->join('InverCausalesDescartes as ca', 'ca.id', '=', 'LabLecturaSalidasInvernadero.id_TipoCancelado', 'left outer')
                ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
                ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
                ->where('LabLecturaSalidasInvernadero.Flag_Activo', 1)
                ->whereBetween('LabLecturaSalidasInvernadero.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->get();

            // dd($ReporSalida);

            return response()->json(['data' => $ReporSalida]);
        }
    }

    public function ReporteEntradaInvDinamico($FechaInicial, $FechaFinal, $IDVariedad)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');

        $array = explode(',', $IDVariedad);
        $ReporEntradaInvDinamico = DB::table('LabLecturaEntradasInvernadero')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradasInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          LabLecturaEntradasInvernadero.created_at,
                        CONCAT(year(LabLecturaEntradasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaEntradasInvernadero.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        LabLecturaEntradasInvernadero.Plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaEntradasInvernadero.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradasInvernadero.CodOperario', 'left outer')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('inv_camas', 'inv_camas.id', '=', 'LabLecturaEntradasInvernadero.id_Cama')
            ->join('inv_seccionCamas', 'inv_seccionCamas.id', '=', 'LabLecturaEntradasInvernadero.id_SeccionCama')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->whereBetween('LabLecturaEntradasInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->wherein('GetEt.ID_Variedad', $array)
            ->get();

        return response()->json(['data' => $ReporEntradaInvDinamico]);

    }

    /* desde aqui*/

    public function ReporteEntradaInvDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');


        $ReporEntradaInvDinamico = DB::table('LabLecturaEntradasInvernadero')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradasInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          LabLecturaEntradasInvernadero.created_at,
                        CONCAT(year(LabLecturaEntradasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaEntradasInvernadero.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        LabLecturaEntradasInvernadero.Plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaEntradasInvernadero.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradasInvernadero.CodOperario', 'left outer')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('inv_camas', 'inv_camas.id', '=', 'LabLecturaEntradasInvernadero.id_Cama')
            ->join('inv_seccionCamas', 'inv_seccionCamas.id', '=', 'LabLecturaEntradasInvernadero.id_SeccionCama')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->where('LabLecturaEntradasInvernadero.Flag_Activo', 1)
            ->whereBetween('LabLecturaEntradasInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->get();

        return response()->json(['data' => $ReporEntradaInvDinamico]);

    }

    public function ReporteSalidaInvDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');

        $ReporSalidadInvDinamico = DB::table('LabLecturaSalidasInvernadero')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaSalidasInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          entre.Plantas,
                          LabLecturaSalidasInvernadero.created_at,
                        CONCAT(year(LabLecturaSalidasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaSalidasInvernadero.created_at)) as SemanaSalida,
                        GetEt.SemanaDespacho,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        cli.Nombre as NombreCliente,
                        tpi.TipoSalida,
                        cus.CausalDescarte'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaSalidasInvernadero.id_Patinador', '=', 'Em.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaSalidasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('LabLecturaEntradasInvernadero as entre', 'entre.CodigoBarras', '=', 'LabLecturaSalidasInvernadero.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->join('InvernaderoTipoSalida as tpi', 'tpi.id', '=', 'LabLecturaSalidasInvernadero.id_TipoSalida')
            ->join('InverCausalesDescartes as cus', 'cus.id', '=', 'LabLecturaSalidasInvernadero.id_TipoCancelado', 'left outer')
            ->where('LabLecturaSalidasInvernadero.Flag_Activo', 1)
            //->where('LabLecturaSalidasInvernadero.id_TipoCancelado', '<>',13)
            ->whereBetween('LabLecturaSalidasInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->get();

        return response()->json(['data' => $ReporSalidadInvDinamico]);

    }

    public function ReportedescarteInvDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');


        $ReporDescarteInvDinamico = DB::table('LabLecturaDescarteInvernadero')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaDescarteInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          LabLecturaDescarteInvernadero.PlantasDescartadas,
                          LabLecturaDescarteInvernadero.created_at,
                        CONCAT(year(LabLecturaDescarteInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaDescarteInvernadero.created_at)) as SemanaDescarte,
                        GetEt.SemanaDespacho,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        cli.Nombre as NombreCliente,
                        cus.CausalDescarte'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaDescarteInvernadero.idPatinador', '=', 'Em.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaDescarteInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->join('InverCausalesDescartes as cus', 'cus.id', '=', 'LabLecturaDescarteInvernadero.CausalDescarte', 'left outer')
            ->whereBetween('LabLecturaDescarteInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->get();

        return response()->json(['data' => $ReporDescarteInvDinamico]);

    }

    public function ReporteDescarteTotalInvDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');


        $ReporDescarteInvDinamicototal = DB::table('LabLecturaDescarteInvernadero')
            ->select(
                [DB::raw(
                    'invCausa.CausalDescarte,
                   vari.Nombre_Variedad,
                   gtt.Indentificador,
                   PlantasDescartadas,
                        gtt.CodigoVariedad'
                )
                ])
            ->join('InverCausalesDescartes as invCausa', 'invCausa.id', '=', 'LabLecturaDescarteInvernadero.CausalDescarte')
            ->join('GetEtiquetasLabInventario as gtt', 'gtt.BarCode', '=', 'LabLecturaDescarteInvernadero.CodigoBarras')
            ->join('URC_Variedades as vari', 'vari.Codigo', '=', 'gtt.CodigoVariedad')
            ->whereBetween('LabLecturaDescarteInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            //->groupBy('CausalDescarte')
            ->get();
        // dd($ReporDescarteInvDinamicototal);
        return response()->json(['data' => $ReporDescarteInvDinamicototal]);

    }

    public function ReporteAlistamientoInvDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');


        $ReporEntradaInvDinamico = DB::table('AlistamientoInvernadero')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          AlistamientoInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          AlistamientoInvernadero.created_at,
                        CONCAT(year(AlistamientoInvernadero.created_at), DATEPART(ISO_WEEK, AlistamientoInvernadero.created_at)) as SemanaAlistada,
                        GetEt.SemanaDespacho,
                        AlistamientoInvernadero.CantPlantas,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                )
                ])
            ->join('RRHH_empleados as Em', 'AlistamientoInvernadero.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'AlistamientoInvernadero.Operario', 'left outer')
            ->join('GetEtiquetasLabInventario as GetEt', 'AlistamientoInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->whereBetween('AlistamientoInvernadero.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->get();

        return response()->json(['data' => $ReporEntradaInvDinamico]);

    }

    /*hasta aqui*/

    public function VistaLecturaTrasladoInternoInvernadero()
    {
        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.LecturaTrasladoInternoInvernadero', compact('patinadores'));
    }

    public function LecturaTrasladoInternoInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'Barcode' => 'required',
                'IDCama' => 'required',
                'idValvula' => 'required',

            ]);
            $barcode = $request['Barcode'];

            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->select('id_Cama', 'CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            if (empty($ExisteEntrada)) {
                //dd('vacio');
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);
                //dd($ExisteEntrada->id_Cama);
                if ($ExisteEntrada->id_Cama <= 12 && $request['IDCama'] <= 12) {
                    LecturaEntradasInvernaderoModel::query()
                        ->where('CodigoBarras', $barcode)
                        ->update([
                            'id_Cama' => $request['IDCama'],
                            'id_SeccionCama' => $request['idValvula'],
                        ]);
                } else if ($ExisteEntrada->id_Cama >= 13 && $request['IDCama'] >= 13) {
                    LecturaEntradasInvernaderoModel::query()
                        ->where('CodigoBarras', $barcode)
                        ->update([
                            'id_Cama' => $request['IDCama'],
                            'id_SeccionCama' => $request['idValvula'],
                        ]);
                } else {
                    return response()->json([
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
    }

    public function VistaLecturaDespachoInvernadero()
    {

        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.LecturaDespachoInvernadero', compact('patinadores'));
    }

    public function LecturaDepachoInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([

                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);

            $existeBarcode = LecturaEntradasInvernaderoModel::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->first();

            $UbiExis = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                ->first();
//dd($ExisBarcoSalida);

            if (empty($existeBarcode)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else if (empty($UbiExis)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else if ($ExisBarcoSalida) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                $patinador1  = auth()->user()->id_Empleado;
                LecturaSalidasdInvernadero::query()
                    ->create([
                        'id_Patinador' => $patinador1,
                        'id_TipoSalida' => 2,
                        'CodigoBarras' => $barcode,
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Flag_Activo' => 0,
                    ]);
                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);
                //dd($UltLectu);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaLecturaPrealistamientoDespachoInvernadero()
    {

        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.LecturaPreAlistamiento', compact('patinadores'));
    }

    public function LecturaPreAlistamientoDepachoInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'Barcode' => 'required',
                'Operario' => 'required',
            ]);
            $barcode = $request['Barcode'];
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);

            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $YaAlistado = AlistamientoInvernadero::query()
                ->where('CodigoBarras', $barcode)
                ->first();

            $UbiExis = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                ->first();
            //dd($ExisteEntrada->Plantas);

            if (empty($ExisteEntrada) || $ExisBarcoSalida || empty($UbiExis) || $YaAlistado) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $patinador1  = auth()->user()->id_Empleado;
                AlistamientoInvernadero::query()
                    ->create([
                        'id_Patinador' => $patinador1,
                        'Operario' => $request['Operario'],
                        'CantPlantas' => $ExisteEntrada->Plantas,
                        'CodigoBarras' => $barcode,

                    ]);
                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Plantas' => $UbiExis->CantContenedor,
                    ]);
                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);
                //dd($UltLectu);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function VistaLecturaSalidaAlistamientoDespachoInvernadero()
    {
        $patinadores = Empleados::PatinadoresActivosInver();
        return view('Invernadero.SalidasAlistamiento', compact('patinadores'));
    }

    public function LecturaSalidaAlistamientoDepachoInvernadero(Request $request)
    {
        //dd($request->all());
        if ($request->ajax()) {
            $request->validate([
                'Barcode' => 'required',
            ]);
            $barcode = $request['Barcode'];
            //$UltLectu = Empleados::PatinadoresUltimalectura($request);

            $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $ExisBarcoSalida = LecturaSalidasdInvernadero::query()
                ->select('CodigoBarras')
                ->where('CodigoBarras', $barcode)
                ->where('Flag_Activo', 1)
                ->first();

            $UbiExis = GetEtiquetasLabInventario::query()
                ->where('BarCode', $request->get('Barcode'))
                ->first();
            //dd($ExisteEntrada->Plantas);

            if (empty($ExisteEntrada) || $ExisBarcoSalida || empty($UbiExis)) {
                return response()->json([
                    'data' => 2,
                ]);
            } else {
                $dateA = Carbon::now();
                $dateMasSema = $dateA->format('Y-m-d');
                $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
                $patinador1  = auth()->user()->id_Empleado;
                LecturaSalidasdInvernadero::query()
                    ->create([
                        'id_Patinador' => $patinador1,
                        'id_TipoSalida' => 3,
                        'CodigoBarras' => $barcode,
                        'Flag_Activo' => 1,
                        'SemanaLectura' => $SemanaEjecucion->AnoYSemana, /////// OJO SE DEBE
                    ]);
                LecturaEntradasInvernaderoModel::query()
                    ->where('CodigoBarras', $barcode)
                    ->update([
                        'Flag_Activo' => 0,
                        'Plantas' => 0,
                    ]);
                $UltLectu = Empleados::PatinadoresUltimalecturaInvernadero($request);
                //dd($UltLectu);
                return response()->json([
                    'consulta' => $UltLectu,
                    'barcode' => $barcode,
                    'data' => 1,
                ]);
            }
        }
    }

    public function SelectBanco($id)
    {
        $dato = $id;

        if ($dato === '1') {
            $camas = InvCamasModel::select('id', 'N_Cama')
                ->where('Flag_Activo', 1)
                ->where('N_Cama', '<=', 12)
                ->get();
        } else {
            $camas = InvCamasModel::select('id', 'N_Cama')
                ->where('Flag_Activo', 1)
                ->where('N_Cama', '>', 12)
                ->get();
        }
        return response()->json(['Data' => $camas]);
    }

    public function SelectValvula($id)
    {
        $Secciones = InvSeccionCamasModel::select('id', 'N_Seccion')
            ->where('Flag_Activo', 1)
            ->where('id_Cama', '=', $id)
            ->get();
        return response()->json(['Data' => $Secciones]);
    }

    public function DescargaInventarioInvernadero()
    {
        //return (new UsersExport)->collection()->download('invoices.xlsx');
        //return (new InvoicesExport)->download('invoices.xlsx');
        set_time_limit(0);
        return Excel::download(new reportetotalInvernadero(), 'Reporte Inventario Invernadero-' . Carbon::now()->format('Y-m-d') . '.xlsx');


    }

    public function DescargaInventarioInvernaderoDescartes(Request $request)
    {
        //dd($request->all());
        $FechaInicial = (new Carbon($request->get('Fechainialh')))->format('Y-d-m');
        $FechaFinal = (new Carbon($request->get('FechaFinalh')))->format('Y-d-m');
        return Excel::download(new ExportarDescartesInvernader($FechaInicial,$FechaFinal), 'Reporte Descartes.xlsx');
    }

    public function ProgramasInvernaderoPendientes()
    {
        $programasInvs = GetEtiquetasLabInventario::ProgramasPendientesInvernadero();
        return view('Invernadero.programasPendientesInv', compact('programasInvs'));
    }

    public function VistaConsultaCodigoInvernadero()
    {
        return view('Invernadero.ConsultaCodigo');
    }

    public function LecturaConsultaCodigoInvernadero(Request $request)
    {
        //dd($request->all());

        $ExisteEntrada = LecturaEntradasInvernaderoModel::query()
            ->where('CodigoBarras', $request->get('Barcode'))
            ->where('Flag_Activo', 1)
            ->first();

        if($ExisteEntrada){
            $consulta = DB::table('LabLecturaEntradasInvernadero')
                ->select(
                    [DB::raw(
                        'CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          LabLecturaEntradasInvernadero.CodigoBarras,
                        LabLecturaEntradasInvernadero.Plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario'
                    )
                    ])
                ->join('RRHH_empleados as Em', 'LabLecturaEntradasInvernadero.id_Patinador', '=', 'Em.id')
                ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradasInvernadero.CodOperario', 'left outer')
                ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
                ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
                ->join('inv_camas', 'inv_camas.id', '=', 'LabLecturaEntradasInvernadero.id_Cama')
                ->join('inv_seccionCamas', 'inv_seccionCamas.id', '=', 'LabLecturaEntradasInvernadero.id_SeccionCama')
                ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
                ->where('LabLecturaEntradasInvernadero.CodigoBarras', $request->get('Barcode'))
                ->where('LabLecturaEntradasInvernadero.Flag_Activo', 1)
                ->get();
            //dd($consulta);
            return response()->json([
                'consulta' => $consulta,
                'data' => 1,
            ]);
        }else{
            return response()->json([
                'data' => 2,
            ]);
        }
    }
}
