<?php

namespace App\Http\Controllers;

use App\Imports\ImportEtiquetasProduccion;
use App\Model\Especies;
use App\Model\Generos;
use App\Model\LabInfotecicaTiposFrascos;
use App\Model\LabInfotecnicaVariedades;
use App\Model\ModelInfotecnicaGeneroPruebas;
use App\Model\TipoFasesLab;
use App\Model\Variedades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ImportInformacionTecnicaVariedadesURC;


class PortafolioVariedadesContraller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function VistaPortafolioVariedades()
    {
        $Generos = Generos::query()->select('NombreGenero', 'id')->where('Flag_Activo', '=', 1)->orderby('NombreGenero', 'ASC')->get();
        $GenerosTables = Generos::query()->select(['id', 'NombreGenero', 'CodigoIntegracionGenero', 'Flag_Activo'])->orderBy('NombreGenero', 'ASC')->get();
        $EspeciesActivas = Especies::CargaTablaEspeciesActivas();
        $EspeciesTable = Especies::CargaTablaEspeciesTotal();
        $Variedades = Variedades::listTableVariety();

        return view('Portafolio.Variedades', compact('Generos', 'GenerosTables', 'EspeciesActivas', 'EspeciesTable', 'Variedades'));
    }

    public function createGenero(Request $request)
    {
        $Codigo = Generos::pluck('CodigoIntegracionGenero')->last();
        $Codigo = $Codigo + 1;

        $request->validate(['Nombre_Genero' => 'required',]);

        $existe = Generos::select('NombreGenero')->where('NombreGenero', $request['Nombre_Genero'])->first();
        if ($existe) {
            session()->flash('existe', 'existe');
            return redirect(route('VariedadessubMenu'));
        } else {
            $nombre = strtoupper($request['Nombre_Genero']);
            Generos::query()->create(['NombreGenero' => $nombre, 'CodigoIntegracionGenero' => $Codigo, 'Flag_Activo' => 1,]);
            session()->flash('creado', 'creado');
            return redirect(route('VariedadessubMenu'));
        }

    }

    public function InavilitarGenero($CodigoIntegracionGenero)
    {
        // dd($CodigoIntegracionGenero);
        Generos::query()->where('CodigoIntegracionGenero', decrypt($CodigoIntegracionGenero))->update(['Flag_Activo' => 0]);
        session()->flash('Inactivo', 'Inactivo');
        return redirect(route('VariedadessubMenu'));
    }

    public function HabilitarGenero($CodigoIntegracionGenero)
    {

        Generos::query()->where('CodigoIntegracionGenero', decrypt($CodigoIntegracionGenero))->update(['Flag_Activo' => 1]);
        session()->flash('Activo', 'Activo');
        return redirect(route('VariedadessubMenu'));
    }

    public function UpdateGenero(Request $request)
    {
        $request->validate(['Nombre_Genero_m' => 'required',]);

        $id = $request->get('IdGeneroUpdate');
        $NameGenero = strtoupper($request['Nombre_Genero_m']);
        $existe = Generos::select('id')->where('id', $id)->first();
        if ($existe) {
            Generos::query()->where('id', $id)->update(['NombreGenero' => $NameGenero]);
        }
        return redirect(route('VariedadessubMenu'));
    }

    /****************************Inica el Modulo de Especies**************************/

    public function InactivarEspecie($id)
    {
        Especies::query()->where('id', decrypt($id))->update(['Flag_Activo' => 0]);
        session()->flash('InactivarEspecie', 'InactivarEspecie');
        return redirect(route('VariedadessubMenu'));
    }

    public function ActivarEspecie($id)
    {
        Especies::query()->where('id', decrypt($id))->update(['Flag_Activo' => 1]);
        session()->flash('Activo', 'Activo');
        return redirect(route('VariedadessubMenu'));
    }

    public function CreatenewEspecie(Request $request)
    {
        // dd($request);
        $Codigo = Especies::pluck('CodigoIntegracionEspecie')->last();
        $Codigo = $Codigo + 1;

        $request->validate(['Nombre_Especie' => 'required', 'IdGenero' => 'required',]);
        Especies::query()->
        create([
            'NombreEspecie' => strtoupper($request['Nombre_Especie']),
            'Id_Genero' => $request['IdGenero'],
            'CodigoIntegracionEspecie' => $Codigo,
            'Flag_Activo' => 1,
        ]);
        session()->flash('creado', 'creado');
        return redirect(route('VariedadessubMenu'));
    }

    public function updateespecie(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'Nombre_EspecieMo' => 'required',
            'CodigoIntegracionEspecie' => 'required',
            'IdGenero' => 'required'
        ]);
        $existe = Especies::query()
            ->select('NombreEspecie')->where('NombreEspecie', '=', $request->get('Nombre_EspecieMo'))
            ->first();
        if ($existe) {
            //session()->flash('existe', 'existe');
            return back()->with('existe', '');
        } else {
            $updateEspecie = DB::table('URC_Especies')
                ->where('CodigoIntegracionEspecie', '=', $request->get('CodigoIntegracionEspecie'))
                ->update(['NombreEspecie' => strtoupper($request->get('Nombre_EspecieMo'))]);
            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }
        /*

        $existe = Variedades::query()
            ->select('Nombre_Variedad')->where('Nombre_Variedad', '=', $request->get('Nombre_VariedadMo'))
            ->first();

        if ($existe) {
            //session()->flash('existe', 'existe');
            return back()->with('existe', '');
        } else {
            $updateVariedad = DB::table('URC_Variedades')
                ->where('Codigo', '=', $request->get('CodigoMo'))
                ->update(['Nombre_Variedad' => $request->get('Nombre_VariedadMo')]);

            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }*/

    }

    /****************************Inica el Modulo de Variedades**************************/

    public function SelectGenero($id)
    {

        $Especies = Especies::where('Id_Genero', $id)->get();
        return response()->json(['Data' => $Especies]);


    }

    public function newvariedad(Request $request)
    {
        if ($request->ajax()) {
            //dd($request->all());
            $request->validate([
                'Nombre_Variedad' => 'required',
                'Codigo' => 'required',
                'IDEspecieOption' => 'required'
            ]);

            $existeCodigo = Variedades::query()->
            select('Codigo')
                ->where('Codigo', $request->get('Codigo'))
                ->first();


            $existe = DB::table('URC_Variedades')
                ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
                ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
                ->select([
                    'URC_Especies.id as idEspecie',
                    'URC_Generos.id as idGenero',
                    'URC_Variedades.Nombre_Variedad'
                ])
                ->where('URC_Generos.id', '=', $request->get('IdGeneros'))
                ->where('URC_Especies.id', '=', $request->get('IDEspecieOption'))
                ->where('URC_Variedades.Nombre_Variedad', '=', strtoupper($request->get('Nombre_Variedad')))
                ->first();


            if ($existeCodigo || $existe) {
                return response()->json([
                    'data' => 0,
                ]);
            } else {
                $newVariedad = Variedades::query()
                    ->create([
                        'Codigo' => $request['Codigo'],
                        'Nombre_Variedad' => strtoupper($request['Nombre_Variedad']),
                        'ID_Especie' => $request['IDEspecieOption'],
                        'Flag_Activo' => 1,
                    ]);
                $Creado = $newVariedad->id;
                $array = TipoFasesLab::all();
                $user = auth()->user()->id;
                foreach ($array as $arreglo) {
                    LabInfotecnicaVariedades::query()->
                    create([
                        'id_Variedad' => $Creado,
                        'CoeficienteMultiplicacion' => 0,
                        'PorcentajePerdida' => 0,
                        'id_fase' => $arreglo->id,
                        'PorcentajePerdidaFase' => 0,
                        'SemanasXFase' => $arreglo->CantSemanas,
                        'IdUser' => $user,
                        'Flag_Activo' => 1,
                    ]);
                }
                for ($i = 1; $i <= 8; $i++) {
                    LabInfotecicaTiposFrascos::query()->
                    create([
                        'id_Variedad' => $Creado,
                        'id_fase' => $i,
                        'id_tipofrasco' => 1,
                        'Cantidad' => 1,
                        'IdUser' => $user,
                        'Flag_Activo' => 1,
                    ]);
                }
                return response()->json([
                    'data' => 1,
                ]);
            }
        }
    }

    public function updatevariedad(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'Nombre_VariedadMo' => 'required',
            'CodigoMo' => 'required',
            'IdGenerosM' => 'required',
            'IDEspecie' => 'required'
        ]);

        $existe = DB::table('URC_Variedades')
            ->join('URC_Especies', 'URC_Variedades.ID_Especie', '=', 'URC_Especies.id')
            ->join('URC_Generos', 'URC_Especies.Id_Genero', '=', 'URC_Generos.id')
            ->select([
                'URC_Especies.id as idEspecie',
                'URC_Generos.id as idGenero',
                'URC_Variedades.Nombre_Variedad'
            ])
            ->where('URC_Generos.id', '=', $request->get('IdGenerosM'))
            ->where('URC_Especies.id', '=', $request->get('IDEspecie'))
            ->where('URC_Variedades.Nombre_Variedad', '=', strtoupper($request->get('Nombre_VariedadMo')))
            ->first();

        /*Variedades::query()
        ->select('Nombre_Variedad','')->where('Nombre_Variedad', '=', $request->get('Nombre_VariedadMo'))
        ->first();*/
        // dd($existe);

        if ($existe) {
            //session()->flash('existe', 'existe');
            return back()->with('existe', '');
        } else {
            $updateVariedad = Variedades::query()
                ->where('Codigo', '=', $request->get('CodigoMo'))
                ->update([
                    'Nombre_Variedad' => strtoupper($request->get('Nombre_VariedadMo')),
                    'ID_Especie' => $request->get('IDEspecie')
                ]);

            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }

    }

    public function InactivarVariedad($id)
    {
        //dd(base64_decode($id));
        Variedades::query()->where('id', decrypt($id))->update(['Flag_Activo' => 0]);
        return redirect(route('VariedadessubMenu'));
    }

    public function ActivarVariedad($id)
    {
        //dd(base64_decode($id));
        Variedades::query()->where('id', decrypt($id))->update(['Flag_Activo' => 1]);
        return redirect(route('VariedadessubMenu'));
    }

    public function InformacionTecnicaurc()
    {
        return view('Portafolio.InformacionTecnica');
    }

    public function CargueInformacionTecnicaurc(Request $request)
    {

        set_time_limit(0);
        (new ImportInformacionTecnicaVariedadesURC())->import($request->file('LoadInformacionTecnica'));
        session()->flash('Bien', 'Bien');
        return redirect(route('InformacionTecnicaurc'));
    }

    /***********************************FICHA TECNICA GENEROS PRUEBAS*******************************/

    public function viewFichaTecnicaGenerospruebas()
    {
        $fichatecnica = ModelInfotecnicaGeneroPruebas::query()
            ->select('LabInformacionTecnicaGenerosPruebas.id',
                'NombreGenero',
                'Index',
                'AgroRhodo',
                'Screen')
            ->join('URC_Generos', 'URC_Generos.id', '=', 'IdGenero')
            ->get();
        return view('Portafolio.FichaTecnicaGenerosPruebas', compact('fichatecnica'));
    }

    public function ModificarGeneroPruebas(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'idGenero' => 'required',
            'Index' => 'required',
            'AgroRhodo' => 'required',
            'Screen' => 'required'
        ]);

        ModelInfotecnicaGeneroPruebas::query()
            ->where('id', $request->get('idGenero'))
            ->update([
                'Index' => $request->get('Index'),
                'AgroRhodo' => $request->get('AgroRhodo'),
                'Screen' => $request->get('Screen'),
            ]);
        return redirect()->route('viewFichaTecnicaGenerospruebas')->with('Exitoso', '');

    }

}
