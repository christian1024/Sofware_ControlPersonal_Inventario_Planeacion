<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TiposMedios extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "tipos_medios";
    protected $fillable = [
        'id',
        'Codigo',
        'NombreMedio',
        'IdArea'
    ];
}
