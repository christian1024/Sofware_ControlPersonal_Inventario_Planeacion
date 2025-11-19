<?php

namespace App\Http\Controllers;

use App\Model\TiposDePiezasModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TiposDePiezaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function VistaTiposPiezaProduccion()
    {
        $tipospiezas = TiposDePiezasModel::all();

        return view('Produccion.TipoDePieza',compact('tipospiezas'));
    }

    public function NuevaPieza(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'TipoPieza' => 'required',
            'Volumen' => 'required'
        ]);

        $existePieza = TiposDePiezasModel::all()
            ->where('NombrePieza', ucfirst($request->get('TipoPieza')))
            ->first();


        if ($existePieza) {
            session()->flash('existe', 'existe');
        } else {
            // dd('guardado', ucfirst($request->get('TipoContenedor')));
            TiposDePiezasModel::query()
                ->create([
                    'NombrePieza' => ucfirst($request->get('TipoPieza')),
                    'Volumen' => $request->get('Volumen'),
                    'Flag_Activo' => 1
                ]);
            session()->flash('creado', 'creado');
        }
        return redirect('/TiposPiezaProduccion');
    }
}
