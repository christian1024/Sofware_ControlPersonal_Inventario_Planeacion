<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvernaderoTipoSalidaModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "InvernaderoTipoSalida";
    protected $fillable = [
        'id',
        'TipoSalida',
    ];
}
