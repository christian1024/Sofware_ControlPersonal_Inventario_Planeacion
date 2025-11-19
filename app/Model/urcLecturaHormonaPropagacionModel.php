<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class urcLecturaHormonaPropagacionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCLecturaHormonal";
    protected $fillable = [
        'idPatinador',
        'CodOperario',
        'CodigoBarras'
    ];
}
