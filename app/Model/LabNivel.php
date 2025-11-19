<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabNivel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lab_nivels";
    protected $fillable = [
        'id',
        'id_Estante',
        'N_Nivel',
        'Flag_Activo'
    ];
}
