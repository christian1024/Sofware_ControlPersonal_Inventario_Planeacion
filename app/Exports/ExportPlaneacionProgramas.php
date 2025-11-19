<?php

namespace App\Exports;

use App\Model\urcProgramasSemanalasRenewallModel;
use http\Client\Curl\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportPlaneacionProgramas implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function view(): View
    {
        $PedidosGeneral = DB::table('labcabezapedidos as cb')
            ->leftJoin('clientesYBreeder_labs as cl', 'cl.id', '=', 'cb.id_Cliente')
            ->leftJoin('labDetallesPedidosPlaneacion as dt', 'dt.id_CabezaPedido', '=', 'cb.id')
            ->leftJoin('CausalesCancelacionPlaneacion as cau', 'cau.id', '=', 'dt.CausalCancelacionEjecucion')
            ->join('urc_variedades as vari', 'vari.id', '=', 'dt.id_Variedad')
            ->join('URC_Especies', 'URC_Especies.id', '=', 'vari.ID_Especie')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'URC_Especies.Id_Genero')
            ->join('planeacionsemanalXpedidos', 'planeacionsemanalXpedidos.IdItemDetallePedido', '=', 'dt.id')
            ->join('tipo_fases_labs', 'tipo_fases_labs.id', '=', 'planeacionsemanalXpedidos.fase')
            ->select(
                'dt.id',
                'cb.NumeroPedido',
                'URC_Generos.NombreGenero',
                'vari.Codigo',
                'vari.Nombre_Variedad',
                'cl.Indicativo',
                'dt.TipoEntrega',
                'cb.TipoPrograma',
                'dt.SemanaPlaneacionDespacho',
                'dt.CantidadInicialModificada',
                'cb.SemanaCreacion',
                'dt.CantidadInicialModificada',
                'dt.Flag_Activo',
                'dt.ObservacionCancelacion',
                'cau.causalCancelacion',
                'dt.SemanaEntrega',
                'dt.CancelacionEjecucion',
                'dt.FactorPlaneacion',
                'dt.Programas',
                'planeacionsemanalXpedidos.*',
                'NombreFase'

            )
            ->where('planeacionsemanalXpedidos.Flag_Activo', 1)
            ->where('SemanaMovimiento', '>', 0)
            ->orderByRaw('NumeroPedido, dt.id, SemanaMovimiento')
            ->get();

        //dd($PedidosGeneral);

        return view('ViewExport.ViewExportPlaneacionPedidos',[
        'PedidosGeneral' => $PedidosGeneral
        ]);
    }

}
