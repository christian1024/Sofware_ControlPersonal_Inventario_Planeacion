<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelAnoSemana extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "AnoSemana";
    protected $fillable = [
        'id',
        'Fecha',
        'AnoYSemana'
    ];
}
