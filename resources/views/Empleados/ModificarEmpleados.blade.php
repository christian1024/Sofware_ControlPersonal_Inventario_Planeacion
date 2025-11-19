@extends('layouts.Principal')
@section('contenidoPrincipal')

    @can('FichaTecnicaEmpleado')
        <div class="card row">
            <div class="col-md-12">
                <section class="content espacioform">

                    <div class="tituloform">
                        <h3>Modificar Empleado </h3>
                    </div>

                    <div class="box box-primary col-lg-12">
                        <div class="box-body">
                            <form id="CrearFichaTecnica">
                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                <input type="hidden" value="{{ $empleado->id }}" name="id_Empleado" id="id_Empleado">
                                <div>
                                    <div>

                                        <div class="">
                                            <div class="form-row">
                                                <div class="col-3">
                                                    <div class="form-group" style="align-items:center;">
                                                        @php($img=( $empleado->img)?$empleado->img:'Noimg.png')
                                                        <img src="{{ asset('imagenes/') }}/{{ $img }}" class="card-img-top" width="65%" alt="User Image">
                                                        @can('ActualizarFichaTecnicaEmpleado')
                                                            <button type="button" class="btn btn-outline-success btn-lg btn-block" data-toggle="modal" data-target="#UpdateImg">Cambiar</button>
                                                        @endcan
                                                    </div>
                                                </div>
                                                {{--columna 1--}}
                                                <div class="col-3">
                                                    <div class="form-group ">
                                                        <label for="Tipo_Doc" class="col-form-label text-md-right">{{ __('Tipo Documento') }}</label>
                                                        <select id="Tipo_Doc" class="form-control labelform" name="Tipo_Doc" required>
                                                            @foreach($documento as $doc)
                                                                <option value="{{ $doc->id_Doc }}" {{ ($doc->id == $empleado->Tipo_Doc)?'selected':'' }}> {{$doc->Iniciales}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="Ciudad_id_Expedcion" class="col-form-label text-md-right">{{ __('Ciudad Expedicion') }}</label>
                                                        <select id="Ciudad_id_Expedcion" class="form-control labelform" name="Ciudad_id_Expedcion" required>
                                                            @foreach($ciudad  as $CDA)
                                                                <option value="{{ $CDA->id }}" {{ ($CDA->id == $empleado->Ciudad_id_Expedcion)?'selected':'' }}>   {{$CDA->ciudad}} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Primer Nombre') }}</label>
                                                        <input id="Primer_Nombre" type="text" value="{{ $empleado->Primer_Nombre }}" class="form-control labelform {{ $errors->has('Primer_Nombre') ? ' is-invalid' : '' }}" name="Primer_Nombre" value="{{ old('Primer_Nombre') }}" required>
                                                        @if ($errors->has('Primer_Nombre'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Primer_Nombre') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>


                                                </div>

                                                {{--columna 2--}}
                                                <div class="col-3">

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Numero Documento') }}</label>
                                                        <input id="Numero_Documento" value="{{ $empleado->Numero_Documento}}" type="text" class="form-control labelform {{ $errors->has('Numero_Documento') ? ' is-invalid' : '' }}" name="Numero_Documento" value="{{ old('Numero_Documento') }}" required>
                                                        @if ($errors->has('Numero_Documento'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Numero_Documento') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Primer Apellido') }}</label>
                                                        <input id="Primer_Apellido" type="text" value="{{ $empleado->Primer_Apellido   }}" class="form-control labelform {{ $errors->has('Primer_Apellido') ? ' is-invalid' : '' }}" name="Primer_Apellido" value="{{ old('Primer_Apellido') }}" required>
                                                        @if ($errors->has('Primer_Apellido'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Primer_Apellido') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Segundo Nombre') }}</label>
                                                        <input id="Segundo_Nombre" type="text" value="{{ $empleado->Segundo_Nombre }}" class="form-control labelform {{ $errors->has('Segundo_Nombre') ? ' is-invalid' : '' }}" name="Segundo_Nombre" value="{{ old('Segundo_Nombre') }}">
                                                        @if ($errors->has('Segundo_Nombre'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Segundo_Nombre') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>


                                                </div>

                                                {{--columna 3--}}
                                                <div class="col-3">

                                                    <div class="form-group">
                                                        <label for="departamentos_id_Expe" class="col-form-label text-md-right">{{ __('Departamento Expedicion') }}</label>
                                                        <select id="departamentos_id_Expe" class="form-control labelform" name="departamentos_id_Expe" required>
                                                            @foreach($depart  as $depa)
                                                                <option value="{{ $depa->id }}" {{ ($depa->id == $empleado->departamentos_id_Expe)?'selected':'' }}>   {{$depa->Departamento }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Segundo Apellido') }}</label>
                                                        <input id="Segundo_Apellido" type="text" value="{{ $empleado->Segundo_Apellido }}" class="form-control labelform {{ $errors->has('Segundo_Apellido') ? ' is-invalid' : '' }}" name="Segundo_Apellido" value="{{ old('Segundo_Apellido') }}">
                                                        @if ($errors->has('Segundo_Apellido'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Segundo_Apellido') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name" class="col-form-label text-md-right">{{ __('Genero') }}</label>
                                                        <select id="Genero" name="Genero" class="form-control labelform" required>
                                                            <option value="Masculino" {{ ($empleado->Genero=='Masculino')?'selected':'' }} >Masculino</option>
                                                            <option value="Femenino" {{ ($empleado->Genero=='Femenino')?'selected':'' }} >Femenino</option>
                                                        </select>
                                                        @if ($errors->has('Genero'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Genero') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>


                                                </div>


                                            </div>
                                        </div>

                                        <div class="form-row">


                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Codigo Empleado') }}</label>
                                                <input id="Codigo_Empleado" disabled type="text" value="{{ $empleado->Codigo_Empleado }}" class="form-control labelform {{ $errors->has('Codigo_Empleado') ? ' is-invalid' : '' }}" name="Codigo_Empleado" value="{{ old('Codigo_Empleado') }}">

                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Direccion Residencia') }}</label>
                                                <input id="Direccion_Residencia" type="text" value="{{ $empleado->Direccion_Residencia }}" class="form-control labelform {{ $errors->has('Direccion_Residencia') ? ' is-invalid' : '' }}" name="Direccion_Residencia" value="{{ old('Direccion_Residencia') }}" required>
                                                @if ($errors->has('Direccion_Residencia'))
                                                    <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Direccion_Residencia') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Barrio') }}</label>
                                                <input id="Barrio" type="text" value="{{ $empleado->Barrio }}" class="form-control labelform {{ $errors->has('Barrio') ? ' is-invalid' : '' }}" name="Barrio" value="{{ old('Barrio') }}" required>
                                                @if ($errors->has('Barrio'))
                                                    <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Barrio') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-1">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Edad') }}</label>
                                                <input id="Edad" type="text" value="{{ $empleado->Edad }}" class="form-control  labelform {{ $errors->has('Edad') ? ' is-invalid' : '' }}" name="Edad" value="{{ old('Edad') }}">
                                                @if ($errors->has('Edad'))
                                                    <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Edad') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group col-md-2">
                                                <label for="Rh" class="col-form-label text-md-right">{{ __('RH') }}</label>
                                                <select id="Rh" name="Rh" class="form-control labelform">
                                                    <option value="A-"{{ ($empleado->Rh=='A-')?'selected':'' }}>A-</option>
                                                    <option value="A+"{{ ($empleado->Rh=='A+')?'selected':'' }}>A+</option>
                                                    <option value="AB-"{{ ($empleado->Rh=='AB-')?'selected':'' }}>AB-</option>
                                                    <option value="AB+"{{ ($empleado->Rh=='AB+')?'selected':'' }} >AB+</option>
                                                    <option value="B-" {{ ($empleado->Rh=='B-')?'selected':'' }}>B-</option>
                                                    <option value="B+" {{ ($empleado->Rh=='B+')?'selected':'' }}>B+</option>
                                                    <option value="O"{{ ($empleado->Rh=='O')?'selected':'' }}>O</option>
                                                    <option value="O-"{{ ($empleado->Rh=='O-')?'selected':'' }}>O-</option>
                                                    <option value="O+"{{ ($empleado->Rh=='O+')?'selected':'' }}>O+</option>
                                                </select>
                                                @if ($errors->has('RH'))
                                                    <span class="invalid-feedback">
                                                         <strong>{{ $errors->first('RH') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Departamento Residencia') }}</label>
                                                <select id="departamentos_id_Residencia" name="departamentos_id_Residencia" class="form-control labelform">
                                                    @foreach($depart  as $depa)
                                                        <option value="{{ $depa->id }}" {{ ($depa->id == $empleado->departamentos_id_Residencia)?'selected':'' }}>  {{$depa->Departamento}}    </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="Ciudad_id_Residencia" class="col-form-label text-md-right">{{ __('Municipio Residencia') }}</label>
                                                <select id="Ciudad_id_Residencia" class="form-control labelform" name="Ciudad_id_Residencia">
                                                    @foreach($ciudad  as $CDA)
                                                        <option value="{{ $CDA->id }}" {{ ($CDA->id == $empleado->Ciudad_id_Residencia)?'selected':'' }} >   {{$CDA->ciudad}} </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Telefono') }}</label>
                                                <input id="Telefono" type="number" min="0" value="{{ $empleado->Telefono }}" class="form-control labelform {{ $errors->has('Telefono') ? ' is-invalid' : '' }}" name="Telefono" value="{{ old('Telefono') }}">
                                                @if ($errors->has('Telefono'))
                                                    <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Telefono') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Fecha Nacimiento') }}</label>
                                                <div class="form-group">
                                                    <div class='input-group date' id='Fecha_Nacimiento'>
                                                        <input type='date' class="form-control labelform" name="Fecha_Nacimiento" value="{{ $empleado->FechaNaciemiento }}"/>
                                                        <span class="input-group-addon  labelform">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>

                                            {{--<div class="form-group col-md-3">
                                                <label for="Fecha_Nacimiento" class="col-form-label text-md-right">{{ __('Fecha Nacimiento') }}</label>
                                                <input id="Fecha_Nacimiento" type="date" value="{{ $empleado->FechaNaciemiento }}" class="form-control labelform " name="Fecha_Nacimiento" value="{{ old('Fecha_Nacimiento') }}">
                                                @if ($errors->has('Telefono'))
                                                    <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Telefono') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
--}}
                                        </div>

                                        <!--Fincha Tecnica -->

                                        <div class="form-row">
                                            <hr style="margin-top: 3px"/>

                                            <div class='form-group col-md-3'>
                                                <label for="date" class="col-form-label text-md-right">{{ __('Fecha Ingreso') }}</label>
                                                <div class="form-group">
                                                    <div class="form-group {!! ($datosEmpleados && $datosEmpleados->Fecha_Ingreso!='')?'':'has-error' !!}">
                                                        <div class='input-group date' id="Fecha_Ingreso">
                                                            <input type='date' class="form-control labelform" name="Fecha_Ingreso" value="{{ $datosEmpleados && $datosEmpleados->Fecha_Ingreso?$datosEmpleados->Fecha_Ingreso:''}}"/>
                                                            <span class="input-group-addon labelform">
                                                    <span class="glyphicon glyphicon-calendar">
                                                    </span>
                                                </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group col-md-3 {!!($datosEmpleados && $datosEmpleados->Salario != '')? '':'has-error'!!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Salario') }}</label>
                                                <input id="Salario" type="number" min="0" class="form-control labelform" name="Salario" value="{{$datosEmpleados &&  $datosEmpleados->Salario?$datosEmpleados->Salario:'' }}">

                                            </div>


                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Cargo!='')?'':'has-error' !!}">
                                                <label for="id_Cargo" class="col-form-label text-md-right">{{ __('Cargo') }}</label>
                                                <select id="id_Cargo" name="id_Cargo" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Cargo</option>
                                                    @foreach($Cargo  as $Cargos)
                                                        <option Value="{{ $Cargos->id }}" {{ ($datosEmpleados && $datosEmpleados->id_Cargo== $Cargos->id)?'selected':''}}>{{$Cargos->Cargo}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_tipocontratos!='')?'':'has-error' !!}">
                                                <label for="id_tipocontratos" class="col-form-label text-md-right">{{ __('Tipo Contrato') }}</label>
                                                <select id="id_tipocontratos" name="id_tipocontratos" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione T. Contrato</option>
                                                    @foreach($TipContrato  as $contrato)
                                                        <option Value="{{ $contrato->id }}" {{ ($datosEmpleados && $datosEmpleados->id_tipocontratos== $contrato->id)?'selected':''}}>{{$contrato->Tipo_Contrato}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Estado_Civil!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Estado Civil') }}</label>
                                                <select id="id_Estado_Civil" name="id_Estado_Civil" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Estado Civil</option>
                                                    @foreach( $EstadoCivil as $estadoCivil )
                                                        <option Value="{{ $estadoCivil->id }}" {{ ($datosEmpleados && $datosEmpleados->id_Estado_Civil== $estadoCivil->id)?'selected':''}}>{{$estadoCivil->Estado_Civil}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_area!='')?'':'has-error' !!}">
                                                <label for="id_area" class="col-form-label text-md-right">{{ __('Area') }}</label>
                                                <select id="id_area" name="id_area" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Area</option>
                                                    @foreach($Area  as $Area)
                                                        <option Value="{{ $Area->id }}" {{ ($datosEmpleados && $datosEmpleados->id_area== $Area->id)?'selected':''}}>{{$Area->Area}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Sub_Area!='')?'':'has-error' !!}">
                                                <label for="id_Sub_Area" class="col-form-label text-md-right">{{ __('Sub Area') }}</label>
                                                <select id="id_Sub_Area" name="id_Sub_Area" class="form-control labelform">

                                                    @if($datosEmpleados && $datosEmpleados->id_Sub_Area)
                                                        <option value="{{ $datosEmpleados->id_Sub_Area }}">{{ $datosEmpleados->Sub_Area }}</option>
                                                    @else
                                                        <option selected="true" value="" disabled="disabled">Seleccione Sub Area</option>
                                                    @endif


                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Bloque_Area!='')?'':'has-error' !!} ">
                                                <label for="id_Bloque_Area" class="col-form-label text-md-right">{{ __('Bloque/Funcion') }}</label>
                                                <select id="id_Bloque_Area" name="id_Bloque_Area" class="form-control labelform">
                                                    @if($datosEmpleados && $datosEmpleados->id_Bloque_Area)
                                                        <option>{{ $datosEmpleados->bloque_area }}</option>
                                                    @else
                                                        <option selected="true" value="" disabled="disabled">Seleccione Sub Area</option>
                                                    @endif


                                                </select>
                                            </div>


                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Pension!='')?'':'has-error' !!}">
                                                <label for="Pension" class="col-form-label text-md-right">{{ __('Pension') }}</label>
                                                <select id="Pension" name="Pension" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Pension</option>
                                                    @foreach($Pension  as $Pension1)
                                                        <option Value="{{ $Pension1->id }}" {{ ($datosEmpleados && $datosEmpleados->id_Pension== $Pension1->id)?'selected':''}}>{{$Pension1->NombreFondoP}}</option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Cesantias!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Cesantias') }}</label>
                                                <select id="Cesantias" name="Cesantias" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Cesantias</option>
                                                    <option value="Porvenir" {{ $datosEmpleados && $datosEmpleados->Cesantias=='Porvenir' ?'selected':'' }}>Porvenir</option>
                                                    <option value="Fondo Nacional del Ahorro" {{ $datosEmpleados && $datosEmpleados->Cesantias=='Fondo Nacional del Ahorro' ?'selected':'' }}>Fondo Nacional del Ahorro</option>
                                                    <option value="Horizonte" {{ $datosEmpleados && $datosEmpleados->Cesantias=='Horizonte' ?'selected':'' }}>Horizonte</option>
                                                    <option value="Colfondos" {{ $datosEmpleados && $datosEmpleados->Cesantias=='Colfondos' ?'selected':'' }}>Colfondos</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_CajaCompensacion!='')?'':'has-error' !!}">
                                                <label for="Caja_Compensacion" class="col-form-label text-md-right">{{ __('Caja Compensacion') }}</label>
                                                <select id="Caja_Compensacion" name="Caja_Compensacion" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Uno..</option>
                                                    @foreach($Compensas   as $Compensa )
                                                        <option Value="{{ $Compensa->id }}" {{ ($datosEmpleados && $datosEmpleados->id_CajaCompensacion== $Compensa->id)?'selected':''}}>{{$Compensa->NombreCompensacion}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Auxilio_Transporte!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Auxilio de Transporte') }}</label>
                                                <select id="Auxilio_Transporte" name="Auxilio_Transporte" type="text" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">A. Transporte</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Auxilio_Transporte=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Auxilio_Transporte=='No' ?'selected':'' }}>No</option>
                                                </select>

                                            </div>

                                        </div>

                                        <div class="form-row">


                                            <div class="form-group col-md-3  {!! ($datosEmpleados && $datosEmpleados->Numero_Cuenta!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Numero Cuenta') }}</label>
                                                <input id="Numero_Cuenta" type="number" min="0" class="form-control labelform" name="Numero_Cuenta" value="{{ $datosEmpleados && $datosEmpleados->Numero_Cuenta?$datosEmpleados->Numero_Cuenta:''}}">

                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Formacion!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Formacion') }}</label>
                                                <select id="Formacion" name="Formacion" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Selecciones Formacion</option>
                                                    <option value="Primaria" {{ $datosEmpleados && $datosEmpleados->Formacion=='Primaria' ?'selected':'' }}>Primaria</option>
                                                    <option value="Bachiller"{{ $datosEmpleados && $datosEmpleados->Formacion=='Bachiller' ?'selected':'' }}>Bachiller</option>
                                                    <option value="Tecnico(a)"{{ $datosEmpleados && $datosEmpleados->Formacion=='Tecnico(a)' ?'selected':'' }}>Tecnico(a)</option>
                                                    <option value="Tecnologo(a)"{{ $datosEmpleados && $datosEmpleados->Formacion=='Tecnologo(a)' ?'selected':'' }}>Tecnologo(a)</option>
                                                    <option value="Universitario(a)"{{ $datosEmpleados && $datosEmpleados->Formacion=='Universitario(a)' ?'selected':'' }}>Universitario(a)</option>
                                                    <option value="Especializacion"{{ $datosEmpleados && $datosEmpleados->Formacion=='Especializacion' ?'selected':'' }}>Especializacion</option>
                                                    <option value="Maestria"{{ $datosEmpleados && $datosEmpleados->Formacion=='Maestria' ?'selected':'' }}>Maestria</option>
                                                    <option value="Doctorado"{{ $datosEmpleados && $datosEmpleados->Formacion=='Doctorado' ?'selected':'' }}>Doctorado</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Numero_Hijos!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Numero Hijos') }}</label>
                                                <input id="Numero_Hijos" type="number" min="0" class="form-control labelform" name="Numero_Hijos" value="{{ $datosEmpleados && $datosEmpleados->Numero_Hijos?$datosEmpleados->Numero_Hijos:'' }}">

                                            </div>
                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Talla_Chaqueta!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Talla Chaqueta') }}</label>
                                                <input id="Talla_Chaqueta" type="Text" class="form-control labelform" name="Talla_Chaqueta" value="{{$datosEmpleados &&  $datosEmpleados->Talla_Chaqueta?$datosEmpleados->Talla_Chaqueta:'' }}">

                                            </div>
                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Talla_Pantalon!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Talla Pantalon') }}</label>
                                                <input id="Talla_Pantalon" type="Text" class="form-control labelform" name="Talla_Pantalon" value="{{ $datosEmpleados && $datosEmpleados->Talla_Pantalon?$datosEmpleados->Talla_Pantalon:'' }}">

                                            </div>
                                        </div>

                                        <div class="form-row">


                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Talla_overol!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Talla Overol') }}</label>
                                                <input id="Talla_overol" type="Text" class="form-control labelform" name="Talla_overol" value="{{ $datosEmpleados && $datosEmpleados->Talla_overol?$datosEmpleados->Talla_overol:'' }}">

                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Numero_Calzado!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Talla Calzado') }}</label>
                                                <input id="Numero_Calzado" type="number" min="0" class="form-control labelform" name="Numero_Calzado" value="{{ $datosEmpleados && $datosEmpleados->Numero_Calzado?$datosEmpleados->Numero_Calzado:'' }}">

                                            </div>

                                            <div class="form-group col-md-2  {!! ($datosEmpleados && $datosEmpleados->personas_cargo!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Personas a Cargo') }}</label>
                                                <input id="personas_cargo" type="number" min="0" class="form-control labelform" name="personas_cargo" value="{{ $datosEmpleados && $datosEmpleados->personas_cargo?$datosEmpleados->personas_cargo:'' }}">

                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->peso!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Peso') }}</label>
                                                <input id="peso" type="number" min="0" step=".01" class="form-control labelform" name="peso" value="{{ $datosEmpleados && $datosEmpleados->peso?$datosEmpleados->peso:''  }}">

                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->estatura!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Estatura') }}</label>
                                                <input id="estatura" type="number" min="0" step=".01" class="form-control labelform " name="estatura" value="{{ $datosEmpleados && $datosEmpleados->estatura?$datosEmpleados->estatura:''}}">
                                            </div>
                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Numero_Botas_Caucho!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('N Botas Caucho') }}</label>
                                                <input id="Numero_Botas_Caucho" type="number" min="0" class="form-control labelform" name="Numero_Botas_Caucho" value="{{$datosEmpleados&&$datosEmpleados->Numero_Botas_Caucho?$datosEmpleados->Numero_Botas_Caucho:'' }}">
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->enfermedad_laboral!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Enfermedad Laboral') }}</label>
                                                <select id="enfermedad_laboral" name="enfermedad_laboral" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">En. laboral</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->enfermedad_laboral=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->enfermedad_laboral=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Carnet!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Tarjeta') }}</label>
                                                <input id="Carnet" type="number" min="0" class="form-control labelform" name="Tarjeta" value="{{$datosEmpleados && $datosEmpleados->Carnet?$datosEmpleados->Carnet:'' }}">
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Raza!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Raza') }}</label>
                                                <select id="Raza" name="Raza" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Selecciones Raza</option>
                                                    <option value="Afrocolombiano"{{ $datosEmpleados && $datosEmpleados->Raza=='Afrocolombiano' ?'selected':'' }}>Afrocolombiano</option>
                                                    <option value="Indigina"{{ $datosEmpleados && $datosEmpleados->Raza=='Indigina' ?'selected':'' }}>Indigina</option>
                                                    <option value="Gitanos"{{ $datosEmpleados && $datosEmpleados->Raza=='Gitanos' ?'selected':'' }}>Gitanos</option>
                                                    <option value="Mestizos"{{ $datosEmpleados && $datosEmpleados->Raza=='Mestizos' ?'selected':'' }}>Mestizo</option>
                                                    <option value="Blancos"{{ $datosEmpleados && $datosEmpleados->Raza=='Blancos' ?'selected':'' }}>Blanco</option>
                                                    <option value="Mulato"{{ $datosEmpleados && $datosEmpleados->Raza=='Mulato' ?'selected':'' }}>Mulato</option>
                                                    <option value="Criollo"{{ $datosEmpleados && $datosEmpleados->Raza=='Criollo' ?'selected':'' }}>Criollo</option>
                                                    <option value="Negro"{{ $datosEmpleados && $datosEmpleados->Raza=='Negro' ?'selected':'' }}>Negro</option>
                                                    <option value="Indio"{{ $datosEmpleados && $datosEmpleados->Raza=='Indio' ?'selected':'' }}>Indio</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Estrato_Social!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Estrato Social') }}</label>
                                                <select id="Estrato_Social" name="Estrato_Social" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Estrato Social</option>
                                                    <option value="1"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='1' ?'selected':'' }}>1</option>
                                                    <option value="2"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='2' ?'selected':'' }}>2</option>
                                                    <option value="3"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='3' ?'selected':'' }}>3</option>
                                                    <option value="4"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='4' ?'selected':'' }}>4</option>
                                                    <option value="5"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='5' ?'selected':'' }}>5</option>
                                                    <option value="6"{{ $datosEmpleados && $datosEmpleados->Estrato_Social=='6' ?'selected':'' }}>6</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2  {!! ($datosEmpleados && $datosEmpleados->Enfermedad_Comun!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Enfermedad Comun') }}</label>
                                                <select id="Enfermedad_Comun" name="Enfermedad_Comun" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">En. Comun</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Enfermedad_Comun=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Enfermedad_Comun=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>


                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-2  {!! ($datosEmpleados && $datosEmpleados->At_Level!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('At Level') }}</label>
                                                <select id="At_Level" name="At_Level" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">At. Level</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->At_Level=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->At_Level=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Intervencion_Xat!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Intervencion Quirurjica XAT') }}</label>
                                                <select id="Intervencion_Xat" name="Intervencion_Xat" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Intervencion X. at</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Intervencion_Xat=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Intervencion_Xat=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->At_Grave!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('At Grave') }}</label>
                                                <select id="At_Grave" name="At_Grave" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">At. Grave</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->At_Grave=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->At_Grave=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>


                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Comida_Dia!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Consume 5 comidas al Dia') }}</label>
                                                <select id="Comida_Dia" name="Comida_Dia" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">5 Comida al Dia</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Comida_Dia=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Comida_Dia=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->fuma!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Fuma') }}</label>
                                                <select id="fuma" name="fuma" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Fuma???</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->fuma=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->fuma=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Vegetales!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Consume vegetales') }}</label>
                                                <select id="Vegetales" name="Vegetales" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Vegetales</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Vegetales=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Vegetales=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Carbohidratos!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Consume Carbohidratos') }}</label>
                                                <select id="Carbohidratos" name="Carbohidratos" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Carbohidratos</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Carbohidratos=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Carbohidratos=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Hidratacion!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Se hidrata') }}</label>
                                                <select id="Hidratacion" name="Hidratacion" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Hidratacion</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Hidratacion=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Hidratacion=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Deporte!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Realiza deporte') }}</label>
                                                <select id="Deporte" name="Deporte" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Deporte</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Deporte=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Deporte=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-4 {!! ($datosEmpleados && $datosEmpleados->cumple_horario_comidas!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Cumple con el horario comidas') }}</label>
                                                <select id="cumple_horario_comidas" name="cumple_horario_comidas" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">horario comidas</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->cumple_horario_comidas=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->cumple_horario_comidas=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Hobbies!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Tiene hobbies') }}</label>
                                                <select id="Hobbies" name="Hobbies" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Hobbies</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->Hobbies=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->Hobbies=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->sustancias_psicoactivas!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Sustancias psicoactivas') }}</label>
                                                <select id="sustancias_psicoactivas" name="sustancias_psicoactivas" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">sustancias psicoactivas</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->sustancias_psicoactivas=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->sustancias_psicoactivas=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->lavado_manos!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Lavado Frecuente Manos') }}</label>
                                                <select id="lavado_manos" name="lavado_manos" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">lavado manos???</option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->lavado_manos=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->lavado_manos=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->consume_alcohol!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Consume alcohol') }}</label>
                                                <select id="consume_alcohol" name="consume_alcohol" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled"><i>Consume alcohol???</i>></option>
                                                    <option value="Si" {{ $datosEmpleados && $datosEmpleados->consume_alcohol=='Si' ?'selected':'' }}>Si</option>
                                                    <option value="No" {{ $datosEmpleados && $datosEmpleados->consume_alcohol=='No' ?'selected':'' }}>No</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->restriccion!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Resticcion') }}</label>
                                                <select id="restriccion" name="restriccion" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Resticcion</option>
                                                    <option value="1"{{ $datosEmpleados && $datosEmpleados->restriccion=='1' ?'selected':'' }}>1</option>
                                                    <option value="2"{{ $datosEmpleados && $datosEmpleados->restriccion=='2' ?'selected':'' }}>2</option>
                                                    <option value="3"{{ $datosEmpleados && $datosEmpleados->restriccion=='3' ?'selected':'' }}>3</option>
                                                    <option value="4"{{ $datosEmpleados && $datosEmpleados->restriccion=='4' ?'selected':'' }}>4</option>
                                                    <option value="5"{{ $datosEmpleados && $datosEmpleados->restriccion=='5' ?'selected':'' }}>5</option>
                                                    <option value="6"{{ $datosEmpleados && $datosEmpleados->restriccion=='6' ?'selected':'' }}>6</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Nivel_Sisben!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Nivel Sisben') }}</label>
                                                <select id="Nivel_Sisben" name="Nivel_Sisben" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Nivel Sisben</option>
                                                    <option value="1" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='1' ?'selected':'' }}>1</option>
                                                    <option value="2" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='2' ?'selected':'' }}>2</option>
                                                    <option value="3" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='3' ?'selected':'' }}>3</option>
                                                    <option value="4" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='4' ?'selected':'' }}>4</option>
                                                    <option value="5" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='5' ?'selected':'' }}>5</option>
                                                    <option value="6" {{ $datosEmpleados && $datosEmpleados->Nivel_Sisben=='6' ?'selected':'' }}>6</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->id_arl!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('ARL') }}</label>
                                                <select id="id_arl" name="id_arl" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione ARL</option>
                                                    @foreach( $arl  as $arl)
                                                        <option Value="{{ $arl->id }}" {{ ($datosEmpleados && $datosEmpleados->id_arl== $arl->id)?'selected':''}}>{{ $arl->arl }}</option>
                                                    @endforeach

                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Rodamiento!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Auxilio Rodamiento') }}</label>
                                                <input id="Rodamiento" type="text" class="form-control labelform" name="Rodamiento" value="{{ $datosEmpleados && $datosEmpleados->Rodamiento?$datosEmpleados->Rodamiento:'' }}">
                                            </div>

                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_Medio_Transporte!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Medio Transporte') }}</label>
                                                <select id="id_Medio_Transporte" name="id_Medio_Transporte" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Transporte</option>
                                                    @foreach( $transporte  as $traspor)
                                                        <option Value="{{ $traspor->id }}" {{ ($datosEmpleados && $datosEmpleados->id_Medio_Transporte== $traspor->id)?'selected':''}}>{{$traspor->Tipo_Trasporte}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Ultima_Fecha_Ingreso!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Ultima Fecha Ingreso') }}</label>
                                                <div class="form-group">
                                                    <div class='input-group date' id='Ultima_Fecha_Ingreso'>
                                                        <input type='date' class="form-control labelform" name="Ultima_Fecha_Ingreso" value="{{$datosEmpleados &&  $datosEmpleados->Ultima_Fecha_Ingreso?$datosEmpleados->Ultima_Fecha_Ingreso:'' }}"/>
                                                        <span class="input-group-addon  labelform">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group col-md-3 {!!($datosEmpleados && $datosEmpleados->Fecha_retiro !='')?'':'has-error'!!} ">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Fecha Retiro') }}</label>
                                                <div class="form-group ">
                                                    <div class='input-group date' id='Fecha_retiro'>
                                                        <input type='date' class="form-control labelform" name="Fecha_retiro" value="{{$datosEmpleados &&  $datosEmpleados->Fecha_retiro?$datosEmpleados->Fecha_retiro:''}} "/>
                                                        <span class="input-group-addon  labelform">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class='form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->Fecha_Cambio_Contrato!='')?'':'has-error' !!}'>
                                                <label for="name" class="col-form-label text-md-right">{{ __('Fecha Cambio Contrato') }}</label>
                                                <div class="form-group">
                                                    <div class='input-group date' id='Fecha_Cambio_Contrato'>
                                                        <input type='date' name="Fecha_Cambio_Contrato" class="form-control labelform" value="{{$datosEmpleados && $datosEmpleados->Fecha_Cambio_Contrato?$datosEmpleados->Fecha_Cambio_Contrato:'' }}"/>
                                                        <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar "></span>
                                            </span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-row">

                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Frecuencia!='')?'':'has-error' !!}">
                                                <label for="Frecuencia" class="col-form-label text-md-right">{{ __('Frecuencia') }}</label>
                                                <input id="Frecuencia" disabled type="number" min="0" class="form-control labelform" name="Frecuencia" value="{{ $datosEmpleados && $datosEmpleados->Frecuencia?$datosEmpleados->Frecuencia:'' }}">
                                            </div>

                                            <div class="form-group col-md-2 ">
                                                <label for="Meses_empresa" class="col-form-label text-md-right">{{ __('Meses empresa') }}</label>
                                                <input id="Meses_empresa" type="number" min="0" class="form-control labelform" name="Meses_empresa" disabled value="{{$diferencia}}">

                                            </div>


                                            <div class="form-group col-md-2 {!! ($datosEmpleados && $datosEmpleados->Tipo_Vivienda!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Tipo Vivienda') }}</label>
                                                <select id="Tipo_Vivienda" name="Tipo_Vivienda" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Vivienda</option>
                                                    <option value="Arriendo" {{ $datosEmpleados && $datosEmpleados->Tipo_Vivienda=='Arriendo' ?'selected':'' }}>Arriendo</option>
                                                    <option value="Familiar" {{ $datosEmpleados && $datosEmpleados->Tipo_Vivienda=='Familiar'?'selected':'' }}>Familiar</option>
                                                    <option value="Propia" {{ $datosEmpleados && $datosEmpleados->Tipo_Vivienda=='Propia' ?'selected':'' }}>Propia</option>
                                                </select>

                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->motivo_retiro!='')?'':'has-error' !!}">
                                                <label for="name" class="col-form-label text-md-right">{{ __('Motivo Retiro') }}</label>
                                                <input id="motivo_retiro" type="text" class="form-control labelform" name="motivo_retiro" value="{{ $datosEmpleados && $datosEmpleados->motivo_retiro?$datosEmpleados->motivo_retiro:'' }}">
                                            </div>

                                            <div class="form-group col-md-3 {!! ($datosEmpleados && $datosEmpleados->id_CentroCosto!='')?'':'has-error' !!}">
                                                <label for="id_CentroCosto" class="col-form-label text-md-right">{{ __('Centro Costos') }}</label>
                                                <select id="id_CentroCosto" name="id_CentroCosto" class="form-control labelform">
                                                    <option selected="true" value="" disabled="disabled">Seleccione Uno..</option>
                                                    @foreach($costosSers   as $costosSer )
                                                        <option Value="{{ $costosSer->id }}" {{ ($datosEmpleados && $datosEmpleados->id_CentroCosto== $costosSer->id)?'selected':''}}>{{$costosSer->CentroCosto}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        @can('ActualizarFichaTecnicaEmpleado')
                                            <div class="col-lg-12">
                                                <div class="form-group col-md-5"></div>
                                                <div class="form-group col-md-2 footer">
                                                    <div class="col-lg-10"></div>
                                                    <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                                                </div>
                                                <div class="form-group col-md-5"></div>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <div id="UpdateImg" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <form id="UpdateImg" method="POST" action="{{ route('UpdateImg') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Actualizar Foto Empleado</h4>
                        </div>
                        <div class="modal-body">

                            <div class="col-lg-12">
                                <div class="form-group col-md-12">
                                    <label for="">Cargar Foto </label>
                                    <input type="file" id="file" data-max-size="32154" class="form-control" name="imgup" id="imgup" required>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $empleado->id }}" name="id_Empleado">
                            <input type="hidden" name="Numero_Documento" value="{{ $empleado->Numero_Documento}}">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Actualizar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    @endcan

    <script>

        $(document).ready(function () {
            let token = $('#token').val();
            $('#CrearFichaTecnica').submit(function (event) {
                event.preventDefault();
                let dataString = $('#CrearFichaTecnica').serialize();
                let token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: dataString,//datos que envio
                    url: "{{ route('CrearFichaTecnica')}}",
                    //url: '/EmpleadosCreate/fichatecnica',
                    type: 'post',

                    success: function (Result) {//qsi la respuesa esta bien la guarde en result
                        if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                            iziToast.success({
                                //timeout: 20000,
                                title: 'Perfecto',
                                position: 'center',
                                message: 'Guardado Exitosamente',
                            });
                            $("#CrearFichaTecnica")[0].reset();//limpio formulario
                            window.location.href = '/RecursosHumanos/EmpleadossubMenu';

                        } else {
                            alert('error');

                        }
                    }
                });
            });


            $("#id_area").change(function () {
               // alert('a');
                elegido = $(this).val();
                token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '{{ route('Area') }}',
                    data: {Area: elegido},//este para que lo uso??? son los datos que esta enviando
                    type: 'post',
                    success: function (Result) {
                        // console.log(Result);
                        $("#id_Sub_Area").empty().selectpicker('destroy');

                        $.each(Result.Data, function (i, item) {
                            $("#id_Sub_Area").append('<option value="' + item.id + '">' + item.Sub_Area + '</option>');
                            /*aqui si?*/
                        });
                        $('#id_Sub_Area').selectpicker({
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
            $("#id_Sub_Area").change(function () {
                //alert('a');
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
        });

        @if(session()->has('imgupdate'))
        $(document).ready(function () {
            //location.reload();
        });
        @endif

        $('input[id="imgup"]').on('change', function () {
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
        });
    </script>
@endsection
