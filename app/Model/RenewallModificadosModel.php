<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class RenewallModificadosModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCCodigosRenewallUpdate";
    protected $fillable = [
        'CodigoBarras',
        'PlotIdCargado',
        'ProcedenciaCargada'
    ];
}
