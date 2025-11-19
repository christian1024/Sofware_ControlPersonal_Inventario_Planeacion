<?php

namespace App\Imports;

use App\Model\ModelConfirmacionesCargueUrc;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportsConfirmacionesSiembrasURC implements ToModel, WithHeadingRow
{
    use Importable;

    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        $date = Carbon::now();
        $week1 = $date->week();
        $year1 = $date->format('Y');

        if (strlen($week1) === 1) {
            $week1 = '0' . $week1;
        }
        $weekActual1 = $year1 . '' . $week1;

        ModelConfirmacionesCargueUrc::query()->create([
            'PlotID' => $row['plotid'],
            'Codigo' => $row['codigo'],
            'Genero' => $row['genero'],
            'Variedad' => $row['variedad'],
            'Especie' => $row['especie'],
            'PlantasSembrar' => $row['plantas'],
            'CantidadCanastillas' => $row['canastillas'],
            'SemanaSiembra' => $row['semana_siembra'],
            'Procedencia' => $row['procedencia'],
            'DensidadSiembra' => $row['densidad'],
            'HoraLuz' => $row['hora_luz'],
            'BloqueSiembra' => $row['ubicacion'],
            'TipoBandeja' => $row['bandeja'],
            'SemanaCargue' => $weekActual1,
        ]);

        session()->flash('Guardado', 'Guardado');
    }
}
