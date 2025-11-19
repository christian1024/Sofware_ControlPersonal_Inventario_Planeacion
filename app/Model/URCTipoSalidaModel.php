<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class URCTipoSalidaModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_TipoSalida";
    protected $fillable = [
        'id',
        'TipoSalida',
    ];
}
