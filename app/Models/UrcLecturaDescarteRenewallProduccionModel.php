<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UrcLecturaDescarteRenewallProduccionModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCLecturaDescartePropagacion";
    protected $fillable = [
        'id',
        'idPatinador',
        'PlotId',
        'CausalDescarte',
        'PlantasDescartadas',
        'SemanaLectura'
    ];
}
