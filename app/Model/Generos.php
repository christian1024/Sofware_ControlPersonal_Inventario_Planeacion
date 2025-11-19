<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;

class Generos extends Model
{
    //const created_at = null;
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URC_Generos";
    protected $fillable = [
        'id',
        'NombreGenero',
        'CodigoIntegracionGenero',
        'Flag_Activo'
    ];
}
