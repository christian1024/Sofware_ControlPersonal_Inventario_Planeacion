<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LabCausalesDescarte extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "labCausalesDescartes";
    protected $fillable = [
        'id',
        'CausalDescarte',
        'Flag_Activo'
    ];
}
