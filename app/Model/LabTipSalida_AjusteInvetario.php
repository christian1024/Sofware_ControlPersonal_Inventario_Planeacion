<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabTipSalida_AjusteInvetario extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabTipSalida_AjusteInvetarios";
    protected $fillable = [
        'id',
        'TipoSalida_Ajuste',
    ];
}
