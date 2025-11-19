@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row"{{-- style="margin-top:10px;"--}}>
        <div class="col-md-12">
            <div>
                <h3>Tablas Maestras</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @can('VistaTabClientes')
                        <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Clientes"><span>Clientes</span></a></li>
                    @endcan
                    @can('VistaTabContenedores')
                        <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Contenedores"><span>Contenedores</span></a></li>
                    @endcan
                    @can('VistaTabCausales')
                        <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#CausalesDescarte"><span>Causales Descarte</span></a></li>
                    @endcan
                    @can('VistaTabMedios')
                        <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Medios"><span>Medios</span></a></li>
                    @endcan
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">

                @can('VerTablaClientes')
                    <div id="Clientes" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">

                        <div class="col-lg-12 box box-body spaceTap">

                            <div>
                                @can('CrearCliente')
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CrearCliente">Crear Cliente</button>
                                @endcan
                            </div>
                            <div class="col-12">
                                <div class="table table table-responsive">

                                    <table id="TablaClientes" class=" table-hover display nowrap col-lg-12 celltable-border">
                                        <thead>
                                        <tr>
                                            <th>Nombre Cliente</th>
                                            <th>Indicativo</th>
                                            <th>Nit</th>
                                            <th>Tipo</th>
                                            <th>Estado</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($clientes as $Cliente)
                                            <tr>
                                                <td>{{ $Cliente->Nombre }}</td>
                                                <td>{{ $Cliente->Indicativo }}</td>
                                                <td>{{ $Cliente->Nit }}</td>
                                                <td>{{ $Cliente->Tipo }}</td>

                                                @if($Cliente-> Flag_Activo==='1')
                                                    <td>Activo</td>
                                                @else
                                                    <td>Inactivo</td>
                                                @endif

                                                @if($Cliente-> Flag_Activo==='1')
                                                    <td>
                                                        @can('InactivarCliente')
                                                            <a class="btn btn-danger btn-circle btn-sm" href="{{ route('InactivarCliente',['id'=>encrypt($Cliente->id)]) }}"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Inactivar"></i></a>
                                                        @endcan
                                                        @can('ModificarCliente')
                                                            <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#ModificarClientes" data-whatever="{{ json_encode($Cliente) }}">
                                                                <i data-toggle="tooltip" data-placement="left" title="Modificar" class="fa fa-edit"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                @else
                                                    <td>
                                                        @can('ActivarCliente')
                                                            <a class="btn btn-success" href="{{ route('ActivarCliente',['id'=>encrypt($Cliente->id)]) }}">Activar</a>
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
                @endcan

                @can('VerTablaContenedores')
                    <div id="Contenedores" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">

                        <div id="Contenedorestabs" class="col-lg-12 box box-body spaceTap">
                            <div>
                                @can('CrearContenedores')
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CrearContenedor">Crear Contenedor</button>
                                @endcan
                            </div>
                            <div class="col-12">
                                <div class="table table table-responsive">

                                    <table id="TablaContenedores" width="100%" class="table table-hover display nowrap col-lg-12 cell-border">
                                        <thead>
                                        <tr>
                                            <th>Tipo Contenedor</th>
                                            <th>Cantidad Por Contendor</th>
                                            <th>Estado</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($TipoContenedores as $TipoContenedor)
                                            <tr>
                                                <td>{{ $TipoContenedor->TipoContenedor }}</td>
                                                <td>{{ $TipoContenedor->Cantidad }}</td>

                                                @if($TipoContenedor-> Flag_Activo==='1')
                                                    <td>Activo</td>
                                                @else
                                                    <td>Inactivo</td>
                                                @endif

                                                @if($TipoContenedor-> Flag_Activo==='1')
                                                    <td>
                                                        @can('InactivarContenedores')
                                                            <button class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="Inactivar"></i></button>
                                                        @endcan
                                                        @can('ModificarContenedores')
                                                            <button class="btn btn-primary btn-circle btn-sm" data-toggle="modal" data-target="#ModificarContenedor" data-whatever="{{ json_encode($TipoContenedor) }}">
                                                                <i data-toggle="tooltip" data-placement="left" title="Modificar" class="fa fa-edit"></i>
                                                            </button>
                                                        @endcan
                                                    </td>
                                                @else
                                                    <td>
                                                        @can('ActivarContenedores')
                                                            <button class="btn btn-success ">Activar</button>
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
                @endcan

                @can('VerTablaCausales')
                    <div id="CausalesDescarte" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">

                        <div id="CausalesDescarteTabs" class="col-lg-12 box box-body spaceTap">
                            <div class="col-12">
                                <div class="table">

                                    <table id="TablaCausalesDescarte" width="100%" class="table table-hover display nowrap col-lg-12 cell-border">
                                        <thead>
                                        <tr>
                                            <th>Causa Descarte</th>
                                            <th>Estado</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($causalesDescartes as $causalesDescarte)
                                            <tr>
                                                <td>{{ $causalesDescarte->CausalDescarte }}</td>

                                                @if($TipoContenedor-> Flag_Activo==='1')
                                                    <td>Activo</td>
                                                @else
                                                    <td>Inactivo</td>
                                                @endif

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                @endcan

                @can('VerTablaMedios')
                    <div id="Medios" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">

                        <div id="MediosTabs" class="col-lg-12 box box-body spaceTap">
                            <div class="col-12">
                                <div class="table">

                                    <table id="TablaTipoMedios" width="100%" class="table table-hover display nowrap col-lg-12 cell-border">
                                        <thead>
                                        <tr>
                                            <th>Tipo Medio</th>
                                            <th>Estado</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Medios as $Medio)
                                            <tr>
                                                <td>{{ $Medio->TipoMedio }}</td>

                                                @if($Medio-> Flag_Activo==='1')
                                                    <td>Activo</td>
                                                @else
                                                    <td>Inactivo</td>
                                                @endif

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                @endcan

            </div>
        </div>
        {{--Crear Cliente--}}
    </div>
    @can('CrearCliente')
        <div class="modal fade" id="CrearCliente" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header">

                        <h3 class="modal-title"><i class="fa fa-briefcase" style="font-size: 40px; color: #0b97c4"></i> Crear Cliente</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="newCliente" method="POST" action="{{ route('newCliente') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div class="row">

                                <div class="col-6">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Nombre Cliente') }}</label>
                                    <input id="NombreCliente" type="text" required="required" autocomplete="off" class="form-control labelform" name="NombreCliente">

                                    <label for="name" class="col-form-label text-md-right">{{ __('Indicativo') }}</label>
                                    <input id="Indicativo" type="text" maxlength="3" autocomplete="off" required="required" class="form-control labelform" name="Indicativo">


                                </div>
                                <div class="col-6">
                                    <label for="" class="col-form-label text-md-right">{{ __('Nit') }}</label>
                                    <input id="Nit" name="Nit" autocomplete="off" class="form-control labelform">


                                    <label for="id_Sub_AreaLab" class="col-form-label text-md-right">{{ __('Breeder/Cliente') }}</label>
                                    <select id="Tipo" name="Tipo" class="form-control labelform" required="required">
                                        <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                        <option value="Breeder">Breeder</option>
                                        <option value="Cliente">Cliente</option>

                                    </select>


                                </div>
                                <div class="modal-footer row">
                                    <button type="submit" class="btn btn-block btn-outline-success btn-lg"> {{ __('Guardar') }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{--Modificar Cliente--}}
    @can('ModificarCliente')
        <div class="modal fade" id="ModificarClientes" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-briefcase" style="font-size: 40px; color: #0b97c4"></i> Modificar Cliente</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{-- <form id="updatecliente" method="POST" action="{{ route('EmpleadosLaboratorio') }}">
                         <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">--}}
                    <div class="modal-body">
                        <form action="{{ route('updateCliente') }}" method="post">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div>

                                <div class="row">

                                    <div class="form-group col-9">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Nombre Cliente') }}</label>
                                        <input id="NombreClienteMod" type="text" class="form-control labelform" name="NombreClienteMod" autofocus>
                                    </div>

                                    <div class="form-group col-3">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Indicativo') }}</label>
                                        <input id="IndicativoMod" type="text" class="form-control labelform" name="IndicativoMod" autofocus>
                                    </div>

                                    <div class="form-group col-4">
                                        <label for="id_areaLab" class="col-form-label text-md-right">{{ __('Nit') }}</label>
                                        <input id="NitMod" name="NitMod" class="form-control labelform">

                                    </div>

                                    <div class="form-group col-4">
                                        <label for="id_Sub_AreaLab" class="col-form-label text-md-right">{{ __('Breeder/Cliente') }}</label>
                                        <input id="TipoMod" type="text" disabled class="form-control labelform" name="TipoMod" autofocus>
                                    </div>

                                </div>

                                <input type="hidden" name="idCliente" id="idCliente">

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{--Crear Contenedor--}}
    @can('CrearContenedores')
        <div class="modal fade" id="CrearContenedor" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-flask" style="font-size: 40px; color: #0b97c4"></i> Crear Contenedor</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>

                    </div>

                    <div class="modal-body">
                        <form id="newContenedor" method="POST" action="{{ route('newContenedor') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div>

                                <div class="row">


                                    <label for="name" class="col-form-label text-md-right">{{ __('Tipo Contenedor') }}</label>
                                    <input id="TipoContenedor" type="text" required="required" autocomplete="off" class="form-control labelform" name="TipoContenedor">

                                    <label for="name" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                    <input id="CantidadCont" type="number" autocomplete="off" max="35" required="required" class="form-control labelform" name="CantidadCont">

                                </div>
                                <div class="modal-footer">

                                    <div class="col-lg-10"></div>
                                    <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan
    {{--Modificar Contenedor--}}
    @can('ModificarContenedores')
        <div class="modal fade" id="ModificarContenedor" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content ">
                    <div class="modal-header">

                        <h3 class="modal-title"><i class="fa fa-flask" style="font-size: 40px; color: #0b97c4"></i> Modificar Contenedor</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateContenedor" method="POST" action="{{ route('updateContenedor') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token">
                            <div>

                                <div class="col-lg-12">

                                    <div class="form-group">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Tipo Contenedor') }}</label>
                                        <input id="TipoContenedorMod" type="text" required="required" autocomplete="off" class="form-control labelform" name="TipoContenedorMod">
                                    </div>

                                    <div class="form-group">
                                        <label for="name" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                        <input id="CantidadContMod" type="text" maxlength="3" autocomplete="off" required="required" class="form-control labelform" name="CantidadContMod">
                                    </div>

                                </div>
                                <input type="hidden" name="idContenedor" id="idContenedor">
                                <div class="modal-footer">
                                    <div class="col-lg-10"></div>
                                    <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endcan

    <script>
        $(document).ready(function () {
            $('#TablaClientes').DataTable({
                dom: "Bfrtip",
                paging: true,
                "ordering": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "Previous": "Anterior",
                },

                buttons: [
                    {
                        extend: 'excelHtml5',

                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4],//it will exporting only 3 columns out of n no of columns

                        },
                        title: 'Clientes',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['Clientes.xml'];
                            $('row c[r^="A1"]', sheet).attr('s', '55');
                            //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                        },

                    },

                ],

            });

            $('#TablaContenedores').DataTable({
                dom: "Bfrtip",
                paging: true,
                "ordering": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "Previous": "Anterior",
                },

                buttons: [
                    {
                        extend: 'excelHtml5',

                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: [0, 1, 2],//it will exporting only 3 columns out of n no of columns

                        },
                        title: 'Contenedores',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['Contenedores.xml'];
                            $('row c[r^="A1"]', sheet).attr('s', '55');
                            //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                        },

                    },

                ],

            });

            $('#TablaCausalesDescarte').DataTable({
                dom: "Bfrtip",
                paging: true,
                "ordering": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "Previous": "Anterior",
                },

                buttons: [
                    {
                        extend: 'excelHtml5',

                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: [0, 1],//it will exporting only 3 columns out of n no of columns

                        },
                        title: 'Causales Descarte',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['Causales.xml'];
                            $('row c[r^="A1"]', sheet).attr('s', '55');
                            //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                        },

                    },

                ],

            });

            $('#TablaTipoMedios').DataTable({
                dom: "Bfrtip",
                paging: true,
                "ordering": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "Previous": "Anterior",
                },

                buttons: [
                    {
                        extend: 'excelHtml5',

                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                        exportOptions: {
                            columns: [0, 1],//it will exporting only 3 columns out of n no of columns

                        },
                        title: 'Tipo de Medios',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['TipoMedios.xml'];
                            $('row c[r^="A1"]', sheet).attr('s', '55');
                            //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                        },

                    },

                ],

            });

            $('#ModificarClientes').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var data = button.data('whatever'); // Extract info from data-* attributes
                var modal = $(this);
                //console.log(data);
                modal.find('#NombreClienteMod').val(data.Nombre);
                modal.find('#IndicativoMod').val(data.Indicativo);
                modal.find('#NitMod').val(data.Nit);
                modal.find('#TipoMod').val(data.Tipo);
                modal.find('#idCliente').val(data.id);

                /*modal.find('#TipoMod').html('<option value="' + data.Tipo + '">' + data.Tipo + '</option>');*/
            });

            $('#ModificarContenedor').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var data = button.data('whatever'); // Extract info from data-* attributes
                var modal = $(this);
                console.log(data);
                modal.find('#TipoContenedorMod').val(data.TipoContenedor);
                modal.find('#CantidadContMod').val(data.Cantidad);
                modal.find('#idContenedor').val(data.id);

                /*modal.find('#TipoMod').html('<option value="' + data.Tipo + '">' + data.Tipo + '</option>');*/
            });

        });

        @if(session()->has('creado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Creado Correctamente',
            });
        });
        @endif

        @if(session()->has('existe'))
        $(document).ready(function () {
            iziToast.warning({
                //timeout: 20000,
                title: 'Advertencia',
                position: 'center',
                message: 'Hay Datos ya Existentes',
            });
        });
        @endif

        @if(session()->has('Actualizado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Listo',
                position: 'center',
                message: 'Actualizado Correctamente',
            });
        });
        @endif
    </script>

@endsection
