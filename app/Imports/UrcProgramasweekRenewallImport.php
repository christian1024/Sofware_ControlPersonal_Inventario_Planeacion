<?php

namespace App\Imports;

use App\Model\urcProgramasSemanalasRenewallModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UrcProgramasweekRenewallImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \App\Model\urcProgramasSemanalasRenewallModel
     */
    public function model(array $row)
    {
       // dd($row);
        //DB::table('URCProgramasSemanalesRenewall')->truncate();
        return new urcProgramasSemanalasRenewallModel([
            'PlotID'=>$row['plotid'],
            'CanTPlantas'=>$row['plantas']
        ]);
    }
}
