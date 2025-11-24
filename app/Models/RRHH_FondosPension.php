<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RRHH_FondosPension extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "RRHH_FondosPension";
    protected $fillable = [
        'id',
        'NombreFondoP',
        'CodigoFondoP'
    ];
}
