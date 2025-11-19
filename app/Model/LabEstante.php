<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabEstante extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lab_estantes";
    protected $fillable = [
        'id',
        'id_Cuarto',
        'N_Estante',
        'Flag_Activo'
    ];
}
