<?php

namespace App\Http\Controllers;

use App\Model\Empleados;
use App\Model\GetEtiquetasLabInventario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $name = Empleados::query()->where('id', Auth::user()->id_Empleado)->first();
        $img = Empleados:: query()->where('id', Auth::user()->id_Empleado)->first();
        $ProgramasInv = GetEtiquetasLabInventario::ProgramasPendientesInvernadero();
        $Programas = GetEtiquetasLabInventario::ProgramasLaboratorio();
        $contarLab= count($Programas);
        $contarInv= count($ProgramasInv);
        //dd($img);

        session()->put('user', [
            'nameLogin'=>$name->Primer_Nombre . ' ' . $name->Primer_Apellido,
            'img'=>$img->img,
            'count'=>$contarLab,
            'countInv'=>$contarInv,
        ]);
       // session()->put('img', $img->img);
        //session()->put('count', $contarLab);

        return view('layouts.Principal');
         // return view('home');

    }

}
