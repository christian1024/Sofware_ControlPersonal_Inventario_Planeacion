<?php

namespace App\Exports;

use App\Model\GetEtiquetasRenewalProduncionModel;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportConfirmacionesEntregadas implements FromCollection, WithHeadings
{
    use Exportable;

    /**
     * @inheritDoc
     */
    public function collection()
    {
        // TODO: Implement collection() method.
        $repor= GetEtiquetasRenewalProduncionModel::ConfirmacionesEntregadas();
        return $repor;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Nombre Genero',
            'Nombre Variedad',
            'Codigo',
            'PlotID Nuevo',
            'Semana Confirmacion',
            'Plantas Confirmadas',
            'Plantas Entregadas'
        ];
    }
}
