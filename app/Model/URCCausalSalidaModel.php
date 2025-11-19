<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class URCCausalSalidaModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_CausalesDescartesPropagacion";
    protected $fillable = [
        'id',
        'CausalDescarte',
        'Flag_Activo',
    ];
}
