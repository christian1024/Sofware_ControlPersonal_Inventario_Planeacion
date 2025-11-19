<?php

namespace App\Http\Controllers;

use App\Imports\cargueInventarioImport;
use App\Imports\ImportarProgramasImport;
use App\Model\ImportProgramasSemanales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class CargueInventarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewloadinventory()
    {
        $date = Carbon::now()->format('Y-d-m' . " 00:00:00");

        //dd($date);
        $hoy = DB::table('cargue_inventario')
            ->select(
                'CodigoVariedad',
                'Identificador',
                'Breeder',
                'FaseActual',
                'SemanaUltimoMovimiento',
                'SemanaIngreso',
                'Cantidad',
                'id_Cuarto',
                'id_Estante',
                'id_Nivel',
                'id_Frasco',
                'SemanaDespacho',
                'NumeroRadicado',
                'cliente',
                'created_at'
            )->where('created_at', '>=', $date)
            ->get();

        return view('Laboratorio.cargueInventario', compact('hoy'));
    }

    public function LoadInventory(Request $request)
    {
        (new cargueInventarioImport())->import($request->file('ImportInventory'));

        return redirect(route('viewloadinventory'));

    }

    public function vistaProgramas()
    {
       // dd(decrypt('$2y$10$sTgpxoiUgCVrApPL7zpaoeop7ZkfeLzgr.uMG7PZAVEucOcHMWbZa'));
        $lunespasado = new Carbon('previous monday');
        $Sabadopasado = new Carbon('last Saturday');
        $lunespasado = $lunespasado->format('Y-d-m');
        $Sabadopasado = $Sabadopasado->format('Y-d-m 22:00:00');
        $lunesactual = new Carbon('last monday');
        $lunespasado = $lunesactual->subDays(7)->format('Y-d-m 00:00:00');
        //dd($lunespasado, $Sabadopasado);

        $datosImport = ImportProgramasSemanales::all()->count();
        //dd($datosImport);
        $datas = DB::select("EXEC ProgramasSemanalesEjecutados ?,?", array($lunespasado,$Sabadopasado));

        //dd($datosImport);
        return view('Laboratorio.ProgramasSemanal', compact('datas','datosImport'));
    }

    public function CargarExceleProgramas(Request $request)
    {
        ImportProgramasSemanales::query()->truncate();
        (new ImportarProgramasImport())->import($request->file('ImportPrograms'));
        return redirect(route('vistaProgramasImports'));

    }

}
