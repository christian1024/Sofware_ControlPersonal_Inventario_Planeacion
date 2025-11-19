<?php

namespace App\Http\Controllers;

use App\Model\LabCuartos;
use App\Model\LabEstante;
use App\Model\LabNivel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministracionCuartosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function viewAdminCuartos()
    {
        $ultcuarto = LabCuartos::select('id', 'N_Cuarto')
            ->where('Flag_Activo', 1)
            ->orderby('created_at', 'DESC')->take(1)
            ->get();
        $cuartos = LabCuartos::all();
        return view('Laboratorio.RegistroLocalizaciones', compact('ultcuarto','cuartos'));
    }

    public function Cuartos(Request $request)
    {
        if ($request->ajax()) {
            $LabEstante = LabEstante::where('id_Cuarto', $request['idCuarto'])->get();
            return response()->json(['Data' => $LabEstante]);
        }
    }

    public function CreateCuarto(Request $request)
    {
        $request->validate(['Cuarto' => 'required',]);

        $existe = LabCuartos::select('N_Cuarto')
            ->where('N_Cuarto', $request->get('Cuarto'))
            ->first();

        if ($existe) {
            session()->flash('existe', 'existe');
            return back()->with('existe', '');
        } else {
            LabCuartos::create([
                'N_Cuarto' => $request->get('Cuarto'),
                'Flag_Activo' => 1,
            ]);
            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }
    }

    public function CreateEstanteCuarto(Request $request)
    {
        //$cadena = implode(",",$request->get('N_Estante'));
        //dd($cadena);

        $existeCuarto = LabEstante::select('id_Cuarto')
            ->where('id_Cuarto', '=', $request->get('id_Cuarto'))
            ->first();

        if ($existeCuarto) {
            session()->flash('existeC', 'existeC');
            return back()->with('existeC', '');
        } else {
            for ($i = 0; $i < count($request['N_Estante']); $i++) {

                $create = LabEstante::query()->create([
                    'id_Cuarto' => $request->get('id_Cuarto'),
                    'N_Estante' => $request['N_Estante'][$i],
                    'Flag_Activo' => '1',
                ]);
            }
            session()->flash('creado', 'creado');
            return back()->with('creado', '');

        }

    }

    public function createNivelEstante(Request $request)
    {
        //dd($request->all());

        $existenivel = DB::table('lab_nivels')
            ->select('id_Estante')
            ->where('id_Estante', $request->get('idEstante'))
            ->first();

       // dd($existenivel);
        if ($existenivel) {
            session()->flash('existeE', 'existeE');
            return back()->with('existeE', '');
        } else {
            for ($i = 0; $i < count($request['idNivel']); $i++) {
                LabNivel::query()->create([
                    'id_Estante' => $request->get('idEstante'),
                    'N_Nivel' => $request['idNivel'][$i],
                    'Flag_Activo' => 1,
                ]);
            }
            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }

    }
}
