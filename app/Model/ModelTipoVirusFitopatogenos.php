<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelTipoVirusFitopatogenos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "FitoVirus";
    protected $fillable = [
        'NombreVirus',
        'Siglas',
        'Permitido',
        'Flag_Activo'
    ];
}
