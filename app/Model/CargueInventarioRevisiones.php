<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CargueInventarioRevisiones extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "cargue_inventario_revisiones";
    protected $fillable = [
        'id',
        'IntegrationCode',
        'Location',
        'WorkDelivery',
        'BoxID',
        'DayWeek',
        'BarCode',
        'BillToName',
        'FinalCustomerName',
        'Cuttings',
        'ClienteEspecial',
        'Bloque',
        'TipoEsqueje',
        'ID_User',
        'Flag_Activo',
    ];
}
