<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LecturaDescarteInvernaderoModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabLecturaDescarteInvernadero";
    protected $fillable = [
        'id',
        'idPatinador',
        'CodigoBarras',
        'CausalDescarte',
        'PlantasDescartadas',
        'SemanaLectura'
    ];
}

