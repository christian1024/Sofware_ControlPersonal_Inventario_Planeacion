<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class AreasMediosLab extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "AreasMediosLabs";
    protected $fillable = [
        'id',
        'NombreUso'
    ];
}
