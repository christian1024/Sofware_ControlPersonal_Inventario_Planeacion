@extends('layouts.Principal')
@section('contenidoPrincipal')

    @can('Vistavariedades')

        <div class="card row">
            <h5 class="card-header">Variedades</h5>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @can('VerGeneros')
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Generos" onclick="ocultaDivModificaGenero()"><span>Generos</span></a>
                        </li>
                    @endcan
                    @can('VerEspecies')
                        <li class="nav-item">
                            <a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Especies" onclick="ocultaDivModificaGenero()"><span>Especies</span></a>
                        </li>
                    @endcan
                    @can('VerVariedades')
                        <li class="nav-item">
                            <a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Variedades"><span>Variedades</span></a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content" id="myTabContent">
                    {{--GENEROS--}}
                    <div id="Generos" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                        <div id="GenerosActivosTabs" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-3"></div>
                                <div class="col-9" style="margin-top:10px;display: flex;   justify-content: center;   align-items: center; background-color: rgba(106, 106, 131, 0.13)">
                                    <h5>LISTA DE GENEROS</h5>
                                </div>
                            </div>
                            <div class="row">
                                {{--************************ CONTENEDOR DE CREAR Y NMODIFICAR GENERO *************************--}}
                                <div class="col-3" style="background-color: #0a0a0a12;">
                                    <div>
                                        <h3>
                                            @can('CrearGeneros')
                                                <a style="display: flex;   justify-content: center;   align-items: center;" id="formulariocreargenerotitle">Crear Genero</a>
                                            @endcan

                                            @can('ActualizarGeneros')
                                                <a style="display: flex; justify-content: center;   align-items: center; display: none" id="formulariomodificargenerotitle">Modificar Genero</a>
                                            @endcan
                                        </h3>
                                    </div>

                                    {{--****************** FORMULARIO PARA CREAR GENERO ****************************--}}
                                    @can('CrearGeneros')
                                        <div id="formulariocreargenero">
                                            <form id="CreateGenero" method="POST" action="{{ route('CreateGenero') }}">
                                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                                <div class="col-lg-12" style="">
                                                    <div class="col-lg-12" style="">

                                                        <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                                                        <input id="Nombre_Genero" type="search" class="form-control labelform {{ $errors->has('Nombre_Genero') ? ' is-invalid' : '' }}" name="Nombre_Genero" value="{{ old('Nombre_Genero') }}" autofocus required>
                                                        @if ($errors->has('Nombre_Especie'))
                                                            <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Nombre_Genero') }}</strong>
                                                    </span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" style="margin-top: 10px" class="btn btn-success btn-lg btn-block"> {{ __('Guardar') }} </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endcan
                                    {{--****************** FORMULARIO PARA MODIFICAR GENERO ****************************--}}
                                    @can('ActualizarGeneros')
                                        <div id="formulariomodificargenero" class="fadeIn" style="display: none">
                                            <form id="UpdateGenero" method="POST" action="{{ route('UpdateGenero') }}">
                                                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                                <input type="hidden" id="IdGeneroUpdate" name="IdGeneroUpdate">
                                                <div class="col-lg-12" style="">
                                                    <div class="col-lg-12" style="">

                                                        <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                                                        <input id="Nombre_Genero_m" type="search" class="form-control col-lg-auto labelform {{ $errors->has('Nombre_Genero') ? ' is-invalid' : '' }}" name="Nombre_Genero_m" value="{{ old('Nombre_Genero') }}" autofocus required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" style="margin-top: 10px" id="GuardarOcultar" class="btn btn-success btn-lg btn-block"> {{ __('Guardar') }} </button>
                                                    <button type="button" style="margin-top: 10px" onclick="ocultaDivModificaGenero()" class="btn btn-danger btn-lg btn-block"> {{ __('Cancelar') }} </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endcan
                                </div>
                                {{--****************** TABLA GENEROS ACTIVOS *************************************************--}}
                                <div class="col-9">
                                    <div class="table">
                                        <table id="GenerosActivosTabla" width="100%" {{--class="table table-hover display nowrap col-lg-12 cell-border"--}}>
                                            <thead>
                                            <tr>
                                                <th>Nombre Genero</th>
                                                <th>Codigo Integracion</th>
                                                <th>Estado</th>
                                                <th>Accion</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach( $GenerosTables as $Genero)
                                                <tr>
                                                    <th>{{ $Genero->NombreGenero }}</th>
                                                    <th>{{ $Genero->CodigoIntegracionGenero }}</th>
                                                    @if( $Genero->Flag_Activo==='1')
                                                        <th>
                                                            <span>Activo</span>
                                                        </th>
                                                    @else
                                                        <th>
                                                            <span>Inactivo</span>
                                                        </th>
                                                    @endif


                                                    @if( $Genero->Flag_Activo==='1')
                                                        <th>
                                                            @can('ActualizarGeneros')
                                                                <a class="btn btn-primary btn-circle btn-sm" onclick="UpdateGenero('{{$Genero->id}}','{{$Genero->NombreGenero}}')" id="parametro" style="position: center" title="Ficha Tecnica"><i class="fa fa-edit"></i> </a>
                                                            @endcan
                                                            @can('InactivarGeneros')
                                                                <a href="{{ route('InactivarGenero',['CodigoIntegracionGenero'=>encrypt($Genero->id)]) }}" id="Inactivar" methods="PUT" class="btn btn-danger btn-circle btn-sm" title="Eliminar" style="position: center"><i class="fa fa-trash"></i> </a>
                                                            @endcan
                                                        </th>
                                                    @else
                                                        <th>
                                                            @can('ActivarGeneros')
                                                                <a href="{{ route('ActivarGenero',['CodigoIntegracionGenero'=>encrypt($Genero->id)]) }}" id="ACTIVAR" methods="PUT" class="btn btn-success btn-circle btn-sm" title="Activar Genero" style="position: center"><i class="fa fa-check"></i> </a>
                                                            @endcan
                                                        </th>
                                                    @endif
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--ESPECIES--}}
                    <div id="Especies" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-lg-12 expandUp" style="margin-top:10px;display: flex;   justify-content: center;   align-items: center; background-color: rgba(106, 106, 131, 0.13)">
                                <h5>LISTA DE ESPECIES</h5>
                                {{--<input type="checkbox" checked data-toggle="toggle">--}}

                            </div>
                            <div>
                                @can('CrearEspecies')
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#NuevaEspecie">Crear Especie</button>
                                @endcan
                            </div>
                            <div class="col-lg-12" style="margin-top: 15PX">
                                <div class="table" style="margin-top: 5px;">
                                    <table id="TablaEspeciesActivas" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Nombre Especie</th>
                                            <th>Nombre Genero</th>
                                            <th>Estado</th>
                                            <th> Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($EspeciesTable as $Especie)
                                            <tr>
                                                <td>{{ $Especie->NombreEspecie }}</td>
                                                <td>{{ $Especie->NombreGenero }}</td>
                                                @if( $Especie->Flag_Activo==='1')
                                                    <th>
                                                        <span>Activa</span>
                                                    </th>
                                                @else
                                                    <th>
                                                        <span>Inactiva</span>
                                                    </th>
                                                @endif
                                                @if( $Especie->Flag_Activo==='1')
                                                    <th>
                                                        @can('InactivarEspecies')
                                                            <a href="{{ route('InactivarEspecie',['id'=>encrypt($Especie->id)]) }}" type="button" class="btn btn-danger btn-circle btn-sm" data-placement="left" data-toggle="tooltip" data-html="true" title="Inactivar"><i class="fa fa-trash"></i></a>
                                                        @endcan
                                                        @can('ActualizarEspecies')
                                                            <a class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#ModificarEspecie" data-whatever="{{ json_encode($Especie) }}">
                                                                <i data-toggle="tooltip" data-placement="left" title="Editar Especie" class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                    </th>
                                                @else
                                                    <th>
                                                        @can('ActivarEspecies')
                                                            <a href="{{ route('ActivarEspecie',['id'=>encrypt($Especie->id)]) }}" type="button" class="btn btn-success btn-circle btn-sm" title="Activar Especie"><i class="fa fa-check"></i></a>
                                                        @endcan
                                                    </th>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{--VARIEDADES--}}
                    <div id="Variedades" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                        <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                            <div class="col-lg-12 expandUp" style="margin-top:10px;display: flex;   justify-content: center;   align-items: center; background-color: rgba(106, 106, 131, 0.13)">
                                <h5>LISTA DE VARIEDADES</h5>
                                {{--<input type="checkbox" checked data-toggle="toggle">--}}

                            </div>
                            <div>
                                @can('CrearVariedades')
                                    <div>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#NuevaVariedad">Crear Variedad</button>
                                    </div>
                                @endcan
                            </div>
                            <div class="col-lg-12" style="margin-top: 15PX">
                                <div class="table" style="margin-top: 5px;">
                                    <table id="TablaEspeciesActivas" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Variedad</th>
                                            <th>Especie</th>
                                            <th>Genero</th>
                                            <th>Estado</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Variedades as $VariedadesActiva)
                                            <tr>
                                                <td>{{ $VariedadesActiva->Codigo }}</td>
                                                <td>{{ $VariedadesActiva->Nombre_Variedad }}</td>
                                                <td>{{ $VariedadesActiva->NombreEspecie }}</td>
                                                <td>{{ $VariedadesActiva->NombreGenero }}</td>
                                                @if ($VariedadesActiva->Flag_Activo==='1')
                                                    <th>
                                                        <span>Activa</span>
                                                    </th>
                                                @else
                                                    <th>
                                                        <span>Inactiva</span>
                                                    </th>
                                                @endif
                                                @if( $VariedadesActiva->Flag_Activo==='1')
                                                    <th align="center">
                                                        @can('InactivarVariedades')
                                                            <a href="{{ route('InactivarVariedad',['id'=>encrypt($VariedadesActiva->id)]) }}" type="button" class="btn btn-danger btn-circle btn-sm" data-placement="left" data-toggle="tooltip" data-html="true" title="Inactivar"><i class="fa fa-trash"></i></a>
                                                        @endcan
                                                        @can('ActualizarVariedades')
                                                            <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#ModificarVariedad" data-whatever="{{ json_encode($VariedadesActiva) }}">
                                                                <i data-toggle="tooltip" data-placement="left" title="Editar Variedad" class="fa fa-edit"></i>
                                                            </button>
                                                        @endcan
                                                    </th>
                                                @else
                                                    <td align="center">
                                                        @can('ActivarVariedades')
                                                            <a href="{{ route('ActivarVariedad',['id'=>encrypt($VariedadesActiva->id)]) }}" type="button" class="btn btn-success btn-circle btn-sm" data-placement="left" data-toggle="tooltip" data-html="true" title="Activar"><i class="fa fa-check"></i></a>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endcan

    <!--Inicia modal crear especie Especie -->
    @can('CrearEspecies')
        <div class="modal fade" id="NuevaEspecie" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="" style="color: #0b97c4"></i> Nueva Especie</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('CreatenewEspecie') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="">

                                <div class="row">
                                    <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Especie') }}</label>
                                    <input id="Nombre_Especie" type="text" class="form-control labelform {{ $errors->has('Nombre_Especie') ? ' is-invalid' : '' }}" name="Nombre_Especie" value="{{ old('Nombre_Especie') }}" autofocus required>
                                    @if ($errors->has('Nombre_Especie'))
                                        <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Nombre_Especie') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="row">

                                    <label for="IdGenero" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                                    <select id="IdGenero" class="form-control labelform" name="IdGenero" required>
                                        @foreach($Generos as $Genero)
                                            <option style="display: flex;   justify-content: center;   align-items: center; " value="{{ $Genero->id }}">  {{$Genero->NombreGenero}} </option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('ActualizarEspecies')
        <div class="modal fade" id="ModificarEspecie" role="dialog">
            <div class="modal-dialog modal-sm">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="" style="color: #0b97c4"></i> Actualizar Especie</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('updateespecie') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <input type="hidden" name="CodigoIntegracionEspecie" id="CodigoIntegracionEspecie">
                            <div class="">
                                <div class="row">
                                    <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Especie') }}</label>
                                    <input type="text" class="form-control labelform {{ $errors->has('Nombre_Especie') ? ' is-invalid' : '' }}" name="Nombre_EspecieMo" id="Nombre_EspecieMo" value="{{ old('Nombre_Especie') }}" autofocus required>
                                    @if ($errors->has('Nombre_Especie'))
                                        <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Nombre_Especie') }}</strong>
                                                    </span>
                                    @endif
                                </div>
                                <div class="row">
                                    <label for="IdGenero" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                                    <select id="IdGenero" class="form-control labelform" name="IdGenero" required>
                                        @foreach($Generos as $Genero)
                                            <option style="display: flex;   justify-content: center;   align-items: center; " value="{{ $Genero->id }}">  {{$Genero->NombreGenero}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('CrearVariedades')
        <div class="modal fade" id="NuevaVariedad" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="" style="color: #0b97c4"></i> Nueva Variedad</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="formCrearVariedad" method="get" action="{{ route('VariedadessubMenu') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="">
                                <div class="row">
                                    <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Variedad') }}</label>
                                    <input id="Nombre_Variedad" type="text" autocomplete="off" class="form-control labelform {{ $errors->has('Nombre_Variedad') ? ' is-invalid' : '' }}" name="Nombre_Variedad" value="{{ old('Nombre_Variedad') }}" autofocus required>
                                    @if ($errors->has('Nombre_Variedad'))
                                        <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Nombre_Variedad') }}</strong>
                                                    </span>
                                    @endif

                                    <label for="name" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Codigo') }}</label>
                                    <input id="Codigo" type="text" maxlength="7" class="form-control labelform {{ $errors->has('Codigo') ? ' is-invalid' : '' }}" name="Codigo" value="{{ old('Codigo') }}" autofocus required>
                                    @if ($errors->has('Nombre_Especie'))
                                        <span class="invalid-feedback">
                                             <strong>{{ $errors->first('Nombre_Especie') }}</strong>
                                                    </span>
                                    @endif


                                    <label for="IdGeneros" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Genero') }}</label>
                                    <select id="IdGeneros" class="form-control labelform" name="IdGeneros" required>
                                        <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>
                                        @foreach($Generos as $Genero)
                                            <option style="display: flex;   justify-content: center;   align-items: center; " value="{{ $Genero->id }}">  {{$Genero->NombreGenero}} </option>
                                        @endforeach
                                    </select>


                                    <label for="IDEspecieOption" style="display: flex;   justify-content: center;   align-items: center; " class="col-form-label text-md-right">{{ __('Nombre Especie') }}</label>
                                    <select id="IDEspecieOption" class="form-control labelform" name="IDEspecieOption" required>
                                        <option selected="true" value="" disabled="disabled">Seleccione Uno.....</option>

                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="GuardarVariedades" class="btn btn-primary">Guardar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    <script>
        $(document).ready(function () {
            let token = $('#token').val();
            $('#GenerosActivosTabla, #TablaEspeciesActivas, #TableVariedadesActivas').DataTable({
                dom: "Bfrtip",
                paging: true,
                "language": {
                    "search": "Buscar:",
                    "info": 'Total Activos _TOTAL_',// "Mostrando Página False, Registros Inactivos _TOTAL_",
                    "paginate": {
                        "first": 'Primero',
                        "last": 'Ultimo',
                        "next": 'Siguiente',
                        "previous": 'Anterior',

                    }
                },
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                       /* exportOptions: {
                            columns: [0, 1]
                        }*/
                    },
                ],
            });
        });

        function UpdateGenero(id, nombre) {

            $('#formulariomodificargenero').show(); //muestro mediante id
            $('#formulariomodificargenerotitle').show(); //muestro mediante id
            $('#formulariocreargenero').hide(); //muestro mediante id
            $('#formulariocreargenerotitle').hide(); //muestro mediante id
            $('#Nombre_Genero_m').val(nombre);
            $('#IdGeneroUpdate').val(id);
        }

        function InactivarVariedad(id) {
            /*console.log(id);*/
            $(document).ready(function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr["error"]("Variedad Inactiva");
            });
            window.location.href = '/Inactivar/' + btoa(id) + '/Variedad';
        }

        function ActivarVariedad(id) {
            /*console.log(id);*/
            $(document).ready(function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr["success"]("Variedad Activa");
            });
            window.location.href = '/Activar/' + btoa(id) + '/Variedad';
        }

        function ActivarEspecie(id) {
            /*console.log(id);*/
            $(document).ready(function () {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-center",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr["success"]("Especie Activa");

            });
            window.location.href = '/Activar/' + btoa(id) + '/Especie';
        }

        function ocultaDivModificaGenero() {

            $('#formulariomodificargenero').hide(); //muestro mediante id
            $('#formulariomodificargenerotitle').hide(); //muestro mediante id
            $('#formulariocreargenero').show(); //muestro mediante id
            $('#formulariocreargenerotitle').show(); //muestro mediante id
        }

        $('#IdGeneros').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Genero/' + this.value + '/Especie',
                success: function (Result) {
                    // console.log(Result.id);
                    $("#IDEspecieOption").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEspecieOption").append('<option value="' + item.id + '">' + item.NombreEspecie + '</option>');
                    });
                    $('#IDEspecieOption').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#ModificarVariedad').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
           // console.log(data);
            var modal = $(this);
            // modal.find('.modal-title').text('New message to ' + recipient);
            //modal.find('.modal-body input').val(recipient)
            modal.find('#Nombre_VariedadM').val(data.Nombre_Variedad);
            modal.find('#CodigoM').val(data.Codigo);
            modal.find('#CodigoMo').val(data.Codigo);
            modal.find('#IdGenerosM').val(data.idGenero);
            modal.find('#IDEspecie').html('<option value="' + data.idEspecie + '">' + data.NombreEspecie + '</option>');
            //modal.find('#IDEspecie').val(data.idEspecie);
        });

        $('#ModificarEspecie').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            //console.log(data);
            //console.log(data.CodigoIntegracionEspecie);
            var modal = $(this);
            // modal.find('.modal-title').text('New message to ' + recipient);
            //modal.find('.modal-body input').val(recipient)
            modal.find('#Nombre_EspecieMo').val(data.NombreEspecie);
            modal.find('#CodigoIntegracionEspecie').val(data.CodigoIntegracionEspecie);

        });

        $('#IdGenerosM').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Genero/' + this.value + '/Especie',
                success: function (Result) {
                    console.log(Result);
                    $("#IDEspecie").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEspecie").append('<option value="' + item.id + '">' + item.NombreEspecie + '</option>');
                    });
                    $('#IDEspecie').selectpicker({
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

        $('#formCrearVariedad').submit(function (event) {
            event.preventDefault();
            let token = $('#token').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},//toekn
                data: $('#formCrearVariedad').serialize(),//datos que envio
                //url: '/LoadInventoryEntry',//ruto post
                url: '{{ route('createVariedad') }}',//ruto post
                type: 'post',
                success: function (Result) {
                    if (Result.data === 1) {
                        $("#NuevaVariedad").modal('hide');//ocultamos el modal
                        $('#formCrearVariedad').trigger("reset");
                        //$('#NuevaVariedad').remove();//eliminamos el backdrop del modal
                    } else {
                        iziToast.error({
                            //timeout: 20000,
                            title: 'Error',
                            position: 'center',
                            message: 'Ya hay datos existentes',
                        });
                    }
                }
            });
            return true;
        });

        @if(session()->has('InactivarEspecie'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Se inactivo la especie',
            });

        });
        @endif

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

        @if(session()->has('creado'))
        $(document).ready(function () {

            iziToast.success({
                //timeout: 20000,
                title: 'success',
                position: 'center',
                message: 'Creado Correctamente',
            });
            toastr["success"]("Creado Correctamente");
            $('ModificarVariedad').modal('hide');
            return true;
        });
        @endif

        @if(session()->has('Inactivo'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Inactivo Correctamente',
            });
        });
        @endif

        @if(session()->has('Activo'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Bien',
                position: 'center',
                message: 'Activado Correctamente',
            });
        });
        @endif

        @if(session()->has('existe'))
        $(document).ready(function () {
            iziToast.warning({
                //timeout: 20000,
                title: 'Revisar',
                message: 'YA EXISTE EN NUESTRA BASE DE DATOS',
            });
        });
        @endif
    </script>

@endsection
@include('Modal.ModalModificarVariedad')
