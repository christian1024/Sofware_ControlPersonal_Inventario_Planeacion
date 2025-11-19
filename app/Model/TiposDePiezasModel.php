<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TiposDePiezasModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "tipos_de_piezas";
    protected $fillable = [
        'Codigo',
        'NombrePieza',
        'Volumen',
        'Flag_Activo',
    ];
}
