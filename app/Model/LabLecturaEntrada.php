<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabLecturaEntrada extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaEntradas";
    protected $fillable = [
        'id',
        'id_Patinador',
        'id_Cuarto',
        'id_estante',
        'id_piso',
        'Plantas',
        'CodigoBarras',
        'SemanaLectura',
        'CodOperario',
        'created_at',
        'Flag_Activo'
    ];
}
