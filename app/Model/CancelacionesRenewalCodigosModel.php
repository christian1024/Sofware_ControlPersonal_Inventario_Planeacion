<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CancelacionesRenewalCodigosModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCCodigosCanceladosRenewal";
    protected $fillable = [
        'idUser',
        'idTipoCancelacion',
        'CodigoBarras',
    ];
}
