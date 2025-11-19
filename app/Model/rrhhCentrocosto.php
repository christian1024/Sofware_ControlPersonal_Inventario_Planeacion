<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class rrhhCentrocosto extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_CentroCostos";
    protected $fillable = [
        'id',
        'CentroCosto',
    ];
}
