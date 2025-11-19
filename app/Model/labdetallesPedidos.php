<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class labdetallesPedidos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "labDetallesPedidosPlaneacion";
    protected $fillable = [
        'id_Variedad',
        'id_CabezaPedido',
        'TipoEntrega',
        'CantidadInicial',
        'SemanaEntrega',
        'TipoEntregaModificada',
        'CantidadInicialModificada',
        'SemanaEntregaModificada',
        'SemanaModificacion',
        'SemanaRealizoPlaneacion',
        'CantidadStock',
        'CantidadGermo',
        'FactorInformacionTecnica',
        'SemanasXFaseMultiplicacion',
        'SemanasXFaseEnra',
        'PorcentajePerdidaFaseEnra',
        'SemanasXFaseAdap',
        'PorcentajePerdidaFaseAdap',
        'FactorPlaneacion',
        'SemanaPlaneacion',
        'CantidadPlaneacion',
        'SemanaPlaneacionCicloantes',
        'CantidadPlaneacionCicloantes',
        'SemanaPlaneacionCicloFinal',
        'CantidadPlaneacionCicloFinal',
        'SemanaPlaneacionEnraizamiento',
        'CantidadPlaneacionEnraizamiento',
        'SemanaPlaneacionAdaptado',
        'CantidadPlaneacionAdaptado',
        'SemanaPlaneacionDespacho',
        'ObservacionCancelacion',
        'ObservacionnuevoItem',
        'Flag_Activo',
        'Flag_ActivoPlaneacion',
        'FechaCancelacion',
        'FechaModificacion',
        'FlagActivo_EstadoPreConfirmacion',
        'FlagActivo_CancelacionPreConfirmado',
        'FechaPreConfirmacionCliente',
        'CausalCancelacionEjecucion',
        'CancelacionEjecucion',
        'RadicadoCancelacion',
        'IdDetalleInicial',
        'Flag_ActivoReplanteado',
        'Programas',
    ];
}
