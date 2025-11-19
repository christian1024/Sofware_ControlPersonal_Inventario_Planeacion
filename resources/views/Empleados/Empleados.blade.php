@extends('layouts.Principal')
@section('contenidoPrincipal')
    @can('VistaEmpleados')
        <div class="card row">
            <div class="col-md-12">
                <div class="card-heade text-center">
                    <h3>Empleados</h3>
                </div>
                <div class="card">
                    <div class="row card-body">

                        @can('crearEmpleado')
                            <div class="col-lg-1">
                                <div class="box-body">
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newempleado">
                                        Nuevo
                                    </button>
                                </div>

                            </div>
                        @endcan
                        <div class="col-lg-2">
                            <label>Imprimir Carnet</label>
                            <select class="labelform form-control" required="required" name="TipoCarnet" id="TipoCarnet">
                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                <option value="1"> Empresa</option>
                                <option value="2"> Temporal</option>

                            </select>
                        </div>
                        <div class="col-lg-9">

                            <form id="FormImprimirEmpresa" method="POST" action="{{ route('ImprimirMultiplesCarnets') }}">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="col-lg-12 row" style="display: none" id="CarntEmpresa">
                                    <div class="col-lg-9 form-groupfor">
                                        <label>Seleccione empleados</label><br>
                                        <select class="selectpicker col-lg-9" data-show-subtext="true" name="idusuarios[]" id="idusuarios" data-live-search="true" multiple data-actions-box="true" data-selected-text-format="count > 10" required="required">
                                            <option selected="true" value="" disabled="disabled"></option>
                                            @foreach($empleadosCarnet as $empleado)
                                                <option value="{{ $empleado->id }}"> {{$empleado->Codigo_Empleado }} - {{ $empleado->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-success" type="submit" id="ImprimirEmpresa">Imprimir</button>
                                    </div>
                                </div>
                            </form>

                            <form id="FormImprimirTemporal">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <div class="col-lg-12 row" style="display: none" id="CarnetTemporal">
                                    <div class="form-group col-lg-7">
                                        <label>Cantidad Carnet</label>
                                        <input type="number" class="form-control" id="CantTemp" name="CantTemp" required="required">
                                    </div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-success" type="submit" id="imprimirTemporal">Imprimir</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="card card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @can('verEmpleados')
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#Empleados" role="tab" aria-controls="home" aria-selected="true">Empleados</a>
                            </li>
                        @endcan
                        @can('VerEmpleadosLaboratorio')
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#EmpleadosLab" role="tab" aria-controls="contact" aria-selected="false">Empleados Laboratorio</a>
                            </li>
                        @endcan
                    </ul>

                    <div class="tab-content" id="myTabContent">

                        @can('verEmpleados')
                            <div class="tab-pane fade show active" id="Empleados" role="tabpanel" aria-labelledby="home-tab">
                                <div class="table-responsive-sm">
                                    <table id="EmpleadosActivos" class="table">
                                        <thead>
                                        <tr>
                                            <th>Numero Documento</th>
                                            <th>Codigo Empleado</th>
                                            <th>Apellidos y Nombres</th>
                                            <th>Genero</th>
                                            <th>Direccion Residencia.</th>
                                            <th>Telefono</th>
                                            <th>Barrio</th>
                                            <th>Rh</th>
                                            <th>Edad</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $empleados as $Empleado)
                                            <tr>
                                                <td>{{ $Empleado->Numero_Documento }}</td>
                                                <td>{{ $Empleado->Codigo_Empleado }}</td>
                                                <td>
                                                    {{ $Empleado->Primer_Apellido }}
                                                    {{ $Empleado->Segundo_Apellido }}
                                                    {{ $Empleado->Primer_Nombre }}
                                                    {{ $Empleado->Segundo_Nombre }}
                                                </td>
                                                <td>{{ $Empleado->Genero }}</td>
                                                <td>{{ $Empleado->Direccion_Residencia }}</td>
                                                <td>{{ $Empleado->Telefono }}</td>
                                                <td>{{ $Empleado->Barrio }}</td>
                                                <td>{{ $Empleado->Rh }}</td>
                                                <td>{{ $Empleado->Edad }}</td>
                                                @if($Empleado->Flag_Activo==='1' )
                                                    <td>Activo</td>
                                                @else
                                                    <td style="background-color: red">Inactivo</td>
                                                @endif
                                                @if( $Empleado-> Flag_Activo)
                                                    <td align="center">
                                                        @can('FichaTecnicaEmpleado')
                                                            <a href="{{ route('FichaTecnica',['id'=>encrypt($Empleado->id)]) }}" class="btn btn-primary btn-circle btn-sm" style="position: center" title="Ficha Tecnica"><i class="fa fa-edit btn-xl"></i> </a>
                                                        @endcan
                                                        @can('InactivarEmpleado')
                                                            <a href="{{ route('ImprimirCarnet',['id'=>encrypt($Empleado->id)]) }}" class="btn btn-success btn-circle btn-sm" style="position: center" title="Carnet"><i class="fa fa-address-card" aria-hidden="true"></i> </a>
                                                        @endcan
                                                        @can('InactivarEmpleado')
                                                            <a href="{{ route('InactivarEmpleado',['id'=>encrypt($Empleado->id)]) }}" id="EliminarEmpleado" methods="PUT" class="btn btn-danger btn-circle btn-sm" title="Eliminar" style="position: center"><i class="fa fa-trash"></i> </a>
                                                        @endcan
                                                    </td>
                                                @else
                                                    <td align="center">
                                                        @can('InactivarEmpleado')
                                                            <a href="{{ route('ActivarEmpleado',['id'=>encrypt($Empleado->id)]) }}" id="ACTIVAR" methods="PUT" class="btn btn-success btn-circle btn-sm" title="Activar Empleado" style="position: center"><i class="fa fa-check"></i> </a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                        @can('VerEmpleadosLaboratorio')
                            <div class="tab-pane fade" id="EmpleadosLab" role="tabpanel" aria-labelledby="contact-tab">
                                <div>
                                    <table id="TableEmpleadosLab" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>N Documento</th>
                                            <th>Codigo</th>
                                            <th>Nombres y Apellidos</th>
                                            <th>Area</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach( $EmpleadosLab as $EmpleadosLa)
                                            <tr>
                                                <td>{{ $EmpleadosLa->Numero_Documento }}</td>
                                                <td>{{ $EmpleadosLa->Codigo_Empleado }}</td>
                                                <td>
                                                    {{ $EmpleadosLa->NombreEmpleado }}
                                                </td>
                                                <td>{{ $EmpleadosLa->Sub_Area }}</td>
                                                <td align="center">
                                                    @can('FuncionEmpleadosLaboratorio')
                                                        <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#EmpleadosLabAsigCargo" data-whatever="{{ json_encode($EmpleadosLa) }}">
                                                            <i data-toggle="tooltip" data-placement="left" title="Funcion" class="fa fa-edit "></i>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Crear Usuario-->
        @can('crearEmpleado')
            <div class="modal fade" id="newempleado">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align: center">
                            <h3 class="modal-title"><i class="fa fa-user-circle pulse" style="color: #0b97c4"></i> Crear Empleado</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="createEmpleados" method="POST" action="{{ route('crearEmpleados') }}" enctype="multipart/form-data">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                                <div class="form-row">
                                    <div class="col">
                                        <label>{{ __('Tipo Documento') }}</label>
                                        <select id="Tipo_Doc" class="form-control" name="Tipo_Doc" required>
                                            @foreach($documento as $doc)
                                                <option value="{{ $doc->id_Doc }}">   {{$doc->Iniciales}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>{{ __('Numero Documento') }}</label>
                                        <input id="Numero_Documento" type="number" onblur="Existe(this)" min="1" class="form-control{{ $errors->has('Numero_Documento') ? ' is-invalid' : '' }}" name="Numero_Documento" value="{{ old('Numero_Documento') }}" autofocus required>
                                        @if ($errors->has('Numero_Documento'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Numero_Documento') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="" class="col-form-label text-md-right">{{ __('Departamento Expedicion') }}</label>
                                        <select id="departamentos_id_Expe" class="form-control labelform" name="departamentos_id_Expe" required>
                                            @foreach($depart  as $depa)
                                                <option value="{{ $depa->id }}">   {{$depa->Departamento}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="" class="col-form-label text-md-right">{{ __('Ciudad Expedición') }}</label>
                                        <select id="Ciudad_id_Expedcion" class="form-control labelform" name="Ciudad_id_Expedcion" required>

                                        </select>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Primer Apellido') }}</label>
                                        <input id="Primer_Apellido" type="text" class="form-control labelform {{ $errors->has('Primer_Apellido') ? ' is-invalid' : '' }}" name="Primer_Apellido" value="{{ old('Primer_Apellido') }}" autofocus required>
                                        @if ($errors->has('Primer_Apellido'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Primer_Apellido') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>
                                        <input id="Segundo_Apellido" type="text" class="form-control labelform {{ $errors->has('Segundo_Apellido') ? ' is-invalid' : '' }}" name="Segundo_Apellido" value="{{ old('Segundo_Apellido') }}" autofocus>
                                        @if ($errors->has('Segundo_Apellido'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Segundo_Apellido') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Primer Nombre') }}</label>
                                        <input id="Primer_Nombre" type="text" class="form-control labelform {{ $errors->has('Primer_Nombre') ? ' is-invalid' : '' }}" name="Primer_Nombre" value="{{ old('Primer_Nombre') }}" autofocus required>
                                        @if ($errors->has('Primer_Nombre'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Primer_Nombre') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Segundo Nombre') }}</label>
                                        <input id="Segundo_Nombre" type="text" class="form-control labelform {{ $errors->has('Segundo_Nombre') ? ' is-invalid' : '' }}" name="Segundo_Nombre" value="{{ old('Segundo_Nombre') }}" autofocus>
                                        @if ($errors->has('Segundo_Nombre'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Segundo_Nombre') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Genero') }}</label>
                                        <select id="Genero" name="Genero" class="form-control labelform" required>
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                        </select>
                                        @if ($errors->has('Genero'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Genero') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                    {{-- <div class="col">
                                         <label for="name" class="col-form-label text-md-right">{{ __('Codigo Empleado') }}</label>
                                         <input id="Codigo_Empleado" type="text" class="form-control labelform {{ $errors->has('Codigo_Empleado') ? ' is-invalid' : '' }}" name="Codigo_Empleado" value="{{ old('Codigo_Empleado') }}" autofocus>
                                         @if ($errors->has('Codigo_Empleado'))
                                             <span class="invalid-feedback">
                                               <strong>{{ $errors->first('Codigo_Empleado') }}</strong>
                                                      </span>
                                         @endif
                                     </div>--}}
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Telefono') }}</label>
                                        <input id="Telefono" type="number" class="form-control labelform {{ $errors->has('Telefono') ? ' is-invalid' : '' }}" name="Telefono" value="{{ old('Telefono') }}" autofocus>
                                        @if ($errors->has('Telefono'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Telefono') }}</strong>
                                                    </span>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Barrio') }}</label>
                                        <input id="Barrio" type="text" class="form-control labelform {{ $errors->has('Barrio') ? ' is-invalid' : '' }}" name="Barrio" value="{{ old('Barrio') }}" autofocus required>
                                        @if ($errors->has('Barrio'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Barrio') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Edad') }}</label>
                                        <input id="Edad" type="text" class="form-control labelform {{ $errors->has('Edad') ? ' is-invalid' : '' }}" name="Edad" value="{{ old('Edad') }}" autofocus required>
                                        @if ($errors->has('Edad'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Edad') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="col">
                                        <label for="Rh" class="col-form-label text-md-right">{{ __('RH') }}</label>
                                        <select id="Rh" class="form-control labelform" name="Rh" required>
                                            <option value="A-">A-</option>
                                            <option value="A+">A+</option>
                                            <option value="AB-">AB-</option>
                                            <option value="AB+">AB+</option>
                                            <option value="B-">B-</option>
                                            <option value="B+">B+</option>
                                            <option value="O">O</option>
                                            <option value="O-">O-</option>
                                            <option value="O+">O+</option>

                                        </select>
                                        @if ($errors->has('RH'))
                                            <span class="invalid-feedback">
                                                         <strong>{{ $errors->first('RH') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                </div>


                                <div class="form-row">
                                    <div class="col">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Direccion Residencia') }}</label>
                                        <input id="Direccion_Residencia" type="text" class="form-control labelform {{ $errors->has('Direccion_Residencia') ? ' is-invalid' : '' }}" name="Direccion_Residencia" value="{{ old('Direccion_Residencia') }}" autofocus required>
                                        @if ($errors->has('Direccion_Residencia'))
                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Direccion_Residencia') }}</strong>
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="col">
                                        <label for="" class="col-form-label text-md-right">{{ __('Departamento Residencia') }}</label>
                                        <select id="departamentos_id_Residencia" class="form-control labelform" name="departamentos_id_Residencia" required>
                                            @foreach($depart  as $depa)
                                                <option value="{{ $depa->id }}">   {{$depa->Departamento}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="" class="col-form-label text-md-right">{{ __('Ciudad Residencia') }}</label>
                                        <select id="Ciudad_id_Residencia" class="form-control labelform" name="Ciudad_id_Residencia" required>

                                        </select>
                                    </div>
                                    <div class="col">
                                        <label for="" class="col-form-label text-md-right">{{ __('Fecha Nacimiento') }}</label>
                                        <input id="Fecha_Nacimientoo" type="date" class="form-control labelform" name="Fecha_Nacimiento" required/>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <label for="">Cargar Foto </label>
                                        <input type="file" class="form-control" name="img" id="img">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="col-lg-10"></div>
                                    <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
        @endcan
        {{--modal para asignar area sub area y funcion laboratorio--}}
        <div class="modal fade" id="EmpleadosLabAsigCargo">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header" style="text-align: center">
                        <h3 class="modal-title"><i class="fa fa-user-circle pulse" style="color: #0b97c4"></i> Asignar Funcion</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="createEmpleados" method="POST" action="{{ route('EmpleadosLaboratorio') }}" enctype="multipart/form-data">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                            <div class="form-row">
                                <div class="col">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Codigo') }}</label>
                                    <input id="Codigo" type="text" disabled="disabled" class="form-control labelform" name="Codigo" autofocus>
                                </div>
                                <div class="col">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Nombre') }}</label>
                                    <input id="Nombre" type="text" disabled="disabled" class="form-control labelform" name="Nombre" autofocus>
                                </div>
                                <div class="col">
                                    <label for="id_areaLab" class="col-form-label text-md-right">{{ __('Area') }}</label>
                                    <input id="id_areaLab" name="id_area" disabled class="form-control labelform">
                                </div>

                            </div>

                            <div class="form-row">
                                <div class="col">
                                    <label for="id_areaLab" class="col-form-label text-md-right">{{ __('Sub Area') }}</label>
                                    <select id="id_Sub_AreaLab" name="id_Sub_Area" class="form-control labelform" required="required">
                                        <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                        @foreach ( $SubAreas as $SubArea)
                                            <option value="{{ $SubArea->id }}" {{--{{ ($EmpleadosLab && $EmpleadosLab->id_Sub_Area== $SubArea->id)?'selected':''}}--}}>  {{$SubArea->Sub_Area}} </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="id_Bloque_AreaLab" class="col-form-label text-md-right">{{ __('Funcion') }}</label>
                                    <select id="id_Bloque_AreaLab" name="id_Bloque_Area" class="form-control labelform" required="required">
                                        {{--@if($EmpleadosLab && $EmpleadosLab->id_Bloque_Area)
                                            <option value="{{ $EmpleadosLab->id_Bloque_Area }}">{{ $EmpleadosLab->id_Bloque_Area }}</option>
                                        @else--}}
                                        <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                        {{-- @endif--}}
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-lg-10"></div>
                                <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

    @endcan
    <script>

        function Existe() {

            let dato = $("#Numero_Documento").val();

            $.ajax({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                data: {dato},
                url: '{{ route('ExisteEmpleado') }}',
                type: 'post',
                success: function (Result) {
                    if (Result.ok === 1) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Numero de Documento ya Existe',
                        })
                        $("#Numero_Documento").val('');
                    }
                }
            });
        }

        @if(session()->has('ok'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'El empleado Fue Inactivo DEBE COLOCAR FECHA DE RETIRO',
            });

        });
        @endif

        @if(session()->has('error'))
        $(document).ready(function () {
            iziToast.success({
                timeout: 20000,
                title: 'Ok',
                position: 'center',
                message: 'El empleado Fue activo Correctamente',
            });
        });
        @endif

        @if(session()->has('creado'))
        $(document).ready(function () {
            iziToast.success({
                timeout: 20000,
                title: 'Ok',
                position: 'center',
                message: 'El empleado Fue creado Correctamente',
            });

        });
        @endif

        @if(session()->has('existe'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'El Numero de documento ya existe el empleado no fue creado',
            });
            //toastr["error"]("");
        });
        @endif

        @if(session()->has('update'))
        $(document).ready(function () {
            iziToast.success({
                timeout: 20000,
                title: 'Ok',
                position: 'center',
                message: 'Actualizado Correctamente',
            });

        });
        @endif

        $(document).ready(function () {
            let token = $('#token').val();
            $('#Fecha_Ingreso,#Fecha_retiro,#Ultima_Fecha_Ingreso,#Fecha_Cambio_Contrato,#Fecha_Nacimiento').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('#EmpleadosActivos,#TableEmpleadosLab').DataTable({
                dom: "Bfrtip",
                buttons: [
                    'excel'
                ],
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });

            $('#FichaTecnica').on('click', function () {
                let valor = this.value;
                console.log(valor);
                window.location = '{{ asset('') }}FichaTecnica/' + valor + '/empelados';
            })


            /**************************** filtro para ciudades y empleados *************************************/
            $("#departamentos_id_Expe").change(function () {
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Departamentos') }}',
                    data: {Departamento: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',
                    success: function (Result) {
                        /* console.log(Result);*/
                        $("#Ciudad_id_Expedcion").empty().selectpicker('destroy');
                        $.each(Result.Data, function (i, item) {
                            $("#Ciudad_id_Expedcion").append('<option value="' + item.id + '">' + item.ciudad + '</option>');
                            /*donde esta este select*/
                        });
                        $('#Ciudad_id_Expedcion').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });


            $("#departamentos_id_Residencia").change(function () {
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Departamentos') }}',
                    data: {Departamento: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',
                    success: function (Result) {
                        /* console.log(Result);*/
                        $("#Ciudad_id_Residencia").empty().selectpicker('destroy');
                        $.each(Result.Data, function (i, item) {
                            $("#Ciudad_id_Residencia").append('<option value="' + item.id + '">' + item.ciudad + '</option>');
                            /*donde esta este select*/
                        });
                        $('#Ciudad_id_Residencia').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                    },
                    error: function (e) {
                        console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });

            /**************************** Area y sub_Area  *************************************/

            $("#id_area").change(function () {
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Area') }}',
                    data: {Area: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',
                    success: function (Result) {
                        console.log(Result);
                        $("#id_Sub_Area").empty().selectpicker('destroy');
                        $.each(Result.Data, function (i, item) {
                            $("#id_Sub_Area").append('<option value="' + item.id + '">' + item.Sub_Area + '</option>');
                            /*donde esta este select*/
                        });
                        $('#id_Sub_Area').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });
                        //$('id_area select').selectpicker('refresh');
                    },
                    error: function (e) {
                        console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });


            $("#id_Sub_Area").change(function () {
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Bloque') }}',
                    data: {sub_area: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',

                    success: function (Result) {
                        /* console.log(Result);*/

                        $("#id_Bloque_Area").empty().selectpicker('destroy');
                        $.each(Result.Dato, function (i, item) {
                            $("#id_Bloque_Area").append('<option value="' + item.id + '">' + item.bloque_area + '</option>');
                            /*donde esta este select*/
                        });
                        $('#id_Bloque_Area').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });

                    },
                    error: function (e) {
                        console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });

            $("#id_Sub_AreaLab").change(function () {
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Bloque') }}',
                    data: {sub_area: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',

                    success: function (Result) {
                        /* console.log(Result);*/

                        $("#id_Bloque_AreaLab").empty().selectpicker('destroy');
                        $.each(Result.Dato, function (i, item) {
                            $("#id_Bloque_AreaLab").append('<option value="' + item.id + '">' + item.bloque_area + '</option>');
                            /*donde esta este select*/
                        });
                        $('#id_Bloque_AreaLab').selectpicker({
                            size: 4,
                            liveSearch: true,
                        });

                    },
                    error: function (e) {
                        console.log(e);
                        $.each(error.responseJSON.errors, function (i, item) {
                            alertify.error(item)
                        });
                    }
                });
            });

        });


        $('#EmpleadosLabAsigCargo').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#Codigo').val(data.Codigo_Empleado);
            modal.find('#Nombre').val(data.Primer_Apellido + ' ' + data.Segundo_Apellido + ' ' + data.Primer_Nombre + ' ' + data.Segundo_Nombre);
            modal.find('#id_areaLab').val(data.area);
            modal.find('#id_Sub_AreaLab').val(data.id_Sub_Area);
            modal.find('#id_Bloque_AreaLab').html('<option value="' + data.id_Bloque_Area + '">' + data.bloque_area + '</option>');
            modal.find('#idEmpleado').val(data.id);
        });

        $('input[id="img"]').on('change', function () {
            var ext = $(this).val().split('.').pop();
            //let tamanio=$(this)[0].files[0].size;
            //alert(tamanio);
            if ($(this).val() != '') {
                if ($(this)[0].files[0].size > 15000000) {
                    swal("Error!", "Tamaño de la imagen muy Grande", "error");
                    $(this).val('');
                } else {

                }

            }
        })

        $('#TipoCarnet').change(function () {
            let cant = $(this).val();
            if (cant === '1') {
                $('#CarntEmpresa').show();
                $('#CarnetTemporal').hide();
            } else if (cant === '2') {
                $('#CarntEmpresa').hide();
                $('#CarnetTemporal').show();
            }
        });

    </script>
@endsection
