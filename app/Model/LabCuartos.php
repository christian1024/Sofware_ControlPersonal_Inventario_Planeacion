<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabCuartos extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "lab_cuartos";
    protected $fillable = [
        'id',
        'N_Cuarto',
        'Flag_Activo',
        'Descripcion'
    ];
}
