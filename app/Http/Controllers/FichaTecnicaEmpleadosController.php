<?php

namespace App\Http\Controllers;

use App\Model\FichaTecnicaEmpleados;
use App\Model\RRHH_CajasCompensacion;
use App\Model\RRHH_FondosPension;
use App\Model\rrhhCentrocosto;
use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Model\Empleados;
use App\Model\TipoDocumento;
use App\Model\Departamentos;
use App\Model\Ciudades;
use App\Model\estadoCivil;
use App\Model\ARl;
use App\Model\MedioTransporte;
use App\Model\Tipo_contrato;
use App\Model\Cargos;
use App\Model\Area;
use App\Model\Bloque;
use App\Model\SubArea;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class FichaTecnicaEmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ModificarEmpleados($id)
    {

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
        $Pension=RRHH_FondosPension::all();
        $Compensas=RRHH_CajasCompensacion::all();
        $datosEmpleados = FichaTecnicaEmpleados::FichaTecnicaEmpleados($id);
        $diferencia = '';
        //dd($datosEmpleados);

        $costosSers=rrhhCentrocosto::all();
        $empleado = Empleados::where('id', base64_decode($id))->first();

        $consultafecha = DB::table('RRHH_datos_empleados')->select('Ultima_Fecha_Ingreso', 'Fecha_Ingreso')->where('id_Empleado', base64_decode($id))->first();
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
        return view('Empleados.ModificarEmpleados', compact('empleado', 'documento', 'depart', 'ciudad', 'Cargo', 'TipContrato', 'Area', 'SubArea', 'Bloque', 'datosEmpleados', 'transporte', 'arl', 'EstadoCivil', 'diferencia','Pension','Compensas','costosSers'));

    }


    public function CrearFichaTecnica(Request $request)
    {


        if ($request->ajax()) {


            $consulta = FichaTecnicaEmpleados::select('id_Empleado')
                ->where('id_Empleado',$request->get('id_Empleado'))
                ->first();
            // dd($consulta);
            if ($consulta) {
                $create = DB::statement('EXEC ActualizarDatosEmpleados ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', array(

                    $request->get('id_Empleado'), $request->get('Tipo_Doc'),
                    $request->get('Numero_Documento'),
                    $request->get('Primer_Apellido'), $request->get('Segundo_Apellido'),
                    $request->get('Primer_Nombre'), $request->get('Segundo_Nombre'),
                    $request->get('Genero'), $request->get('Direccion_Residencia'),
                    $request->get('Telefono'), $request->get('Barrio'),
                    $request->get('Rh'), $request->get('Edad'),
                    $request->get('departamentos_id_Expe'), $request->get('Ciudad_id_Expedcion'),
                    $request->get('departamentos_id_Residencia'), $request->get('Ciudad_id_Residencia'),
                    $request->get('Fecha_Nacimiento'),

                    $request->get('Fecha_Ingreso'),
                    $request->get('Salario'), $request->get('Fecha_retiro'),
                /*    $request->get('Frecuencia'),*/ $request->get('Ultima_Fecha_Ingreso'),
                    $request->get('Fecha_Cambio_Contrato'), $request->get('Tipo_Vivienda'),
                    $request->get('Pension'),
                    $request->get('Cesantias'), $request->get('Caja_Compensacion'),
                    $request->get('Auxilio_Transporte'),
                    $request->get('Numero_Cuenta'), $request->get('Formacion'),
                    $request->get('Numero_Hijos'), $request->get('Talla_Chaqueta'),
                    $request->get('Talla_Pantalon'), $request->get('Talla_overol'),
                    $request->get('Numero_Calzado'), $request->get('personas_cargo'),
                    $request->get('peso'), $request->get('estatura'),
                    $request->get('enfermedad_laboral'), $request->get('Tarjeta'),
                    $request->get('Numero_Botas_Caucho'), $request->get('Raza'),
                    $request->get('Estrato_Social'), $request->get('Enfermedad_Comun'),
                    $request->get('At_Level'), $request->get('At_Grave'),
                    $request->get('Intervencion_Xat'), $request->get('Comida_Dia'),
                    $request->get('Vegetales'), $request->get('Carbohidratos'),
                    $request->get('Hidratacion'), $request->get('cumple_horario_comidas'),
                    $request->get('Deporte'), $request->get('Hobbies'),
                    $request->get('sustancias_psicoactivas'), $request->get('fuma'),
                    $request->get('consume_alcohol'), $request->get('restriccion'),
                    $request->get('motivo_retiro'), $request->get('lavado_manos'),
                    $request->get('Nivel_Sisben'), $request->get('Rodamiento'),
                    $request->get('id_arl'), $request->get('id_Estado_Civil'),
                    $request->get('id_Medio_Transporte'), $request->get('id_Cargo'),
                    $request->get('id_tipocontratos'), $request->get('id_area'),
                    $request->get('id_Sub_Area'), $request->get('id_Bloque_Area'),
                    $request->get('id_CentroCosto')

                ));
            } else {

                $create = DB::statement('EXEC CrearFichaTecnicaEmpleado ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?', array(

                    $request->get('id_Empleado'), $request->get('Fecha_Ingreso'),
                    $request->get('Salario'), $request->get('Fecha_retiro'),
                   /* $request->get('Frecuencia'),*/ $request->get('Ultima_Fecha_Ingreso'),
                    $request->get('Fecha_Cambio_Contrato'), $request->get('Tipo_Vivienda'),
                    $request->get('Pension'),
                    $request->get('Cesantias'), $request->get('Caja_Compensacion'),
                    $request->get('Auxilio_Transporte'),
                    $request->get('Numero_Cuenta'), $request->get('Formacion'),
                    $request->get('Numero_Hijos'), $request->get('Talla_Chaqueta'),
                    $request->get('Talla_Pantalon'), $request->get('Talla_overol'),
                    $request->get('Numero_Calzado'), $request->get('personas_cargo'),
                    $request->get('peso'), $request->get('estatura'),
                    $request->get('enfermedad_laboral'), $request->get('Tarjeta'),
                    $request->get('Numero_Botas_Caucho'), $request->get('Raza'),
                    $request->get('Estrato_Social'), $request->get('Enfermedad_Comun'),
                    $request->get('At_Level'), $request->get('At_Grave'),
                    $request->get('Intervencion_Xat'), $request->get('Comida_Dia'),
                    $request->get('Vegetales'), $request->get('Carbohidratos'),
                    $request->get('Hidratacion'), $request->get('cumple_horario_comidas'),
                    $request->get('Deporte'), $request->get('Hobbies'),
                    $request->get('sustancias_psicoactivas'), $request->get('fuma'),
                    $request->get('consume_alcohol'), $request->get('restriccion'),
                    $request->get('motivo_retiro'), $request->get('lavado_manos'),
                    $request->get('Nivel_Sisben'), $request->get('Rodamiento'),
                    $request->get('id_arl'), $request->get('id_Estado_Civil'),
                    $request->get('id_Medio_Transporte'), $request->get('id_Cargo'),
                    $request->get('id_tipocontratos'), $request->get('id_area'),
                    $request->get('id_Sub_Area'), $request->get('id_Bloque_Area'),
                    $request->get('id_CentroCosto')
                ));
            }
            return response()->json([
                'data' => 1,
                /* "mensaje" => 'Ficha tecnica Actualizada',*/
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

}
