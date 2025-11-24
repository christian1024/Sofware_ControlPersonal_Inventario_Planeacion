<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoCancelacionRenewalModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCTipoCancelacionRenewal";
    protected $fillable = [
        'id',
        'TipoCancelacion',
        'Flag_Activo'
    ];
}
