<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetEtiquetasLabInventario extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "GetEtiquetasLabInventario";
    protected $fillable = [
        'ID',
        'ID_Variedad',
        'CodigoVariedad',
        'BarCode',
        'CanInventario',
        'CantContenedor',
        'TipoContenedor',
        'CantEtiquetas',
        'ID_Inventario',
        'SemanUltimoMovimiento',
        'SemanaIngreso',
        'SemanaDespacho',
        'Indentificador',
        'Radicado',
        'id_Cuarto',
        'id_Estante',
        'id_Nivel',
        'Impresa',
        'Procedencia',
        'cliente',
        'ID_FaseActual',
    ];

    public static function ReporteInv()
    {

        $dateA = Carbon::now();
        $year = $dateA->format('Y');
        $Day = $dateA->week();

        if (strlen($Day) === 1) {
            $Day = '0' . $Day;
        }
        $fecha = $year . '' . $Day;


        $ReporEntrada = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    '(CASE WHEN vari.Codigo < 2000000 THEN \'URC\' ELSE \'COM\' END) AS Tipo,
                        vari.Codigo,
                          vari.Nombre_Variedad,
                          gen.NombreGenero,
                          GetEt.Indentificador,
                          LabLecturaEntradas.CodigoBarras,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                         (CASE
                           WHEN
                           (CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at))) = 202153
                                THEN \'202053\'
                           WHEN
                            (CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at))) != 202153
                                THEN CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at))
	                     END) AS SemanaEntrada,
                        ' . $fecha . '  - GetEt.SemanUltimoMovimiento as edad,
                        GetEt.SemanUltimoMovimiento,
                        GetEt.SemanaDespacho,
                        CONCAT(cuar.N_Cuarto,\',\',est.N_Estante,\',\',nilv.N_Nivel) as UbicacionActual,
                        LabLecturaEntradas.Plantas,
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
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->where('LabLecturaEntradas.Flag_Activo', '=', 1)
            ->get();
        //dd($ReporEntrada->all());
        return $ReporEntrada;


    }

    public static function ReporteInvTotal()
    {
        $ReporteTotal = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    'vari.Codigo,
                          vari.Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradas.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                        CONCAT(year(LabLecturaEntradas.created_at), DATEPART(ISO_WEEK, LabLecturaEntradas.created_at)) as SemanaEntrada,
                        GetEt.SemanUltimoMovimiento,
                        GetEt.SemanaDespacho,
                        CONCAT(cuar.N_Cuarto,\',\',est.N_Estante,\',\',nilv.N_Nivel) as UbicacionActual,
                        LabLecturaEntradas.Plantas,
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
            ->join('tipo_fases_labs as fac', 'GetEt.ID_FaseActual', '=', 'fac.id', 'left outer')
            ->join('clientesYBreeder_labs as cli', 'GetEt.cliente', '=', 'cli.Indicativo', 'left outer')
            ->get();
        //dd($ReporEntrada);
        return $ReporteTotal;

    }

    public static function ReporteInvTotalActivoInvernadero()
    {
        $ReporteTotal = DB::table('LabLecturaEntradasInvernadero')
            ->select(
                [DB::raw(
                    '(CASE WHEN vari.Codigo < 2000000 THEN \'URC\' ELSE \'COM\' END) AS Tipo,
                    vari.Codigo,
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as Nombre_Variedad,
                          gen.NombreGenero,
                          LabLecturaEntradasInvernadero.CodigoBarras,
                          GetEt.Indentificador,
                          fac.NombreFase,
                          GetEt.TipoContenedor,
                        CONCAT(year(LabLecturaEntradasInvernadero.created_at), DATEPART(ISO_WEEK, LabLecturaEntradasInvernadero.created_at)) as SemanaEntrada,
                        GetEt.SemanaDespacho,
                        LabLecturaEntradasInvernadero.Plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual,
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
            ->where('LabLecturaEntradasInvernadero.Flag_Activo', '=', 1)
            ->get();
        //dd($ReporEntrada);
        return $ReporteTotal;

    }

    public static function ProgramasEjecutadosSalidasWeekPA()
    {
        $lunespasado = new Carbon('previous monday');
        $Sabadopasado = new Carbon('last Saturday');
        $lunespasado = $lunespasado->format('Y-d-m');
        $Sabadopasado = $Sabadopasado->format('Y-d-m');
        $lunesactual = new Carbon('last monday');
        $lunespasado = $lunesactual->subDays(7)->format('Y-d-m');

        $programasEjecutadosSalidasPa = DB::table('LabLecturaSalidas as SA')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'SA.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->where('SA.Flag_Activo', '=', 1)
            ->where('SA.id_TipoSalida', '=', 8)
            //->where('ETI.Indentificador', '=', 'DAR1204726201549')
            ->whereBetween('SA.created_at', array($lunespasado . " 00:00:00", $Sabadopasado . " 23:59:59"))
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            )->get();

        //dd($lunespasado);

        return $programasEjecutadosSalidasPa;
    }

    public static function ProgramasEjecutadosEntradasWeekPA()
    {
        $lunespasado = new Carbon('previous monday');
        $Sabadopasado = new Carbon('last Saturday');
        $lunespasado = $lunespasado->format('Y-d-m');
        $Sabadopasado = $Sabadopasado->format('Y-d-m');
        $lunesactual = new Carbon('last monday');
        $lunespasado = $lunesactual->subDays(7)->format('Y-d-m');


        $programasEjecutadosEntradsPa = DB::table('LabLecturaEntradas as entr')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'entr.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->where('entr.Flag_Activo', '=', 1)
            ->whereBetween('entr.created_at', array($lunespasado . " 00:00:00", $Sabadopasado . " 23:59:59"))
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            );

        $programasEjecutadosEntradsPaInv = DB::table('LabLecturaEntradasInvernadero as entr')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'entr.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->where('entr.Flag_Activo', '=', 1)
            ->whereBetween('entr.created_at', array($lunespasado . " 00:00:00", $Sabadopasado . " 23:59:59"))
            ->unionAll($programasEjecutadosEntradsPa)
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            )->get();

        //dd();

        return $programasEjecutadosEntradsPaInv;

    }

    public static function ProgramasEjecutadosSalidasWeekAC()
    {
        $sabadoNetx = new Carbon('next Saturday');
        $UltimoDomingo = new Carbon('last sunday');
        $lunesactual = $UltimoDomingo->addDays(1)->format('Y-d-m');
        $sabadoNetx = $sabadoNetx->format('Y-d-m');

        $programasEjecutadosSalidasAc = DB::table('LabLecturaSalidas as SA')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'SA.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->where('SA.Flag_Activo', '=', 1)
            ->where('SA.id_TipoSalida', '=', 8)
            ->whereBetween('SA.updated_at', array($lunesactual . " 00:00:00", $sabadoNetx . " 23:59:59"))
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            )->get();

        return $programasEjecutadosSalidasAc;
    }

    public static function ProgramasEjecutadosEntradasWeekAC()
    {

        $sabadoNetx = new Carbon('next Saturday');
        $UltimoDomingo = new Carbon('last sunday');
        $lunesactual = $UltimoDomingo->addDays(1)->format('Y-d-m');
        $sabadoNetx = $sabadoNetx->format('Y-d-m');

        $programasEjecutadosEntradsAC = DB::table('LabLecturaEntradas as entr')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'entr.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->where('entr.Flag_Activo', '=', 1)
            ->whereBetween('entr.created_at', array($lunesactual . " 00:00:00", $sabadoNetx . " 23:59:59"))
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            );

        $programasEjecutadosEntradsPaInv = DB::table('LabLecturaEntradasInvernadero as entr')
            ->join('GetEtiquetasLabInventario as ETI', 'ETI.BarCode', '=', 'entr.CodigoBarras')
            ->join('tipo_fases_labs as FA', 'FA.ID', '=', 'ETI.ID_FaseActual')
            ->join('URC_Variedades as varr', 'varr.ID', '=', 'ETI.ID_Variedad')
            ->join('URC_Especies as esp', 'varr.ID_Especie', '=', 'esp.id')
            ->join('URC_Generos as Gene', 'esp.Id_Genero', '=', 'Gene.id')
            ->select([
                DB::raw('(SUM (ETI.CantContenedor)) AS CantPlantasSalidas'),
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'varr.Codigo',
                'ETI.cliente'
            ])
            ->where('entr.Flag_Activo', '=', 1)
            ->whereBetween('entr.created_at', array($lunesactual . " 00:00:00", $sabadoNetx . " 23:59:59"))
            ->unionAll($programasEjecutadosEntradsAC)
            ->groupBy(
                'ETI.Indentificador',
                'FA.NombreFase',
                'ETI.SemanaDespacho',
                'Gene.NombreGenero',
                'varr.Nombre_Variedad',
                'ETI.cliente',
                'varr.Codigo'
            )->get();

        //dd();

        return $programasEjecutadosEntradsPaInv;
    }

    public static function ProgramasPendientesInvernadero()
    {

        $now = Carbon::now();
        $yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;
        $SemanaActual1 = $yearAc . '' . $SemanaAc;

        $ProgramasPendientesInvernadero = DB::table('LabLecturaEntradasInvernadero')
            ->select(
                [DB::raw(
                    '
                        CONCAT(vari.Nombre_Variedad,\' \',sva.CodigoInterno) as NombreVariedad,
                          gen.NombreGenero,
                          GetEt.Indentificador,
                        GetEt.SemanaDespacho,
                        sum(LabLecturaEntradasInvernadero.Plantas) as plantas,
                        CONCAT(inv_camas.N_Cama,\'-\',inv_seccionCamas.N_Seccion) as UbicacionActual'
                )
                ])
            ->join('GetEtiquetasLabInventario as GetEt', 'LabLecturaEntradasInvernadero.CodigoBarras', '=', 'GetEt.BarCode')
            ->join('URC_Variedades as vari', 'GetEt.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('inv_camas', 'inv_camas.id', '=', 'LabLecturaEntradasInvernadero.id_Cama')
            ->join('inv_seccionCamas', 'inv_seccionCamas.id', '=', 'LabLecturaEntradasInvernadero.id_SeccionCama')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('Labadaptacioninvernadero as sva', 'sva.id', '=', 'GetEt.ID_Inventario', 'left outer')
            ->where('GetEt.SemanaDespacho', '<', $SemanaActual1)
            ->where('LabLecturaEntradasInvernadero.Flag_Activo', '=', 1)
            ->groupBy(
                [DB::raw('Nombre_Variedad, GetEt.SemanaDespacho, Indentificador, CodigoInterno, N_Cama,N_Seccion, gen.NombreGenero')])
            ->get();
        //dd($ProgramasPendientesInvernadero);
        return $ProgramasPendientesInvernadero;
    }

    public static function ProgramasLaboratorio()
    {

        $now = Carbon::now();
        $yearAc = $now->year;
        $SemanaAc = $now->weekOfYear;
        $SemanaActual1 = $yearAc . '' . $SemanaAc;
        $semanaAdicional = '5';;
        $resultado = $SemanaActual1 - $semanaAdicional;

        //dd($resultado);
        $Programas = DB::table('LabLecturaEntradas')
            ->select(
                [DB::raw(
                    'GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento,
                                GetEtiquetasLabInventario.ID_FaseActual,
                                sum(GetEtiquetasLabInventario.CantContenedor)as CantidadPlantas'
                )
                ])
            ->join('GetEtiquetasLabInventario', 'LabLecturaEntradas.CodigoBarras', '=', 'GetEtiquetasLabInventario.BarCode')
            ->where('LabLecturaEntradas.Flag_Activo', '=', 1)
            ->where('GetEtiquetasLabInventario.ID_FaseActual', '>=', 6)
            ->where('GetEtiquetasLabInventario.SemanUltimoMovimiento', '<=', $resultado)
            ->groupBy(
                [DB::raw('GetEtiquetasLabInventario.CodigoVariedad,
                                GetEtiquetasLabInventario.Indentificador,
                                GetEtiquetasLabInventario.SemanaDespacho,
                                GetEtiquetasLabInventario.ID_FaseActual,
                                GetEtiquetasLabInventario.SemanUltimoMovimiento')])
            ->get();
        return $Programas;

    }

    /*EJECUCION PROPAGAMAS SEMANALES*/

    public static function EjecucionSemanales()
    {
        $dateA = Carbon::now();
        $dateMasSema = $dateA->addDays(7);
        $dateMasSema = $dateMasSema->format('Y-m-d');

        $SemanaEjecucion = ModelAnoSemana::query()->select('AnoYSemana')->where('Fecha', $dateMasSema)->first();
        $ProximaEjecucionInv = GetEtiquetasLabInventario::query()
            ->select(
                'gen.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cli.Nombre as NombreCliente',
                'Indentificador'
            )
            ->join('LabLecturaEntradas as en', 'en.CodigoBarras', '=', 'Barcode')
            ->join('lab_infotecnica_variedades as info', function ($join) {
                $join->on('info.id_Variedad', '=', 'GetEtiquetasLabInventario.ID_Variedad')
                    ->on('GetEtiquetasLabInventario.ID_FaseActual', '=', 'info.id_fase');
            })
            ->join('URC_Variedades as vari', 'GetEtiquetasLabInventario.CodigoVariedad', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('clientesYBreeder_labs as cli', 'GetEtiquetasLabInventario.cliente', '=', 'cli.Indicativo', 'left outer')
            ->where(DB::raw("SemanUltimoMovimiento + info.SemanasXFase"), '=', $SemanaEjecucion->AnoYSemana)
            ->where('en.Flag_Activo', 1)
            ->where('ID_FaseActual', '<=', 8)
            ->groupBy('gen.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cli.Nombre',
                'Indentificador');

        $ProximaEjecucion = ModelIntroduccionesFuturas::query()
            ->select(
                'gen.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cli.Nombre as NombreCliente',
                DB::raw('null as Indentificador')
            )
            ->leftJoin('URC_Variedades as vari', 'LabIntroduciconesFuturas.IdVariedad', '=', 'vari.id ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('clientesYBreeder_labs as cli', 'LabIntroduciconesFuturas.IdCliente', '=', 'cli.id')
            ->where('LabIntroduciconesFuturas.SemanaIntroduccion', $SemanaEjecucion->AnoYSemana)
            ->unionAll($ProximaEjecucionInv)
            ->get();
        //dd($ProximaEjecucion);
        return $ProximaEjecucion;
    }

}

