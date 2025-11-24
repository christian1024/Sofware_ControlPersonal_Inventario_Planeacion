<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class urcProgramasSemanalasRenewallModel extends Model
{
    protected $dateFormat = 'Y-d-m H:i:s.v';
    protected $table = "URCProgramasSemanalesRenewall";
    protected $fillable = [
        'PlotID',
        'CanTPlantas'
    ];
}
