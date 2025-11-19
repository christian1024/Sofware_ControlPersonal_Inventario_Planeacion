@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row"{{-- style="margin-top:10px;"--}}>
        <div class="col-md-12">
            <div class="text-center">
                <h3>Tablas Maestras</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Clientes"><span>Causales Descartes</span></a></li>

                </ul>
            </div>

            <div class="tab-content" id="myTabContent">

                <div id="Clientes" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">

                    <div class="col-lg-12 box box-body spaceTap">

                        <div class="card-body">
                            @can('CrearCliente')
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#CrearCausal">Crear Causal</button>
                            @endcan
                        </div>
                        <div class="col-12">
                            <div class="table table table-responsive" style="height: 680px">

                                <table id="TablaCausales" class=" table-hover display nowrap col-lg-12 celltable-border" >
                                    <thead>
                                    <tr>
                                        <th>Causal Descarte</th>
                                        <th>Estado</th>
                                        <th>Accion</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($causalDescartes as $causalDescarte)
                                        <tr>
                                            <td>{{ $causalDescarte->CausalDescarte }}</td>
                                            @if( $causalDescarte->Flag_Activo=== '1' )
                                                <td>Activa</td>
                                            @else
                                                <td>Inactiva</td>
                                            @endif

                                            @if( $causalDescarte->Flag_Activo=== '1' )
                                                <td>
                                                    <button class="btn btn-success btn-circle btn-sm" type="button" data-toggle="modal" data-target="#ModificarCausal" data-whatever="{{ json_encode($causalDescarte) }}" style="position: center">
                                                        <i class="fas fa-external-link-alt" title="Modificar"></i>
                                                    </button>

                                                    <a href="{{ route('InactivarCausalDescarte',['id'=>encrypt($causalDescarte->id)]) }}" class="btn btn-danger btn-circle btn-sm" title="Inactivar Causal" style="position: center">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            @else
                                                <td>
                                                    <a href="{{ route('ActivarCausalDescarte',['id'=>encrypt($causalDescarte->id)]) }}" class="btn btn-success btn-circle btn-sm" title="Activar Causal" style="position: center">
                                                        <i class="fa fa-check"></i>
                                                    </a>
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
        {{--Crear Cliente--}}
    </div>

    <div class="modal fade" id="CrearCausal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i class="fa fa-newspaper" style="font-size: 40px; color: #0b97c4"></i> Crear Causal</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form id="updatecliente" method="POST" action="{{ route('EmpleadosLaboratorio') }}">
                     <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">--}}
                <div class="modal-body">
                    <form action="{{ route('CrearCausalDescarte') }}" method="post">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <div>

                            <div class="row">

                                <div class="form-group col-9">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Causal Descarte') }}</label>
                                    <input id="CausalDescarte" type="text" class="form-control labelform" name="CausalDescarteN" autofocus>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="ModificarCausal" role="dialog">
        <div class="modal-dialog modal-lg">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"><i class="fa fa-upload" style="font-size: 40px; color: #0b97c4"></i> Modificar Causal</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {{-- <form id="updatecliente" method="POST" action="{{ route('EmpleadosLaboratorio') }}">
                     <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">--}}
                <div class="modal-body">
                    <form action="{{ route('ModificarCausalDescarte') }}" method="post">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token">
                        <div>

                            <div class="row">

                                <div class="form-group col-9">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Causal Descarte') }}</label>
                                    <input id="CausalDescarte" type="text" class="form-control labelform" name="CausalDescarte" autofocus>
                                </div>

                            </div>

                            <input type="hidden" name="idCausal" id="idCausal">

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"> {{ __('Guardar') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--Crear Contenedor--}}


    <script>

        @if(session()->has('Inactivo'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Inactivo Correctamente',
            });
        });
        @endif

        @if(session()->has('Activado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Activado Correctamente',
            });
        });
        @endif

        @if(session()->has('Modificado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Modificado Correctamente',
            });
        });
        @endif

        @if(session()->has('new'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Creado Correctamente',
            });
        });
        @endif

        $('#ModificarCausal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes

            var modal = $(this);
            //console.log(data);
            modal.find('#CausalDescarte').val(data.CausalDescarte);
            modal.find('#idCausal').val(data.id);


            /*modal.find('#TipoMod').html('<option value="' + data.Tipo + '">' + data.Tipo + '</option>');*/
        });
    </script>

@endsection
