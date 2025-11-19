<?php

namespace App\Imports;

use App\Model\Variedades;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Model\CargueEtiquetasPro;

class ImportEtiquetasProduccion implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \App\Model\CargueEtiquetasPro
     */

    public function model(array $row)
    {
        $plotExiste = Variedades::query()->where('Codigo', '=', $row['codigovariedad'])->first();

//        dd($plotExiste);32392
        if (empty($plotExiste)) {
            session()->flash('Existente', 'Existente');
        } else {
            return new CargueEtiquetasPro([
                'CodigoVariedad' => $row['codigovariedad'],
                'CodigoBarras' => $row['codigobarras'],
                'CodigoCaja' => $row['codigocaja'],
                'CodigoBarrasCaja' => $row['codigobarrascaja'],
                'diadespacho' => $row['diadespacho']
            ]);
        }
    }
}
