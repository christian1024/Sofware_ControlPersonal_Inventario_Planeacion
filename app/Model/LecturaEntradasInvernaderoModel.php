<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LecturaEntradasInvernaderoModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaEntradasInvernadero";
    protected $fillable = [
        'id',
        'id_Patinador',
        'id_Cama',
        'id_SeccionCama',
        'Plantas',
        'CodigoBarras',
        'CodOperario',
        'Flag_Activo',
        'SemanaLectura'
    ];
}
