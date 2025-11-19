<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class GetEtiquetasInventarioProduccionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "GetEtiquetasInventarioProduccion";
    protected $fillable = [
        'id',
        'id_ventas',
        'ship_to_number',
        'sales_order_number',
        'id_genero',
        'id_variedad',
        'delivery_quantity',
        'fechadespacho',
        'CodigoBarras',
        'VolumenVariedad',
        'cantidadbolsillos',
        'CantEsquejesBolsillo',
        'VolumenTotalVariedad',
        'VolumenAcumulado',
        'VolumenTotalCliente',
        'VolumenPorCaja',
        'NumeroCaja',
        'CodigoBarrasCaja',
        'TipoCaja',
        'PlotID',
        'SubPlotID',
        'Bloque',
        'Nave',
        'Cama',
        'Procedencia',
        'Impresa',
        'Flag_Activo',
    ];
}
