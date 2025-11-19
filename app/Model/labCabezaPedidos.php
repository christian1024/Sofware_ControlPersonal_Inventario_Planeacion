<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class labCabezaPedidos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "labCabezaPedidos";
    protected $fillable = [
        'id',
        'id_Cliente',
        'SemanaEntrega',
        'SemanaCreacion',
        'NumeroPedido',
        'id_UserCreacion',
        'EstadoDocumento',
        'Observaciones',
        'id_UserConfirmacion',
        'id_UserAceptado',
        'id_UserCancelado',
        'IdcabezaInicial',
        'FechaCancelado',
        'Flag_Activo',
        'TipoPrograma',
    ];

    public static function PedidosActivos()
    {
        $Pedidos = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->select(
                'cb.id',
                'cb.NumeroPedido',
                'cb.IdcabezaInicial',
                'cl.Nombre',
                'cb.SemanaEntrega',
                'cb.EstadoDocumento'
            )
            ->where('cb.Flag_Activo', '=', 1)
            ->get();
        return $Pedidos;
    }

    public static function DetallesPedidoSolicitado($id)
    {
        $id = decrypt($id);
        $Detalles = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->select(
                'cb.id',
                'cb.NumeroPedido',
                'cl.Nombre',
                'cb.SemanaEntrega',
                'cb.SemanaCreacion',
                'cb.EstadoDocumento',
                'cb.NumeroPedido',
                'cb.Observaciones'
            )
            ->where('cb.id', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            ->first();

        $DetallesD = DB::table('labDetallesPedidosPlaneacion as dt')
            ->join('urc_variedades as v', 'v.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'v.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->leftJoin('labcabezapedidos as cb', 'cb.id', '=', 'dt.id_CabezaPedido')
            ->select(
                'v.Nombre_Variedad',
                'v.Codigo',
                'URC_Generos.NombreGenero',
                'v.id as idVari',
                'dt.Flag_ActivoPlaneacion'
            )
            ->where('dt.id_CabezaPedido', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            ->where('dt.Flag_Activo', '=', 1)
            ->groupBy([
                'v.Nombre_Variedad',
                'v.Codigo',
                'URC_Generos.NombreGenero',
                'v.id',
                'dt.Flag_ActivoPlaneacion'
            ])
            ->get();
        //dd($DetallesD);
        $array = [
            'Detalles' => $Detalles,
            'DetallesD' => $DetallesD
        ];

        return (object)$array;
    }

    public static function DetallesCaracteristicas($Numpedido, $idVari)
    {
        $Detalles = labCabezaPedidos::query()
            ->select('det.id',
                'det.id_Variedad',
                'det.CantidadInicialModificada',
                'det.TipoEntregaModificada',
                'var.Nombre_Variedad',
                'det.Flag_Activo',
                'det.Flag_ActivoPlaneacion',
                'det.SemanaPlaneacionDespacho',
                'det.SemanaEntregaModificada')
            ->join('labDetallesPedidosPlaneacion as det', 'labCabezaPedidos.id', '=', 'det.id_CabezaPedido')
            ->join('URC_Variedades as var', 'var.id', '=', 'det.id_Variedad')
            ->where('labCabezaPedidos.id', $Numpedido)
            ->where('var.id', $idVari)
            ->get();
        return $Detalles;
    }

    public static function DetallesPLaneacion($request)
    {
        //dd($request->all());
        $Detalles = DB::table('labDetallesPedidosPlaneacion as dt')
            ->leftJoin('urc_variedades as v', 'v.id', '=', 'dt.id_Variedad')
            ->leftJoin('labcabezapedidos as cb', 'cb.id', '=', 'dt.id_CabezaPedido')
            ->select(
                'dt.*'
            )
            ->where('dt.id_CabezaPedido', '=', $request->get('NumPedido'))
            ->where('v.Codigo', '=', $request->get('IdVaridadH'))
            ->where('cb.Flag_Activo', '=', 1)
            ->where('dt.Flag_Activo', '=', 1)
            ->where('dt.Flag_ActivoPlaneacion', '=', null)
            ->get();
        $DetallesD = DB::table('labDetallesPedidosPlaneacion as dt')
            ->leftJoin('urc_variedades as v', 'v.id', '=', 'dt.id_Variedad')
            ->leftJoin('labcabezapedidos as cb', 'cb.id', '=', 'dt.id_CabezaPedido')
            ->select(
                'v.Nombre_Variedad',
                'v.Codigo',
                'dt.id_CabezaPedido',
                'cb.id as idCab'
            )
            ->where('v.Codigo', '=', $request->get('IdVaridadH'))
            ->where('dt.id_CabezaPedido', '=', $request->get('NumPedido'))
            ->where('cb.Flag_Activo', '=', 1)
            ->where('dt.Flag_Activo', '=', 1)
            ->groupBy([
                'v.Nombre_Variedad',
                'v.Codigo',
                'v.id',
                'dt.id_CabezaPedido',
                'cb.id'
            ])
            ->first();
        //dd($DetallesD);
        $array = [
            'DetallesD' => $DetallesD,
            'Detalles' => $Detalles,
        ];
        return (object)$array;
    }

    public static function CorreoPreconfirmado($id)
    {
        $consulta = DB::table('labCabezaPedidos as CP')
            ->select(
                'va.Nombre_Variedad',
                'gen.NombreGenero',
                'dp.CantidadInicial',
                'dp.SemanaEntrega',
                'dp.TipoEntrega')
            ->leftJoin('labDetallesPedidosPlaneacion as dp', 'dp.id_CabezaPedido', '=', 'CP.id')
            ->leftJoin('URC_Variedades as va', 'va.id', '=', 'dp.id_Variedad')
            ->leftJoin('URC_Especies as esp', 'esp.id', '=', 'va.ID_Especie')
            ->leftJoin('URC_Generos as gen', 'gen.id', '=', 'esp.Id_Genero')
            ->where('CP.NumeroPedido', $id)
            ->get();
        return $consulta;
    }

    public static function ProgramasPorVariedad($idVari)
    {
        $programasFormados = GetEtiquetasLabInventario::query()
            ->select([
                'Indentificador',
            ])
            ->join('LabLecturaEntradas as ent', 'ent.CodigoBarras', '=', 'BarCode')
            ->where('ID_Variedad', $idVari)
            ->where('ent.Flag_Activo', 1)
            ->whereIn('ID_FaseActual', [4, 5])
            ->groupBy(['Indentificador'])
            ->get();
        return $programasFormados;
    }

    public static function DetallesPedidoPreconfirmado($id)
    {
        $id = decrypt($id);
        $Detalles = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->select(
                'cb.id',
                'cb.NumeroPedido',
                'cl.Nombre',
                'cb.SemanaEntrega',
                'cb.SemanaCreacion',
                'cb.EstadoDocumento',
                'cb.NumeroPedido',
                'cb.Observaciones'
            )
            ->where('cb.id', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            ->first();

        $DetallesD = DB::table('labDetallesPedidosPlaneacion as dt')
            ->join('urc_variedades as v', 'v.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'v.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->leftJoin('labcabezapedidos as cb', 'cb.id', '=', 'dt.id_CabezaPedido')
            ->select(
                'v.Nombre_Variedad',
                'v.Codigo',
                'v.nombre_Variedad',
                'URC_Generos.NombreGenero',
                'v.id as idVari',
                'dt.*'
            )
            ->where('dt.id_CabezaPedido', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            //->where('dt.Flag_Activo', '=', 1)
            /*->where('dt.FlagActivo_EstadoPreConfirmacion', '=', 1)
            ->orWhereNull('dt.FlagActivo_EstadoPreConfirmacion')
            ->whereNull('dt.FlagActivo_CancelacionPreConfirmado')
            ->orwhere('dt.FlagActivo_CancelacionPreConfirmado',1)*/
            ->get();
        //dd($DetallesD);
        $array = [
            'Detalles' => $Detalles,
            'DetallesD' => $DetallesD
        ];

        return (object)$array;
    }

    public static function DetallesPedidoCAceptado($id)
    {
        $id = decrypt($id);
        $Detalles = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->select(
                'cb.id',
                'cb.NumeroPedido',
                'cl.Nombre',
                'cb.SemanaEntrega',
                'cb.SemanaCreacion',
                'cb.EstadoDocumento',
                'cb.NumeroPedido',
                'cb.Observaciones'
            )
            ->where('cb.id', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            ->first();

        $DetallesD = DB::table('labDetallesPedidosPlaneacion as dt')
            ->join('urc_variedades as v', 'v.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'v.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->leftJoin('labcabezapedidos as cb', 'cb.id', '=', 'dt.id_CabezaPedido')
            ->select(
                'v.Nombre_Variedad',
                'v.Codigo',
                'v.nombre_Variedad',
                'URC_Generos.NombreGenero',
                'v.id as idVari',
                'dt.*'
            )
            ->where('dt.id_CabezaPedido', '=', $id)
            ->where('cb.Flag_Activo', '=', 1)
            ->where('dt.Flag_Activo', '=', 1)
            ->get();
        //dd($DetallesD);
        $array = [
            'Detalles' => $Detalles,
            'DetallesD' => $DetallesD
        ];

        return (object)$array;
    }
}

