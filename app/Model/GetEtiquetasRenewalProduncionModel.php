<?php

namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class GetEtiquetasRenewalProduncionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "GetEtiquetasRenewalProduncion";
    protected $fillable = [
        'id',
        'SemanaActual',
        'Fecha',
        'PlotIDNuevo',
        'PlotIDOrigen',
        'SubPlotID',
        'CodigoIntegracion',
        'Cantidad',
        'VolumenVariedad',
        'CantidadBolsillos',
        'CodigoBarras',
        'Caja',
        'CodigoBarrasCaja',
        'Bloque',
        'Nave',
        'Cama',
        'ProcedenciaInv',
        'SemanaCosecha',
        'ID_User',
        'EsquejesXBolsillo',
        'Procedencia',
        'Radicado',
        'Flag_Activo',
        'RadicadoParcial',
    ];

    /*public static function DetalleCajaSalidaCF ($numerocaja)
    {
        //dd($numerocaja);

        $detallecaja = DB::table('GetEtiquetasInventarioProduccion AS ETI')
            ->select(DB::raw('
                    ETI.NumeroCaja,
                    V.Nombre_Variedad,
                    COUNT(ETI.CodigoBarras) AS CantNecesaria,
                    COUNT(EN.CodigoBarras) AS CantInventario,
                    COUNT(SA.CodigoBarras) AS CantEmpacada
               '))
            ->leftJoin('prod_lectura_entrada_produccion_CF AS EN', 'EN.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->leftJoin('prod_lectura_salida_produccion_CF AS SA', 'SA.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.Cod_Integracion_Ventas')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
            ->where('ETI.Flag_Activo',1)
            ->where('ETI.CodigoBarrasCaja', $numerocaja)
            ->groupByRaw('
                    ETI.NumeroCaja,
	                V.Nombre_Variedad
                    ')
            ->get();

        return ($detallecaja);
    }
    */
    public static function DetalleCajaSalidaCF($numerocaja)
    {
        $detallecaja = DB::table('GetEtiquetasRenewalProduncion AS ETI')
            ->select(DB::raw('
                    ETI.Caja,
                    V.Nombre_Variedad,
                    COUNT(ETI.CodigoBarras) AS CantNecesaria,
                    COUNT(EN.CodigoBarras) AS CantInventario,
                    COUNT(SA.CodigoBarras) AS CantEmpacada
               '))
            ->leftJoin('prod_lectura_entrada_renewals AS EN', 'EN.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->leftJoin('prod_lectura_salida_renewals AS SA', 'SA.CodigoBarras', '=', 'ETI.CodigoBarras')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'ETI.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS G', 'G.id', '=', 'E.Id_Genero')
            ->where('ETI.Flag_Activo', 1)
            ->where('ETI.CodigoBarrasCaja', $numerocaja)
            ->groupByRaw('
                    ETI.Caja,
	                V.Nombre_Variedad
                    ')
            ->get();

        return ($detallecaja);
    }

    public static function UltimalecturaEntradaPropagacion($request)
    {
        //dd($request);
        $plot = GetEtiquetasRenewalProduncionModel::query()
            ->select('PlotIDNuevo')
            ->where('CodigoBarras', $request['CodigoBarras'])
            ->first();
        $UltimaLectura = DB::table('URCLecturaEntradaPropagacion as entra')
            ->select(
                [DB::raw(
                    'CONCAT(gen.NombreGenero,\'  \',vari.Nombre_Variedad,\' \') as Nombre_Variedad,
                        PlotIDNuevo,
                        sum(Plantas) as PLantas,
                    count(entra.CodigoBarras) as Bandejas,
                    (SELECT  count(CodigoBarras)  FROM URCLecturaEntradaPropagacion WHERE idUbicacion =' . $request['idUbicacion'] . 'and Flag_Activo=1)as TotalBandBan'
                )
                ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('PlotIDNuevo', $plot->PlotIDNuevo)
            ->groupBy('gen.NombreGenero', 'vari.Nombre_Variedad', 'PlotIDNuevo')
            ->first();


        /*   $UltimaLectura = DB::table('URCLecturaEntradaPropagacion as entra')
               ->select(
                   [DB::raw(
                       'CONCAT(gen.NombreGenero,\'  \',vari.Nombre_Variedad,\' \') as Nombre_Variedad,
                           PlotIDNuevo,
                           sum(Plantas) as PLantas,
                       count(entra.CodigoBarras) as Bandejas'
                   )
                   ])
               ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
               ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
               ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
               ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
               ->where('PlotIDNuevo', $plot->PlotIDNuevo)
               ->groupBy('gen.NombreGenero', 'vari.Nombre_Variedad', 'PlotIDNuevo')
               ->first();*/
        return $UltimaLectura;
    }

    public static function CosultarPlotId($request)
    {

        $UltimaLectura = RegistroPLotIDPropagacion::query()
            ->select([
                'PlotIDNuevo',
                'CantidaPlantasPropagacionInventario',
                DB::raw('CONCAT(gen.NombreGenero,\'  \',vari.Nombre_Variedad,\' \') as Nombre_Variedad'),
                DB::raw('count(CodigoBarras) as CantidadBandejas'),
            ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'GetEt.PlotIDNuevo', '=', 'urcPropagacionsRegistroPlotID.PlotId')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('PlotIDNuevo', $request['PlotIdD'])
            ->groupBy('gen.NombreGenero', 'vari.Nombre_Variedad', 'PlotIDNuevo', 'CantidaPlantasPropagacionInventario')
            ->first();
        return $UltimaLectura;
    }

    public static function PropagacionConfirmacionesSalidas($request)
    {
        $dateA = Carbon::now();
        $year = $dateA->format('Y');
        $Day = $dateA->week();

        if (strlen($Day) === 1) {
            $Day = '0' . $Day;
        }
        $SemanaActual = $year . '' . $Day;

        $confirmaciones = urcPropagacionConfirmaciones::query()
            ->select([
                'PlotId',
                'plantasconfirmadas',
                'semanaConfirmacionModificada',
                'Flag_Activo',
            ])
            ->where('PlotId', $request['PlotIdD'])
            ->where('semanaConfirmacionModificada', $SemanaActual)
            ->where('Flag_Activo', 1)
            ->first();

        return $confirmaciones;
    }

    public static function ConsultaDescargueInventarioDiscriminado()
    {
        $ReporEntrada = DB::table('URCLecturaEntradaPropagacion as entra')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'PlotIDOrigen',
                    'CodigoIntegracion',
                    'entra.CodigoBarras',
                    'Ubicacion',
                    'SemanaCosecha as SemaDespacho',
                    'Plantas',
                    'SemanaLectura',
                    DB::raw(
                        'CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as NombrePatinador,
                       CONCAT(Emp.Primer_Nombre,\' \',Emp.Segundo_Nombre,\' \',Emp.Primer_Apellido,\' \',Emp.Segundo_Apellido,\' \') as NombreOperario'
                    )
                ])
            ->join('RRHH_empleados as Em', 'entra.id_Patinador', '=', 'Em.id')
            ->join('RRHH_empleados as Emp', 'Emp.Codigo_Empleado', '=', 'entra.CodOperario')
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('URC_Propagacion as pro', 'pro.id', '=', 'entra.idUbicacion')
            ->where('entra.Flag_Activo', 1)
            ->get();

        return $ReporEntrada;
    }

    public static function ConsultaDescargueInventarioAgrupado()
    {
        $ReporEntrada = DB::table('URCLecturaEntradaPropagacion as entra')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'CodigoIntegracion',
                    'pr.CantidaInicialPlantasProgramadas as Programadas',
                    'pr.CantidaPlantasPropagacionInicial as Ingresadas',
                    'pr.CantidaPlantasPropagacionInventario as actuales',
                    'ubi.Ubicacion',
                    'entra.SemanaLectura'
                ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('urcPropagacionsRegistroPlotID as pr', 'pr.PlotId', '=', 'GetEt.PlotIDNuevo')
            ->join('URC_Propagacion as ubi', 'ubi.id', '=', 'entra.idUbicacion')
            ->where('entra.Flag_Activo', 1)
            ->groupBy('vari.Nombre_Variedad',
                'gen.NombreGenero',
                'PlotIDNuevo',
                'CodigoIntegracion',
                'pr.CantidaPlantasPropagacionInventario',
                'pr.CantidaInicialPlantasProgramadas',
                'pr.CantidaPlantasPropagacionInicial',
                'Ubicacion', 'SemanaLectura'
            )
            ->get();

        return $ReporEntrada;
    }

    public static function ConsultaDescargueSalidasAgrupado()
    {
        $ReporSalida = DB::table('URCLecturaSalidaPropagacion as sali')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'CodigoIntegracion',
                    'SemanaCosecha as SemaDespacho',
                    'sali.SemanaLectura',
                    'sali.CantPlantas',
                ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'GetEt.PlotIDNuevo', '=', 'sali.PlotID')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('sali.Flag_Activo', 1)
            ->groupBy('vari.Nombre_Variedad',
                'gen.NombreGenero',
                'PlotIDNuevo',
                'CodigoIntegracion',
                'SemanaCosecha',
                'sali.CantPlantas',
                'sali.SemanaLectura')
            ->get();

        return $ReporSalida;
    }

    public static function ConsultaDescargueDescartesAgrupado()
    {
        $ReporDescarte = DB::table('URCLecturaDescartePropagacion as dess')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'PlotIDNuevo',
                    'cau.CausalDescarte',
                    DB::RAW('sum(dess.PlantasDescartadas) as PlantasDescartadas'),
                    DB::RAW('CONCAT(year(dess.created_at), DATEPART(ISO_WEEK, dess.created_at)) as SemanaDescarte')
                ])
            ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'dess.PlotId')
            ->join('URC_CausalesDescartesPropagacion as cau', 'cau.id', '=', 'dess.CausalDescarte')
            ->join('URC_Variedades as vari', 'pro.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->groupBy([
                'PlotIDNuevo',
                'Nombre_Variedad',
                'cau.CausalDescarte',
                'NombreGenero',
                'Semana',
                DB::RAW('CONCAT(year(dess.created_at), DATEPART(ISO_WEEK, dess.created_at))')
            ])
            ->get();

        return $ReporDescarte;
    }

    public static function CosultarPlotIdArqueo($request)
    {

        $UltimaLectura = RegistroPLotIDPropagacion::query()
            ->select([
                'PlotIDNuevo',
                'CantidaPlantasPropagacionInventario',
                DB::raw('CONCAT(gen.NombreGenero,\'  \',vari.Nombre_Variedad,\' \') as Nombre_Variedad'),
                DB::raw('count(en.CodigoBarras) as CantidadBandejas'),
            ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'GetEt.PlotIDNuevo', '=', 'urcPropagacionsRegistroPlotID.PlotId')
            ->join('URCLecturaEntradaPropagacion as en', 'en.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->where('PlotIDNuevo', $request['PlotIdD'])
            ->where('en.Flag_Activo', 1)
            ->groupBy('gen.NombreGenero', 'vari.Nombre_Variedad', 'PlotIDNuevo', 'CantidaPlantasPropagacionInventario')
            ->first();
        return $UltimaLectura;
    }

    public static function EstadoPlotIdentregas()
    {

        $ReporEstadoPlot = DB::table('URCLecturaEntradaPropagacion as entra')
            ->select(
                ['vari.Nombre_Variedad',
                    'gen.NombreGenero',
                    'pro.PlotIDNuevo',
                    'vari.Codigo',
                    'pr.CantidaPlantasPropagacionInventario as actuales',
                    'pro.Legalizar',
                    'sa.CantPlantas as CantidadEntregada'
                ])
            ->join('GetEtiquetasRenewalProduncion as GetEt', 'entra.CodigoBarras', '=', 'GetEt.CodigoBarras')
            ->join('URC_Variedades as vari', 'GetEt.CodigoIntegracion', '=', 'vari.Codigo ')
            ->join('URC_Especies as Esp', 'vari.ID_Especie', '=', 'Esp.id')
            ->join('URC_Generos as gen', 'Esp.Id_Genero', '=', 'gen.id')
            ->join('urcPropagacionsRegistroPlotID as pr', 'pr.PlotId', '=', 'GetEt.PlotIDNuevo')
            ->join('prod_inventario_renewals as pro', 'pro.PlotIDNuevo', '=', 'pr.PlotId')
            ->leftJoin('URCLecturaSalidaPropagacion as sa', 'sa.plotid', '=', 'GetET.PlotIdNuevo')
            ->where('entra.Flag_Activo', 1)
            ->where('pr.Flag_Activo', 1)
            ->where('pr.CantidaPlantasPropagacionInventario', '>',0)
            ->groupBy('vari.Nombre_Variedad',
                'vari.Nombre_Variedad',
                'gen.NombreGenero',
                'pro.PlotIDNuevo',
                'vari.Codigo',
                'pr.CantidaPlantasPropagacionInventario',
                'pro.Legalizar',
                'sa.CantPlantas'
                )->get();

        return $ReporEstadoPlot;
    }

    public static function ConfirmacionesEntregadas()
    {

        $confirmaciones = urcPropagacionConfirmaciones::query()
            ->select(
                'GE.NombreGenero',
                'v.Nombre_Variedad',
                'v.Codigo',
                'gettR.PlotIDNuevo',
                'semanaConfirmacionModificada',
                'plantasconfirmadas',
                'sa.CantPlantas'
            )
            ->join('GetEtiquetasRenewalProduncion as gettR', 'gettR.PlotIDNuevo', '=', 'urcPropagacionConfirmaciones.PlotId')
            ->join('URC_Variedades AS V', 'V.Codigo', '=', 'gettR.CodigoIntegracion')
            ->join('URC_Especies AS E', 'E.id', '=', 'V.ID_Especie')
            ->join('URC_Generos AS GE', 'GE.id', '=', 'E.Id_Genero')
            ->join('URCLecturaSalidaPropagacion AS sa', 'sa.PlotId', 'urcPropagacionConfirmaciones.PlotId')
            ->join('URCLecturaSalidaPropagacion AS saa', 'saa.SemanaLectura', 'urcPropagacionConfirmaciones.semanaConfirmacionModificada')
            ->where('urcPropagacionConfirmaciones.Flag_Activo', '=', 0)
            ->groupBy([
                'urcPropagacionConfirmaciones.id',
                'GE.NombreGenero',
                'v.Nombre_Variedad',
                'v.Codigo',
                'gettR.PlotIDNuevo',
                'semanaConfirmacionModificada',
                'plantasconfirmadas',
                'sa.CantPlantas',
            ])
            ->get();

        return $confirmaciones;
    }

}
