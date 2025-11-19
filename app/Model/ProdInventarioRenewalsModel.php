<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProdInventarioRenewalsModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "prod_inventario_renewals";
    protected $fillable = [
        'id',
        'Semana',
        'Fecha',
        'PlotIDNuevo',
        'PlotIDOrigen',
        'SubPlotID',
        'CodigoIntegracion',
        'Cantidad',
        'CantidadBolsillos',
        'Bloque',
        'Nave',
        'Cama',
        'Procedencia',
        'SemanaCosecha',
        'ID_User',
        'Flag_Activo',
        'Legalizar',
    ];
}
