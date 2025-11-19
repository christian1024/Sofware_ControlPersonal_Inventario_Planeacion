<?php

namespace App\Http\Controllers;

use App\Model\LabInfotecicaTiposFrascos;
use App\Model\TipoFasesLab;
use App\Model\TipoFrascosLab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Especies;
use App\Model\Generos;
use App\Model\Variedades;
use App\Model\LabInfotecnicaVariedades;
use Carbon\Carbon;

class InfoTecnicaVariedadesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewInfoTecnica()
    {
        $VariedadesActivas = Variedades::listTableVariety();
        $tiposfrascos = TipoFrascosLab::all();


        return view('Laboratorio.InfoTecnicaVariedades', compact('VariedadesActivas', 'tiposfrascos'));
    }


    public function CargaTablaInfotecnica(Request $request)
    {

        $Infotecnica = Variedades::CargaDetallesTableInfoVari($request->get('valor'));
        return response()->json([
            'data' => $Infotecnica,
        ]);
    }

    public function CargaTablaInfotecnicaFrascos(Request $request)
    {

        $InfotecnicaFrascos = Variedades::CargueDetallesTableInfoTecFrascos($request->get('valor'));
        $Frascos = TipoFrascosLab::all();
        return response()->json([
            'data' => $InfotecnicaFrascos,
            'fras' => $Frascos
        ]);
    }

    public function GuardarInfotecnicaLaboratorio(Request $request)
    {

        for ($i = 0; $i < $request->get('total'); $i++) {

            $tabla = LabInfotecnicaVariedades::query()
                ->where('id_Variedad', $request->get('idVariedad'))
                ->where('id_fase', $request->get('Id_Fase-' . $i))
                ->update([
                    'id_Variedad' => $request->get('idVariedad'),
                    'CoeficienteMultiplicacion' => $request->get('CoeficienteMultiplicacion-' . $i),
                    'PorcentajePerdida' => $request->get('PorcentajePerdida-' . $i),
                    'PorcentajePerdidaFase' => $request->get('PorcentajePerdidaFase-' . $i),
                    'SemanasXFase' => $request->get('SemanasXFase-' . $i),
                    'IdUser' => Auth::id(),
                    'Flag_Activo' => 1
                ]);
        }
        session()->flash('creado', 'creado');
        return back()->with('creado', '');

    }

    public function GuardarInfoTecnicaFrascos(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'FaseMod' => 'required',
            'VarMod' => 'required',
            'idFrascos' => 'required',
        ]);

        $date = Carbon::now();
        $date = $date->format('Y-d-m H:i:s.v');

        $Cantidad =DB::table('tipo_Contenedores_labs')
            ->select('Cantidad')
            ->where('id', '=', $request->get('idFrascos'))
            ->first();


        $guardado = DB::table('lab_infotecica_tipos_frascos')
            ->where('id_Variedad', '=', $request->get('VarMod'))
            ->where('id_fase', '=', $request->get('FaseMod'))
            ->update(
                [
                    'id_tipofrasco' => $request->get('idFrascos'),
                    'Cantidad' => $Cantidad->Cantidad,
                    'updated_at'=>$date
                ]);
       /* session()->flash('creado', 'creado');
        return back()->with('creado', '');*/
        return response()->json([
            'data' => 1,
        ]);
    }
}
