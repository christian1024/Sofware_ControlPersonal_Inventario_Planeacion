<?php

namespace App\Http\Controllers;

use App\Model\tickestModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon;

class SoporteSistemasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewTickes()
    {
        $usuario = auth()->user()->id_Empleado;

        if ($usuario === '2089' || $usuario === '1' || $usuario === '1938') {

            $tickest = tickestModel::query()
                ->select([
                    'TickestSistemas.id',
                    'TickestSistemas.Descripcion',
                    'TickestSistemas.TipoSolicitud',
                    'TickestSistemas.Jusificacion',
                    'TickestSistemas.Flag_Activo',
                    DB::raw('CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as usuario'),
                    DB::raw('CONCAT(Us.Primer_Nombre,\' \',Us.Segundo_Nombre,\' \',Us.Primer_Apellido,\' \',Us.Segundo_Apellido,\' \') as usuarioit'),
                    DB::raw('CONVERT(SmallDateTime, TickestSistemas.created_at) as Fechacreacion'),
                    DB::raw('CONVERT(SmallDateTime, TickestSistemas.updated_at) as fechaatendido')
                ])
                ->join('RRHH_empleados as Em', 'Em.id', '=', 'TickestSistemas.idusuario')
                ->leftJoin('RRHH_empleados as Us', 'Us.id', '=', 'TickestSistemas.AtendidoPor')
                ->orderBy('TickestSistemas.id','desc')
                ->get();

            return view('Sistemas.Tickets', compact('tickest'));
        } else {
            $tickest = tickestModel::query()
                ->select([
                    'TickestSistemas.id',
                    'TickestSistemas.Descripcion',
                    'TickestSistemas.TipoSolicitud',
                    'TickestSistemas.Jusificacion',
                    'TickestSistemas.Flag_Activo',
                    DB::raw('CONCAT(Em.Primer_Nombre,\' \',Em.Segundo_Nombre,\' \',Em.Primer_Apellido,\' \',Em.Segundo_Apellido,\' \') as usuario'),
                    DB::raw('CONCAT(Us.Primer_Nombre,\' \',Us.Segundo_Nombre,\' \',Us.Primer_Apellido,\' \',Us.Segundo_Apellido,\' \') as usuarioit'),
                    DB::raw('CONVERT(SmallDateTime, TickestSistemas.created_at) as Fechacreacion'),
                    DB::raw('CONVERT(SmallDateTime, TickestSistemas.updated_at) as fechaatendido')
                ])
                ->join('RRHH_empleados as Em', 'Em.id', '=', 'TickestSistemas.idusuario')
                ->leftJoin('RRHH_empleados as Us', 'Us.id', '=', 'TickestSistemas.AtendidoPor')
                ->orderBy('TickestSistemas.id','desc')
                ->where('Em.id',$usuario)
                ->get();

            return view('Sistemas.Tickets', compact('tickest'));
        }
    }

    public function newTickets(Request $request)
    {
//        dd($request->all());
        $usuario = auth()->user()->id_Empleado;
        $request->validate([
            'Descripcion' => 'required',
            'TipoSolicitud' => 'required',
            'Jusificacion' => 'required',
        ]);

        $creado = tickestModel::query()
            ->create([
                'idusuario' => $usuario,
                'Descripcion' => $request->get('Descripcion'),
                'TipoSolicitud' => $request->get('TipoSolicitud'),
                'Jusificacion' => $request->get('Jusificacion'),
                'Flag_Activo' => 1
            ]);
        session()->flash('creado', 'creado');
        return redirect(route('ViewTickes'));
    }

    public function ticketsCumplido($id)
    {
        //dd(decrypt($id));
        $usuario = auth()->user()->id_Empleado;
        $update = tickestModel::query()
            ->where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 0,
                'AtendidoPor' => $usuario,
            ]);
        session()->flash('confirmado', 'confirmado');
        return redirect(route('ViewTickes'));

    }
}
