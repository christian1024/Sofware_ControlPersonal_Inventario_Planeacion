<?php

namespace App\Http\Controllers;

use App\Exports\ReporteInventario;
use App\Exports\ReporteInventarioTotal;
use App\Model\LabLecturaEntrada;
use App\Model\Variedades;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;

class ReportesLaboratorioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ReportesLaboratorio()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        return view('Laboratorio.Inventario', compact('VariedadesActivas'));
    }

    public function GenerarReporteEntrada(Request $request)
    {
        if ($request->ajax()) {
            $Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');
            //dd($Ffin);
            $ReporEntrada = DB::table('LabLecturaEntradas')
                ->select(
                    [DB::raw(
                        'vari.Codigo,
                          vari.Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradas.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                          LabLecturaEntradas.created_at,
                          LabLecturaEntradas.Flag_Activo,
                        CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual,
                        LabLecturaEntradas.Plantas,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                    )
                    ])
                ->join('RRHH_empleados as Em', 'LabLecturaEntradas.id_Patinador', '=', 'Em.id')
                ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradas.CodOperario', 'left outer')
                ->join('lab_cuartos as cuar', 'LabLecturaEntradas.id_Cuarto', '=', 'cuar.id')
                ->join('lab_estantes as est', 'LabLecturaEntradas.id_estante', '=', 'est.id')
                ->join('lab_nivels as nilv', 'LabLecturaEntradas.id_piso', '=', 'nilv.id')
                ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEt.BarCode')
                ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('cargue_inventario as cin ', 'GetEt.ID_Inventario', '=', 'cin.id', 'left outer')
                ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
                ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
                ->whereBetween('LabLecturaEntradas.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->get();
            //dd($ReporEntrada);
            return response()->json(['data' => $ReporEntrada]);

        }

    }

    public function GenerarReporteSalida(Request $request)
    {

        if ($request->ajax()) {
            $Fini = (new Carbon($request->get('FechaInicial')))->format('Y-d-m');
            $Ffin = (new Carbon($request->get('FechaFinal')))->format('Y-d-m');
            //dd($Ffin);

            $ReporSalida = DB::table('LabLecturaSalidas')
                ->select(
                    [DB::raw(
                        'vari.Codigo,
                        vari.Nombre_Variedad,
                        gen.NombreGenero,
                        LabLecturaSalidas.CodigoBarras,
                        GetEt.Indentificador,
                        GetEt.SemanUltimoMovimiento,
                        fac.NombreFase,
                        GetEt.TipoContenedor,
                        LabLecturaSalidas.created_at,
                        lectEntr.Plantas,
                        Tsalida.TipoSalida_Ajuste,
                        CONVERT(DATE, LabLecturaSalidas.created_at) as fecha,
                        ca.CausalDescarte,
                        CONCAT(year(LabLecturaSalidas.created_at), DATEPART(ISO_WEEK, LabLecturaSalidas.created_at)) as SemanaSalida,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(oper.Primer_Nombre,\' \',oper.Segundo_Nombre,\' \',oper.Primer_Apellido,\' \',oper.Segundo_Apellido,\' \') as NombreOperario,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual'
                    )
                    ])
                ->join('RRHH_empleados as Em', 'LabLecturaSalidas.id_Patinador', '=', 'Em.id')
                ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaSalidas.CodigoBarras', '=', 'GetEt.BarCode')
                ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
                ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
                ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
                ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id')
                ->join('LabLecturaEntradas as lectEntr', 'lectEntr.CodigoBarras', '=', 'LabLecturaSalidas.CodigoBarras')
                ->join('RRHH_empleados as oper', 'oper.Codigo_Empleado', '=', 'lectEntr.CodOperario')/*aqui*/
                ->join('LabTipSalida_AjusteInvetarios as Tsalida', 'Tsalida.id', '=', 'LabLecturaSalidas.id_TipoSalida')
                ->join('labCausalesDescartes as ca', 'ca.id', '=', 'LabLecturaSalidas.id_TipoCancelado', 'left outer')
                ->join('lab_cuartos as cuar', 'lectEntr.id_Cuarto', '=', 'cuar.id')
                ->join('lab_estantes as est', 'lectEntr.id_estante', '=', 'est.id')
                ->join('lab_nivels as nilv', 'lectEntr.id_piso', '=', 'nilv.id')
                ->where('LabLecturaSalidas.Flag_Activo', 1)
                ->whereBetween('LabLecturaSalidas.created_at', array($Fini . " 00:00:00", $Ffin . " 23:59:59"))
                ->get();
            //dd($ReporEntrada);
            return response()->json(['data' => $ReporSalida]);

        }
    }

    public function DescargaInventario()
    {
        //return (new UsersExport)->collection()->download('invoices.xlsx');
        //return (new InvoicesExport)->download('invoices.xlsx');
        set_time_limit(0);
        return Excel::download(new ReporteInventario, 'Reporte Inventario-' . Carbon::now()->format('Y-m-d') . '.xlsx');


    }

    public function DescargaInventarioTotal()
    {
        //return (new UsersExport)->collection()->download('invoices.xlsx');
        //return (new InvoicesExport)->download('invoices.xlsx');
        set_time_limit(0);
        return Excel::download(new ReporteInventarioTotal, 'Reporte Inventario Total-' . Carbon::now()->format('Y-m-d') . '.xlsx');


    }

    public function ReporteEntradaDinamico($FechaInicial, $FechaFinal, $IDVariedad)
    {
        //dd($IDVariedad);


        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');
        $Activo='ACTIVO';
//dd($FechaInicial);
        $array = explode(',', $IDVariedad);
        $ReporEntradaDinamico = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                          vari.Nombre_Variedad as Variedad,
                          gen.NombreGenero as Genero,
                          LabLecturaEntradas.CodigoBarras,
                          GetEt.Indentificador as Identificador,
                          fac.NombreFase as FaseActual,
                          GetEt.TipoContenedor as Contendor,
                          LabLecturaEntradas.created_at as Fecha_Lectura,
                          (CASE WHEN LabLecturaEntradas.Flag_Activo = 1 THEN \'Activos\' ELSE \'Inactivos\' END) AS Estado,
                        CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual,
                        LabLecturaEntradas.Plantas,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                )]
            )
            ->join('RRHH_empleados as Em', 'LabLecturaEntradas.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradas.CodOperario', 'left outer')
            ->join('lab_cuartos as cuar', 'LabLecturaEntradas.id_Cuarto', '=', 'cuar.id')
            ->join('lab_estantes as est', 'LabLecturaEntradas.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'LabLecturaEntradas.id_piso', '=', 'nilv.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('cargue_inventario as cin ', 'GetEt.ID_Inventario', '=', 'cin.id', 'left outer')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->whereBetween('LabLecturaEntradas.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->wherein('GetEt.ID_Variedad', $array)
            ->get();
        //dd($ReporEntradaDinamico);
        //return $ReporEntradaDinamico;
        return response()->json(['data' => $ReporEntradaDinamico]);

    }

    public function ReporteSalidaDinamico($FechaInicial, $FechaFinal, $IDVariedad)
    {

        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');

        $array = explode(',', $IDVariedad);
        $ReporSalidaDinamico = DB::table('LabLecturaSalidas')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        vari.Nombre_Variedad,
                        gen.NombreGenero,
                        LabLecturaSalidas.CodigoBarras,
                        GetEt.Indentificador,
                        GetEt.SemanUltimoMovimiento,
                        fac.NombreFase,
                        GetEt.TipoContenedor,
                        LabLecturaSalidas.created_at,
                        lectEntr.Plantas,
                        Tsalida.TipoSalida_Ajuste as Tipo_Salida,
                        ca.CausalDescarte as Causal_Salida,
                        CONCAT(year(LabLecturaSalidas.created_at), DATEPART(ISO_WEEK, LabLecturaSalidas.created_at)) as SemanaSalida,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(oper.Primer_Nombre,\' \',oper.Segundo_Nombre,\' \',oper.Primer_Apellido,\' \',oper.Segundo_Apellido,\' \') as NombreOperario,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaSalidas.id_Patinador', '=', 'Em.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaSalidas.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id')
            ->join('LabLecturaEntradas as lectEntr', 'lectEntr.CodigoBarras', '=', 'LabLecturaSalidas.CodigoBarras')
            ->join('RRHH_empleados as oper', 'oper.Codigo_Empleado', '=', 'lectEntr.CodOperario')/*aqui*/
            ->join('LabTipSalida_AjusteInvetarios as Tsalida', 'Tsalida.id', '=', 'LabLecturaSalidas.id_TipoSalida')
            ->join('labCausalesDescartes as ca', 'ca.id', '=', 'LabLecturaSalidas.id_TipoCancelado', 'left outer')
            ->join('lab_cuartos as cuar', 'lectEntr.id_Cuarto', '=', 'cuar.id')
            ->join('lab_estantes as est', 'lectEntr.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'lectEntr.id_piso', '=', 'nilv.id')
            ->where('LabLecturaSalidas.Flag_Activo', 1)
            ->whereBetween('LabLecturaSalidas.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->wherein('GetEt.ID_Variedad', $array)
            ->get();
        //dd($ReporEntradaDinamico);
        //return $ReporEntradaDinamico;
        return response()->json(['data' => $ReporSalidaDinamico]);

    }

    public function ReporteDespunteDinamico($FechaInicial, $FechaFinal, $IDVariedad)
    {

        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');
        $Activo='ACTIVO';
//dd($FechaInicial);
        $array = explode(',', $IDVariedad);
        $ReporEntradaDinamico = DB::table('LabLecturaDespunte')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                          vari.Nombre_Variedad as Variedad,
                          gen.NombreGenero as Genero,
                          LabLecturaDespunte.CodigoBarras,
                          GetEt.Indentificador as Identificador,
                          fac.NombreFase as FaseActual,
                          GetEt.TipoContenedor as Contendor,
                          GetEt.CantContenedor as Plantas,
                          LabLecturaDespunte.created_at as Fecha_Lectura,
                        CONCAT(year(LabLecturaDespunte.created_at), DATEPART(ISO_WEEK, LabLecturaDespunte.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario'
                )]
            )
            ->join('RRHH_empleados as Em', 'LabLecturaDespunte.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaDespunte.CodOperario', 'left outer')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaDespunte.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->whereBetween('LabLecturaDespunte.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->wherein('GetEt.ID_Variedad', $array)
            ->get();
        //dd($ReporEntradaDinamico);
        //return $ReporEntradaDinamico;
        return response()->json(['data' => $ReporEntradaDinamico]);

    }

    public function ReporteEntradaDinamicoFecha($FechaInicial, $FechaFinal)
    {
        //dd($FechaInicial,$FechaFinal);


        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');

        $ReporEntradaDinamico = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                          vari.Nombre_Variedad as Variedad,
                          gen.NombreGenero as Genero,
                          LabLecturaEntradas.CodigoBarras,
                          GetEt.Indentificador as Identificador,
                          fac.NombreFase as FaseActual,
                          GetEt.TipoContenedor as Contendor,
                          LabLecturaEntradas.created_at as Fecha_Lectura,
                        CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual,
                        LabLecturaEntradas.Plantas,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario,
                        cli.Nombre as NombreCliente'
                )]
            )
            ->join('RRHH_empleados as Em', 'LabLecturaEntradas.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'LabLecturaEntradas.CodOperario', 'left outer')
            ->join('lab_cuartos as cuar', 'LabLecturaEntradas.id_Cuarto', '=', 'cuar.id')
            ->join('lab_estantes as est', 'LabLecturaEntradas.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'LabLecturaEntradas.id_piso', '=', 'nilv.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('cargue_inventario as cin ', 'GetEt.ID_Inventario', '=', 'cin.id', 'left outer')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->whereBetween('LabLecturaEntradas.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->where('LabLecturaEntradas.Flag_Activo', 1)
            ->get();
        //dd($ReporEntradaDinamico);
        //return $ReporEntradaDinamico;
        return response()->json(['data' => $ReporEntradaDinamico]);

    }

    public function ReporteSalidaDinamicoFecha($FechaInicial, $FechaFinal)
    {
        $FechaInicial = Carbon::parse($FechaInicial)->format('Y-d-m');
        $FechaFinal = Carbon::parse($FechaFinal)->format('Y-d-m');

        $ReporSalidaDinamico = DB::table('LabLecturaSalidas')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                        vari.Nombre_Variedad,
                        gen.NombreGenero,
                        LabLecturaSalidas.CodigoBarras,
                        GetEt.Indentificador,
                        GetEt.SemanUltimoMovimiento,
                        fac.NombreFase,
                        GetEt.TipoContenedor,
                        LabLecturaSalidas.created_at,
                        lectEntr.Plantas,
                        Tsalida.TipoSalida_Ajuste as Tipo_Salida,
                        ca.CausalDescarte as Causal_Salida,
                        CONCAT(year(LabLecturaSalidas.created_at), DATEPART(ISO_WEEK, LabLecturaSalidas.created_at)) as SemanaSalida,
                        CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                        CONCAT(oper.Primer_Nombre,\' \',oper.Segundo_Nombre,\' \',oper.Primer_Apellido,\' \',oper.Segundo_Apellido,\' \') as NombreOperario,
                        CONCAT(cuar.N_Cuarto,\'-\',est.N_Estante,\'-\',nilv.N_Nivel) as UbicacionActual'
                )
                ])
            ->join('RRHH_empleados as Em', 'LabLecturaSalidas.id_Patinador', '=', 'Em.id')
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaSalidas.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id')
            ->join('LabLecturaEntradas as lectEntr', 'lectEntr.CodigoBarras', '=', 'LabLecturaSalidas.CodigoBarras')
            ->join('RRHH_empleados as oper', 'oper.Codigo_Empleado', '=', 'lectEntr.CodOperario')/*aqui*/
            ->join('LabTipSalida_AjusteInvetarios as Tsalida', 'Tsalida.id', '=', 'LabLecturaSalidas.id_TipoSalida')
            ->join('labCausalesDescartes as ca', 'ca.id', '=', 'LabLecturaSalidas.id_TipoCancelado', 'left outer')
            ->join('lab_cuartos as cuar', 'lectEntr.id_Cuarto', '=', 'cuar.id')
            ->join('lab_estantes as est', 'lectEntr.id_estante', '=', 'est.id')
            ->join('lab_nivels as nilv', 'lectEntr.id_piso', '=', 'nilv.id')
            ->where('LabLecturaSalidas.Flag_Activo', 1)
            ->whereBetween('LabLecturaSalidas.created_at', array($FechaInicial . " 00:00:00", $FechaFinal . " 23:59:59"))
            ->get();
        //dd($ReporEntradaDinamico);
        //return $ReporEntradaDinamico;
        return response()->json(['data' => $ReporSalidaDinamico]);

    }
}






