<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelCalculoSemanasPlaneacion extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "LabCalculoSemanasPlaneacion";
    protected $fillable = [
        'AnoYSemana',
        'Consecutivo'
    ];
}

