<?php

namespace App\Http\Controllers;

use App\Model\ClientesLab;
use App\Model\LabCausalesDescarte;
use App\Model\ModelLabTipoMedios;
use App\Model\TipoFrascosLab;
use Illuminate\Http\Request;

class TablasMaestrasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewTablasMaestras()
    {
        $clientes = ClientesLab::all();
        $TipoContenedores = TipoFrascosLab::all();
        $causalesDescartes = LabCausalesDescarte::all();
        $Medios = ModelLabTipoMedios::all();

        //dd($clientes);
        return view('Laboratorio.TablasMaestras', compact('clientes', 'TipoContenedores', 'causalesDescartes','Medios'));
    }

    public function newCliente(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'NombreCliente' => 'required',
            'Indicativo' => 'required',
            'Tipo' => 'required'
        ]);

        $existeIndicativo = ClientesLab::all()
            ->where('Indicativo', strtoupper($request->get('Indicativo')))
            ->first();

        $existeNombre = ClientesLab::all()
            ->where('Nombre', strtoupper($request->get('NombreCliente')))
            ->first();


        if ($existeIndicativo || $existeNombre) {
            session()->flash('existe', 'existe');
        } else {
            ClientesLab::query()
                ->create([
                    'Nombre' => strtoupper($request->get('NombreCliente')),
                    'Indicativo' => strtoupper($request->get('Indicativo')),
                    'Nit' => $request->get('Nit'),
                    'Tipo' => $request->get('Tipo'),
                    'Flag_Activo' => 1
                ]);
            session()->flash('creado', 'creado');
        }
        return redirect(route('TablasMaestras'));
    }

    public function updateCliente(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'NombreClienteMod' => 'required',
            'IndicativoMod' => 'required',
            'idCliente' => 'required'
        ]);

        $existeIndicativo = ClientesLab::query()
            ->select('Indicativo')
            ->where('id', '<>', $request->get('idCliente'))
            ->where('Indicativo', strtoupper($request->get('IndicativoMod')))
            ->first();

        $existeNombre = ClientesLab::query()
            ->select('Nombre')
            ->where('id', '<>', $request->get('idCliente'))
            ->where('Nombre', strtoupper($request->get('NombreClienteMod')))
            ->first();


        if ($existeIndicativo || $existeNombre) {
            // dd('aa');
            session()->flash('existe', 'existe');
        } else {
            ClientesLab::query()
                ->where('id', $request->get('idCliente'))
                ->update([
                    'Nombre' => strtoupper($request->get('NombreClienteMod')),
                    'Indicativo' => strtoupper($request->get('IndicativoMod')),
                    'Nit' => $request->get('NitMod'),
                    'Flag_Activo' => 1
                ]);
            session()->flash('Actualizado', 'Actualizado');
        }
        return redirect(route('TablasMaestras'));
    }

    public function inactivarCliente($id)
    {
        $id=decrypt($id);
        ClientesLab::query()
            ->where('id', $id)
            ->update([
                'Flag_Activo' => 0
            ]);
        return redirect(route('TablasMaestras'));
    }

    public function ActivarCliente($id)
    {
        $id=decrypt($id);
        ClientesLab::query()
            ->where('id', $id)
            ->update([
                'Flag_Activo' => 1
            ]);
        return redirect(route('TablasMaestras'));
    }

    public function newContenedor(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'TipoContenedor' => 'required',
            'CantidadCont' => 'required'
        ]);

        $existeContenedor = TipoFrascosLab::all()
            ->where('TipoContenedor', ucfirst($request->get('TipoContenedor')))
            ->first();


        if ($existeContenedor) {
            session()->flash('existe', 'existe');
        } else {
            // dd('guardado', ucfirst($request->get('TipoContenedor')));
            TipoFrascosLab::query()
                ->create([
                    'TipoContenedor' => ucfirst($request->get('TipoContenedor')),
                    'Cantidad' => $request->get('CantidadCont'),
                    'Flag_Activo' => 1
                ]);
            session()->flash('creado', 'creado');
        }
        return redirect(route('TablasMaestras'));
    }

    public function updateContenedor(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'TipoContenedorMod' => 'required',
            'CantidadContMod' => 'required',
            'idContenedor' => 'required'
        ]);

        $existeContenedor = TipoFrascosLab::query()
            ->select('TipoContenedor')
            ->where('id', '<>', $request->get('idContenedor'))
            ->where('TipoContenedor', ucfirst($request->get('TipoContenedorMod')))
            ->first();


        if ($existeContenedor) {
            session()->flash('existe', 'existe');
        } else {
            // dd('guardado', ucfirst($re
            TipoFrascosLab::query()
                ->where('id', $request->get('idContenedor'))
                ->update([
                    'TipoContenedor' => ucfirst($request->get('TipoContenedorMod')),
                    'Cantidad' => $request->get('CantidadContMod'),
                ]);
            session()->flash('Actualizado', 'Actualizado');
        }
        return redirect(route('TablasMaestras'));
    }

}
