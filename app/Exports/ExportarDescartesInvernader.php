<?php

namespace App\Exports;

use App\Model\LecturaDescarteInvernaderoModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class ExportarDescartesInvernader implements FromQuery
{
    use Exportable;

    /**
     * @inheritDoc
     */

    public function __construct(string $FechaInicial, string $FechaFinal)
    {
        //dd($FechaInicial, $FechaFinal);
        $this->FechaInicial = $FechaInicial;
        $this->FechaFinal = $FechaFinal;
        return $this;
    }

    public function query()
    {
        return LecturaDescarteInvernaderoModel::query()
            ->select([
                'gn.NombreGenero',
                'vr.Codigo',
                'vr.Nombre_Variedad',
                'Indentificador',
                'cd.CausalDescarte',
                DB::raw('sum(LabLecturaDescarteInvernadero.PlantasDescartadas) as plantas')
            ])
            ->join('GetEtiquetasLabInventario as gt', 'gt.BarCode', '=', 'LabLecturaDescarteInvernadero.CodigoBarras')
            ->join('URC_Variedades as vr', 'vr.Codigo', '=', 'gt.CodigoVariedad')
            ->join('URC_Especies as sp', 'sp.id', '=', 'vr.ID_Especie')
            ->join('URC_Generos as gn', 'gn.id', '=', 'sp.Id_Genero')
            ->join('InverCausalesDescartes as cd', 'cd.id', '=', 'LabLecturaDescarteInvernadero.CausalDescarte')
            ->whereBetween('LabLecturaDescarteInvernadero.created_at', [$this->FechaInicial . ' 05:00.00', $this->FechaFinal . ' 23:55.00'])
            ->groupBy([
                'gn.NombreGenero',
                'vr.Codigo',
                'vr.Nombre_Variedad',
                'Indentificador',
                'cd.CausalDescarte'
            ])
            ->get();
    }
}

/*public function headings(): array
    {
        return [
            'NombreGenero',
            'Codigo',
            'Nombre Variedad',
            'Indentificador',
            'Causal Descarte',
            'plantas'

        ];
    }*/
