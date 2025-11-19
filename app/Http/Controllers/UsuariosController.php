<?php

namespace App\Http\Controllers;

use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Http\Request;
use App\Model\Empleados;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }

    public function Usuarios()
    {

        $usuariostable = DB::table('users')
            ->join('RRHH_empleados', 'RRHH_empleados.id', '=', 'users.id_Empleado')
            ->select(
                'users.id_Empleado',
                'RRHH_empleados.Primer_Apellido',
                'RRHH_empleados.Segundo_Apellido',
                'RRHH_empleados.Primer_Nombre',
                'RRHH_empleados.Segundo_Nombre',
                'users.email',
                'users.id',
                'users.username')
            ->get();
        $Empleados = Empleados::All();
        return view('RolesyPermisos.Usuarios', compact('Empleados', 'usuariostable'));
    }

    public function CreateUsers(Request $request)
    {
        $request->validate([
            'id_Empleado' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required'
        ]);
        $nameusers = User::query()
            ->where('username', $request->get('username'))
            ->first();

        $email = User::query()
            ->where('email', $request->get('email'))
            ->first();

        if ($nameusers || $email) {
            session()->flash('error', 'error');
            return redirect(route('UsariossubMenu'));
        } else {

            $create = User::create([
                'id_Empleado' => $request['id_Empleado'],
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => Hash::make($request['password']),
            ]);
            session()->flash('ok', 'ok');
            return redirect(route('UsariossubMenu'));
        }
    }

    public function ViewPermisos($id)
    {

        $idusers = decrypt($id);
        $permisos = Permission::all();

        $datosUsuario = DB::table('users')
            ->join('RRHH_empleados', 'RRHH_empleados.id', '=', 'users.id_Empleado')
            ->select(
                'users.id_Empleado',
                'RRHH_empleados.Primer_Apellido',
                'RRHH_empleados.Segundo_Apellido',
                'RRHH_empleados.Primer_Nombre',
                'RRHH_empleados.Segundo_Nombre',
                'users.email',
                'users.id',
                'users.password',
                'users.username')
            ->where('users.id', $idusers)
            ->first();
        //dd($datosUsuario);
        return view('RolesyPermisos.permisos', compact('datosUsuario', 'permisos'));
    }

}

