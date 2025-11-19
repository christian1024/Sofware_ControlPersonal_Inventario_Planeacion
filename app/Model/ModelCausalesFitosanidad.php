<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelCausalesFitosanidad extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCCausalesFitosanidad";
    protected $fillable = [
        'id',
        'Causal',
        'ColorBandera',
        'Flag_Activo'
    ];
}
