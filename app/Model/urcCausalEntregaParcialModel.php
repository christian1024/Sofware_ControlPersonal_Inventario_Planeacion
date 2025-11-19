<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class urcCausalEntregaParcialModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCCausalEntregaParciales";
    protected $fillable = [
        'CausalEntregaParcial',
        'Flag_Activo'
    ];
}
