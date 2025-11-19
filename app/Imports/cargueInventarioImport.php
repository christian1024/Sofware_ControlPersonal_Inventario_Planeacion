<?php

namespace App\Imports;

use App\Model\CargueInventario;
use DateTime;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class cargueInventarioImport implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \App\Model\CargueInventario
     */
    public function model(array $row)
    {

        $semanaingreso = Carbon::instance(Date::excelToDateTimeObject($row['semanaingreso']));
        $semanaingreso = $semanaingreso->format('Y-m-d');
        $semanaultimomovimiento = Carbon::instance(Date::excelToDateTimeObject($row['semanaultimomovimiento']));
        $semanaultimomovimiento = $semanaultimomovimiento->format('Y-m-d');
        if (empty($row['semanadespacho'])) {
            $semanadespacho=Null;
        }else
        {
            $semanadespacho = Carbon::instance(Date::excelToDateTimeObject($row['semanadespacho']));
            $semanadespacho = $semanadespacho->format('Y-m-d');
        }


        //dd($semanaingreso,$semanaultimomovimiento,$semanadespacho);

        return new CargueInventario([
            'CodigoVariedad' => $row['codigovariedad'],
            'Identificador' => $row['identificador'],
            'Breeder' => $row['breeder'],
            'FaseActual' => $row['faseactual'],
            'SemanaUltimoMovimiento' => $semanaultimomovimiento,
            'SemanaIngreso' => $semanaingreso,
            'Cantidad' => $row['cantidad'],
            'id_Cuarto' => $row['id_cuarto'],
            'id_Estante' => $row['id_estante'],
            'id_Nivel' => $row['id_nivel'],
            'id_Frasco' => $row['id_frasco'],
            'SemanaDespacho' => $semanadespacho,
            'NumeroRadicado' => $row['numeroradicado'],
            'cliente' => $row['cliente'],
        ]);
    }
}
