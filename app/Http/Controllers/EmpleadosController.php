<?php

namespace App\Http\Controllers;

use App\Model\Area;
use App\Model\ARl;
use App\Model\Bloque;
use App\Model\Cargos;
use App\Model\Empleados;
use App\Model\estadoCivil;
use App\Model\FichaTecnicaEmpleados;
use App\Model\MedioTransporte;
use App\Model\RRHH_CajasCompensacion;
use App\Model\RRHH_FondosPension;
use App\Model\rrhhCentrocosto;
use App\Model\SubArea;
use App\Model\Tipo_contrato;
use App\Model\TipoDocumento;
use App\Model\Departamentos;
use App\Model\Ciudades;
use Carbon\Carbon;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use PDF;


class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ViewEmpelados()
    {
        $documento = TipoDocumento::all();
        $depart = Departamentos::all();
        $EmpleadosLab = Empleados::EmpleadosLabActivos();
        $SubAreas = SubArea::select('id', 'Sub_Area')->where('Id_Area', 2)->get();
        //dd($SubAreas);
        $empleados = Empleados::query()->
        select([
            'id',
            'Numero_Documento',
            'Codigo_Empleado',
            'Primer_Apellido',
            'Segundo_Apellido',
            'Primer_Nombre',
            'Segundo_Nombre',
            'Genero',
            'Direccion_Residencia',
            'Telefono',
            'Barrio',
            'Rh',
            'Flag_Activo',
            DB::raw('DATEDIFF(dd,FechaNaciemiento,GETDATE())/365 as Edad')
        ])
            //->where('id',1)
            ->get();

        $empleadosCarnet = Empleados::query()->
        select([
            'id',
            'Codigo_Empleado',
            DB::raw('concat(Primer_Apellido,\' \',Segundo_Apellido,\' \',Primer_Nombre,\' \',Segundo_Nombre) as nombre')
        ])
            ->where('Flag_Activo',1)
            ->get();
        //dd($empleados);


        return view('Empleados.Empleados', compact('documento', 'depart', 'EmpleadosLab', 'SubAreas', 'empleados','empleadosCarnet'));
    }

    public function CreateEmpleado(Request $request)
    {
        /*  phpinfo();*/
        $Codigo = Empleados::pluck('Codigo_Empleado')->last();
        $Codigo = $Codigo + 1;
        $request->validate([
            'Tipo_Doc' => 'required',
            'Numero_Documento' => 'required',
            'Ciudad_id_Expedcion' => 'required',
            'departamentos_id_Expe' => 'required',
            'Primer_Apellido' => 'required',
            'Primer_Nombre' => 'required',
            'Genero' => 'required',
            'Direccion_Residencia' => 'required',
            'Barrio' => 'required',
            'Ciudad_id_Residencia' => 'required',
            'departamentos_id_Residencia' => 'required',
            'Edad' => 'required',
            'Rh' => 'required',
            'Fecha_Nacimiento' => 'required'
        ]);

        $existe = Empleados::select('Numero_Documento')
            ->where('Numero_Documento', $request->get('Numero_Documento'))
            ->first();

        if ($existe) {
            session()->flash('existe', 'existe');
            return back()->with('existe', '');
        } else {
            //dd($request->all());
            if (empty($request->file('img'))) {
                $name = NULL;
            } else {
                $file = $request->file('img');
                $name = $request->get('Numero_Documento') . $file->getClientOriginalName();
                $file->move(public_path() . '/imagenes/', $name);
            }

            $Empleado = Empleados::query()
                ->create([
                    'Tipo_Doc' => $request->get('Tipo_Doc'),
                    'Numero_Documento' => $request->get('Numero_Documento'),
                    'Codigo_Empleado' => $Codigo,
                    'Primer_Apellido' => strtoupper($request->get('Primer_Apellido')),
                    'Segundo_Apellido' => strtoupper($request->get('Segundo_Apellido')),
                    'Primer_Nombre' => strtoupper($request->get('Primer_Nombre')),
                    'Segundo_Nombre' => strtoupper($request->get('Segundo_Nombre')),
                    'Genero' => $request->get('Genero'),
                    'Direccion_Residencia' => $request->get('Direccion_Residencia'),
                    'Telefono' => $request->get('Telefono'),
                    'Barrio' => $request->get('Barrio'),
                    'Rh' => $request->get('Rh'),
                    'Edad' => $request->get('Edad'),
                    'Flag_Activo' => 1,
                    'departamentos_id_Expe' => $request->get('departamentos_id_Expe'),
                    'Ciudad_id_Expedcion' => $request->get('Ciudad_id_Expedcion'),
                    'departamentos_id_Residencia' => $request->get('departamentos_id_Residencia'),
                    'Ciudad_id_Residencia' => $request->get('Ciudad_id_Residencia'),
                    'img' => $name,
                    'FechaNaciemiento' => $request->get('Fecha_Nacimiento')
                ]);

            FichaTecnicaEmpleados::query()
                ->create([
                    'id_Empleado' => $Empleado->id,
                    'Frecuencia' => 1
                ]);

            session()->flash('creado', 'creado');
            return back()->with('creado', '');
        }
    }

    public function ExisteEmpleado(Request $request)
    {
        $existe = Empleados::select('Numero_Documento')
            ->where('Numero_Documento', $request->get('dato'))
            ->first();
        if ($existe) {
            return response()->json([
                'ok' => 1
            ]);
        }
    }

    public function Departamentos(Request $request)
    {
        if ($request->ajax()) {
            $ciudades = Ciudades::where('id_departamento', $request['Departamento'])->get();
            return response()->json(['Data' => $ciudades]);
        }

    }

    public function EliminarEmpleado($id)
    {

        Empleados::where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 0
            ]);

        session()->flash('ok', 'Inactivo');
        return redirect(route('EmpleadossubMenu'));
    }

    public function ActivarEmpleado($id)
    {

        $consulta = FichaTecnicaEmpleados::select('id_Empleado')
            ->where('id_Empleado', decrypt($id))
            ->first();

        Empleados::where('id', decrypt($id))
            ->update([
                'Flag_Activo' => 1,
            ]);
        if ($consulta) {
            FichaTecnicaEmpleados::where('id_Empleado', decrypt($id))
                ->increment('Frecuencia', 1);
        } else {
            FichaTecnicaEmpleados::create([
                'id_Empleado' => decrypt($id),
                'Frecuencia' => 1
            ]);
        }
        session()->flash('error', 'activado');
        return redirect(route('EmpleadossubMenu'));

    }

    public function Updateimg(Request $request)
    {
        /* dd($request->all());*/
        $file = $request->file('imgup');
        $name = $request->get('Numero_Documento') . $file->getClientOriginalName();
        $file->move(public_path() . '/imagenes/', $name);
        DB::table('RRHH_empleados')
            ->where('Numero_Documento', $request->get('Numero_Documento'))
            ->update(['img' => $name]);

        session()->flash('imgupdate', 'imgupdate');
        return back()->with('imgupdate', '');

    }

    public function EmpleadosLaboratorio(Request $request)
    {
        $request->validate([
            'id_Sub_Area' => 'required',
            'id_Bloque_Area' => 'required',
            'idEmpleado' => 'required',
        ]);

        $existe = FichaTecnicaEmpleados::select('id_Empleado')
            ->where('id_Empleado', $request->get('idEmpleado'))
            ->first();
        if ($existe) {
            DB::table('RRHH_datos_empleados')
                ->where('id_Empleado', $request->get('idEmpleado'))
                ->update(
                    [
                        'id_Sub_Area' => $request->get('id_Sub_Area'),
                        'id_Bloque_Area' => $request->get('id_Bloque_Area')
                    ]);
        } /*else {
            DB::table('RRHH_datos_empleados')
                ->insert(
                    [
                        'id_Empleado', $request->get('idEmpleado'),
                        'id_area' => $request->get('id_area'),
                        'id_Sub_Area' => $request->get('id_Sub_Area'),
                        'id_Bloque_Area' => $request->get('id_Bloque_Area')
                    ]);
        }*/
        session()->flash('update', 'update');
        return redirect(route('EmpleadossubMenu'));

    }

    public function ExisteOperario(Request $request)
    {

        $existe = Empleados::select('Codigo_Empleado')
            ->where('Codigo_Empleado', $request->get('dato'))
            ->first();
        if (empty($existe)) {
            return response()->json([
                'ok' => 1
            ]);
        }
    }

    public function ExisteOperarioLab(Request $request)
    {

        $existe = Empleados::query()
            ->select('Codigo_Empleado')
            ->join('RRHH_datos_empleados as dt', 'dt.id_Empleado', '=', 'RRHH_empleados.id')
            ->where('Codigo_Empleado', $request->get('dato'))
            ->where('id_area', 2)
            ->where('Flag_Activo', 1)
            ->first();
        //dd($existe);
        if (empty($existe)) {
            return response()->json([
                'ok' => 1
            ]);
        }
    }

    public function ImprimirCarnet($id)
    {
        //$empleado = Empleados::where('id', base64_decode($id))->first();
        $Datos = DB::table('RRHH_empleados as em')
            ->select([
                'em.Primer_Nombre',
                'em.Primer_Apellido',
                'em.Codigo_Empleado',
                'em.img',
                'Car.Cargo',
                'dtem.id_tipocontratos',
                DB::raw('UPPER(ara.Area) as Area')
            ])
            ->join('RRHH_datos_empleados as dtem', 'em.id', '=', 'dtem.id_Empleado')
            ->join('RRHH_areas as ara', 'dtem.id_area', '=', 'ara.id', 'left outer')
            ->join('RRHH_cargos as Car', 'dtem.id_Cargo', '=', 'Car.id', 'left outer')
            ->where('em.id', decrypt($id))
            ->first();

        //dd($Datos);

        if ($Datos->id_tipocontratos != '3') {
            $view = PDF::loadView('CarnetDarwin', compact('Datos'));
            $view->setPaper([0, 0, 220, 320], 'portrait');
            return $view->stream('CarnetDarwin.pdf');
        } else {
            $view = PDF::loadView('CarnetDarwinTemporal');
            $view->setPaper([0, 0, 220, 320], 'portrait');
            return $view->stream('CarnetDarwinTemporal.pdf');
        }


    }

    public function ModificarEmpleados($id)
    {

        $dato = decrypt($id);

        $documento = TipoDocumento::all();
        $depart = Departamentos::all();
        $ciudad = Ciudades::all();
        $transporte = MedioTransporte::all();
        $Cargo = Cargos::all();
        $TipContrato = Tipo_contrato::all();
        $Area = Area::all();
        $SubArea = SubArea::all();
        $Bloque = Bloque::all();
        $arl = ARl::all();
        $EstadoCivil = estadoCivil::all();
        $Pension = RRHH_FondosPension::all();
        $Compensas = RRHH_CajasCompensacion::all();
        $datosEmpleados = FichaTecnicaEmpleados::FichaTecnicaEmpleados($dato);
        $diferencia = '';
        //dd($datosEmpleados);

        $costosSers = rrhhCentrocosto::all();
        $empleado = Empleados::where('id', $dato)->first();

        $consultafecha = DB::table('RRHH_datos_empleados')->select('Ultima_Fecha_Ingreso', 'Fecha_Ingreso')->where('id_Empleado', $dato)->first();
        $date = Carbon::now();

        if (is_null($consultafecha)) {
            $diferencia = '0';
        } elseif ($consultafecha->Ultima_Fecha_Ingreso < $consultafecha->Fecha_Ingreso) {
            $fechaConsulta = Carbon::parse($consultafecha->Fecha_Ingreso);
            $diferencia = $fechaConsulta->diffInMonths($date);
        } elseif ($consultafecha->Ultima_Fecha_Ingreso > $consultafecha->Fecha_Ingreso) {
            $fechaConsulta = Carbon::parse($consultafecha->Ultima_Fecha_Ingreso);
            $diferencia = $fechaConsulta->diffInMonths($date);
        }
        return view('Empleados.ModificarEmpleados', compact('empleado', 'documento', 'depart', 'ciudad', 'Cargo', 'TipContrato', 'Area', 'SubArea', 'Bloque', 'datosEmpleados', 'transporte', 'arl', 'EstadoCivil', 'diferencia', 'Pension', 'Compensas', 'costosSers'));

    }

    public function CrearFichaTecnica(Request $request)
    {
        if ($request->ajax()) {
            $consulta = FichaTecnicaEmpleados::select('id_Empleado')
                ->where('id_Empleado', $request->get('id_Empleado'))
                ->first();
            $actualizarcab = Empleados::query()
                ->where('id', $request->get('id_Empleado'))
                ->update([
                    'Tipo_Doc' => $request->get('Tipo_Doc'),
                    'Numero_Documento' => $request->get('Numero_Documento'),
                    'Primer_Apellido' => strtoupper($request->get('Primer_Apellido')),
                    'Segundo_Apellido' => strtoupper($request->get('Segundo_Apellido')),
                    'Primer_Nombre' => strtoupper($request->get('Primer_Nombre')),
                    'Segundo_Nombre' => strtoupper($request->get('Segundo_Nombre')),
                    'Genero' => $request->get('Genero'),
                    'Direccion_Residencia' => $request->get('Direccion_Residencia'),
                    'Telefono' => $request->get('Telefono'),
                    'Barrio' => $request->get('Barrio'),
                    'Rh' => $request->get('Rh'),
                    'Edad' => $request->get('Edad'),
                    'departamentos_id_Expe' => $request->get('departamentos_id_Expe'),
                    'Ciudad_id_Expedcion' => $request->get('Ciudad_id_Expedcion'),
                    'departamentos_id_Residencia' => $request->get('departamentos_id_Residencia'),
                    'Ciudad_id_Residencia' => $request->get('Ciudad_id_Residencia'),
                    'FechaNaciemiento' => $request->get('Fecha_Nacimiento'),
                ]);
            $actualizardet = FichaTecnicaEmpleados::query()
                ->where('id_Empleado', $request->get('id_Empleado'))
                ->update([
                    'Fecha_Ingreso' => $request->get('Fecha_Ingreso'),
                    'Salario' => $request->get('Salario'),
                    'Fecha_retiro' => $request->get('Fecha_retiro'),
                    'Ultima_Fecha_Ingreso' => $request->get('Ultima_Fecha_Ingreso'),
                    'Fecha_Cambio_Contrato' => $request->get('Fecha_Cambio_Contrato'),
                    'Tipo_Vivienda' => $request->get('Tipo_Vivienda'),
                    'id_Pension' => $request->get('Pension'),
                    'Cesantias' => $request->get('Cesantias'),
                    'id_CajaCompensacion' => $request->get('Caja_Compensacion'),
                    'Auxilio_Transporte' => $request->get('Auxilio_Transporte'),
                    'Numero_Cuenta' => $request->get('Numero_Cuenta'),
                    'Formacion' => $request->get('Formacion'),
                    'Numero_Hijos' => $request->get('Numero_Hijos'),
                    'Talla_Chaqueta' => $request->get('Talla_Chaqueta'),
                    'Talla_Pantalon' => $request->get('Talla_Pantalon'),
                    'Talla_overol' => $request->get('Talla_overol'),
                    'Numero_Calzado' => $request->get('Numero_Calzado'),
                    'personas_cargo' => $request->get('personas_cargo'),
                    'peso' => $request->get('peso'),
                    'estatura' => $request->get('estatura'),
                    'enfermedad_laboral' => $request->get('enfermedad_laboral'),
                    'Carnet' => $request->get('Tarjeta'),
                    'Numero_Botas_Caucho' => $request->get('Numero_Botas_Caucho'),
                    'Raza' => $request->get('Raza'),
                    'Estrato_Social' => $request->get('Estrato_Social'),
                    'Enfermedad_Comun' => $request->get('Enfermedad_Comun'),
                    'At_Level' => $request->get('At_Level'),
                    'At_Grave' => $request->get('At_Grave'),
                    'Intervencion_Xat' => $request->get('Intervencion_Xat'),
                    'Comida_Dia' => $request->get('Comida_Dia'),
                    'Vegetales' => $request->get('Vegetales'),
                    'Carbohidratos' => $request->get('Carbohidratos'),
                    'Hidratacion' => $request->get('Hidratacion'),
                    'cumple_horario_comidas' => $request->get('cumple_horario_comidas'),
                    'Deporte' => $request->get('Deporte'),
                    'Hobbies' => $request->get('Hobbies'),
                    'sustancias_psicoactivas' => $request->get('sustancias_psicoactivas'),
                    'fuma' => $request->get('fuma'),
                    'consume_alcohol' => $request->get('consume_alcohol'),
                    'restriccion' => $request->get('restriccion'),
                    'motivo_retiro' => $request->get('motivo_retiro'),
                    'lavado_manos' => $request->get('lavado_manos'),
                    'Nivel_Sisben' => $request->get('Nivel_Sisben'),
                    'Rodamiento' => $request->get('Rodamiento'),
                    'id_arl' => $request->get('id_arl'),
                    'id_Estado_Civil' => $request->get(''),
                    'id_Medio_Transporte' => $request->get(''),
                    'id_Cargo' => $request->get('id_Cargo'),
                    'id_tipocontratos' => $request->get('id_tipocontratos'),
                    'id_area' => $request->get('id_area'),
                    'id_Sub_Area' => $request->get('id_Sub_Area'),
                    'id_Bloque_Area' => $request->get('id_Bloque_Area'),
                    'id_CentroCosto' => $request->get('id_CentroCosto')
                ]);

            return response()->json([
                'data' => 1,
            ]);
        }
    }

    public function Area(Request $request)
    {

        $subArea = subarea::where('Id_Area', $request['Area'])->get();
        return response()->json(['Data' => $subArea]);
    }

    public function Bloque(Request $request)
    {

        $Bloque = Bloque::where('Id_Sub_Area', $request['sub_area'])->get();
        return response()->json(['Dato' => $Bloque]);
    }

    public function ImprimirMultiplesCarnets(Request $request)
    {

       //dd();//'A4', 'portrait'

        //$array = explode(',', $request['idusuarios']);


        $DatosCar = DB::table('RRHH_empleados as em')
            ->select([
                'em.Primer_Nombre',
                'em.Primer_Apellido',
                'em.Codigo_Empleado',
                'em.img',
                'Car.Cargo',
                'dtem.id_tipocontratos',
                DB::raw('UPPER(ara.Area) as Area')
            ])
            ->join('RRHH_datos_empleados as dtem', 'em.id', '=', 'dtem.id_Empleado')
            ->join('RRHH_areas as ara', 'dtem.id_area', '=', 'ara.id', 'left outer')
            ->join('RRHH_cargos as Car', 'dtem.id_Cargo', '=', 'Car.id', 'left outer')
            ->wherein('em.id',$request['idusuarios'])
            ->get();

        //dd($DatosCar);

        $view = PDF::loadView('CarnetMultiplesEmpresa', compact('DatosCar'));
        $view->setPaper('A4', 'portrait');
        return $view->stream('CarnetDarwin.pdf');
    }

}

