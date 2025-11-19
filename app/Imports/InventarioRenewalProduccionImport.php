<?php

namespace App\Imports;

use App\Model\ProdInventarioRenewalsModel;
use App\Model\Variedades;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithValidation;
use phpDocumentor\Reflection\Types\False_;
use Illuminate\Validation\Rule;

class InventarioRenewalProduccionImport implements ToModel, WithHeadingRow
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \App\Model\ProdInventarioRenewalsModel
     */


    public function model(array $row)
    {
        //dd($row['plotidnuevo']);

        //DB::table('prod_inventario_renewals')->truncate();
        set_time_limit(0);
        $date = new Carbon('next saturday');
        $date = $date->format('Y-m-d');

        $dateA = Carbon::now();
        $year = $dateA->format('Y');
        $Day = $dateA->week();

        if (strlen($Day) === 1) {
            $Day = '0' . $Day;
        }
        $fecha = $year.''.$Day;


        $plotExiste = ProdInventarioRenewalsModel::query()->where('PlotIDNuevo','=',$row['plotidnuevo'])->first();

//        dd($plotExiste);32392
        if ($plotExiste) {
            session()->flash('Existente', 'Existente');
        }else{
            return new ProdInventarioRenewalsModel([
                'Semana' => $fecha,
                'Fecha' => $date,
                'PlotIDNuevo' => $row['plotidnuevo'],
                'PlotIDOrigen' => $row['plotidorigen'],
                'CodigoIntegracion' => $row['codigointegracion'],
                'Cantidad' => $row['cantidad'],
                'Bloque' => $row['bloque'],
                'Nave' => $row['nave'],
                'Cama' => $row['cama'],
                'Procedencia' => $row['procedencia'],
                'SemanaCosecha' => $row['semanadespacho'],
                'ID_User' => auth()->user()->id_Empleado,
                'Flag_Activo' => 1,
                'Legalizar' => $row['legalizar'],
            ]);
        }
    }
}
