<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelLabTipoMedios extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabTipoMedios";
    protected $fillable = [
        'id',
        'TipoMedio',
        'Flag_Activo'
    ];
}
