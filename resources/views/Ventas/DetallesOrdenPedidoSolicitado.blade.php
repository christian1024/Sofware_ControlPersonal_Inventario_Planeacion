@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <div style="margin-top:10px; display: flex; justify-content:center; align-items: center;">
                <h3>DETALLE PEDIDO # {{ $detallePedidoc->Detalles->NumeroPedido }}</h3>
            </div>
            <hr>
        </div>
        <div class="container-fluid">
            <div class="row">

                <div class="col text-center">
                    <div class="col-lg-12">
                        <button class="btn btn-success" type="button" data-toggle="modal" data-target="#NewVariedad" style="position: center">
                           Nueva Variedad
                        </button>
<!--                      -->
                    </div>
                </div>
                <div class="col">
                    <div class="col">
                        <label class="col">Numero Pedido</label>
                        <div class="col">
                            <input class="labelform  form-control" value="{{  $detallePedidoc->Detalles->NumeroPedido }}" disabled/>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="col">
                        <label class="col">Estado Pedido</label>
                        <div class="col">
                            <input class="labelform  form-control" value="{{  $detallePedidoc->Detalles->EstadoDocumento }}" disabled/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="col">
                        <label class="col">Cliente</label>
                        <div class="col">
                            <input value="{{ $detallePedidoc->Detalles->Nombre }}" disabled class="form-control labelform">
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="col">
                        <label class="col">Semana Entrega</label>
                        <div class="col">
                            <input class="labelform  form-control" value="{{  $detallePedidoc->Detalles->SemanaEntrega }}" disabled/>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="col">
                        <label class="col">Semana Creado</label>
                        <div class="col">
                            <input class="labelform  form-control" value="{{  $detallePedidoc->Detalles->SemanaCreacion }}" disabled/>
                        </div>
                    </div>
                </div>
            </div>


            <div class="form-row">
                <div class="col-lg-12" style="margin-top: 10px;display: flex; justify-content:center; align-items: center;">
                    <h2> variedad solicitadas</h2>
                </div>

                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                <input type="hidden" name="NumPedido" value="{{  $detallePedidoc->Detalles->id }}"/>
                <div class="col-lg-12">
                    <div class="table table-responsive ">
                        <table class="table table-striped" id="TablaDetallesPedido">
                            <thead>
                            <tr>
                                <th>Item</th>
                                <th>Codigo var</th>
                                <th>Variedad</th>
                                <th>Genero</th>
                                @can('ListProgramasPlaneacion')
                                    <th>Programas</th>
                                @endcan()

                                <th>Accion</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($count = 1)
                            @forelse( $detallePedidoc->DetallesD as $detallePedidoDs)
                                <tr>
                                    <td> {{ $count }}</td>
                                    <td> {{ $detallePedidoDs->Codigo }}</td>
                                    <td>
                                        <input type="hidden" name="IdVaridad-{{ $count }}" id="IdVaridad-{{ $count }}" value="{{  $detallePedidoDs->Codigo }}"/>
                                        {{ $detallePedidoDs->Nombre_Variedad }}

                                    </td>
                                    <td>{{ $detallePedidoDs->NombreGenero }}</td>
                                    @can('ListProgramasPlaneacion')
                                        <td>
                                            @if(  $detallePedidoDs->Flag_ActivoPlaneacion ==='1')

                                            @else

                                                @php($Programas = \App\Http\Controllers\OrdenesPedidoLaboratorioController::ProgramasPorvariedad($detallePedidoDs->idVari))
                                                <select class="selectpicker" multiple name="Programas[]-{{ $count }}" id="Programas-{{ $count }}">
                                                    @foreach($Programas as $Programa)
                                                        <option value="{{ $Programa->Indentificador }}">{{ $Programa->Indentificador }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </td>
                                    @endcan

                                    @can('RealizarPlaneacion')
                                        <td>
                                            @if( $detallePedidoDs->Flag_ActivoPlaneacion ==='1')

                                            @else
                                                <form id="PLaneacionVaridedad" method="post" action="{{ route('PLaneacionVaridedad') }}">
                                                    @csrf
                                                    <input type="hidden" name="IdVaridadH" id="IdVaridadH"/>
                                                    <input type="hidden" name="ProgramasH" id="ProgramasH">
                                                    <input type="hidden" name="NumPedido" value="{{  $detallePedidoc->Detalles->id }}"/>
                                                    <button type="button" class="btn btn-success btn-circle btn-sm" onclick="ValidaProgramas({{ $count }})" id="btnPlaneacion" data-placement="left" data-toggle="tooltip" data-html="true" style="position: center">
                                                        <i class="fa fa-calculator" title="Planeación"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    @endcan
                                    <td>
                                        <div class="card">
                                            <div class="card-header border-0 ui-sortable-handle" style="cursor: move;">
                                                Detallado
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="card-footer bg-transparent" style="display: block;">
                                                @php($caracteristicas = \App\Http\Controllers\OrdenesPedidoLaboratorioController::caracteristicas( $detallePedidoc->Detalles->id,$detallePedidoDs->idVari))
                                                <table class="table table-hover" id="TablaDetallesPedido">
                                                    <thead>
                                                    <tr>
                                                        <th>Semana Solicitud</th>
                                                        <th>Cantidad Solicitada</th>
                                                        <th>Semana Despacho</th>
                                                        <th>Estado Pedido</th>
                                                        <th>Estado Planeación</th>
                                                        <th>Acción</th>

                                                    </tr>
                                                    </thead>
                                                    @if(count($caracteristicas))
                                                        @foreach($caracteristicas as $caracteristica)
                                                            <tbody>
                                                            <tr>
                                                                <td> {{ $caracteristica->SemanaEntregaModificada }}</td>
                                                                <td>{{ $caracteristica->CantidadInicialModificada }}</td>
                                                                <td>{{ $caracteristica->SemanaPlaneacionDespacho }}</td>
                                                                <td>
                                                                    @if($caracteristica->Flag_Activo==='1' )
                                                                        <span>Activo</span>
                                                                    @else
                                                                        <span style="background-color: #ff9999">Anulado</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($caracteristica->Flag_ActivoPlaneacion==='1' && $caracteristica->Flag_Activo==='1' )
                                                                        <span>Planeado</span>
                                                                    @else
                                                                        @if($caracteristica->Flag_Activo==='1' )
                                                                            <span STYLE="background-color: #ff9999">PENDIENTE</span>
                                                                        @else

                                                                        @endif
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    @if($caracteristica->Flag_Activo==='1' && $caracteristica->Flag_ActivoPlaneacion <> '1' )
                                                                        @can('CancelarItemPedido')
                                                                            <button class="btn btn-danger btn-circle btn-sm" type="button" data-toggle="modal" data-target="#DeleteItem" data-whatever="{{ json_encode($caracteristica) }}" style="position: center">
                                                                                <i class="fas fa-trash" title="Cancelar"></i>
                                                                            </button>
                                                                        @endcan
                                                                        @can('ModificarItemPedido')
                                                                            <button class="btn btn-success btn-circle btn-sm" type="button" data-toggle="modal" data-target="#UpdateItem" data-whatever="{{ json_encode($caracteristica) }}" style="position: center">
                                                                                <i class="fas fa-external-link-alt" title="Modificar"></i>
                                                                            </button>
                                                                        @endcan
                                                                    @else

                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td>
                                                                @can('NuevoItemPedido')
                                                                    <button type="button" class="btn btn-success" data-toggle="modal" onclick="Variedad('{{$count}}')" data-target="#NewItem"><i class="fa fa-plus-circle"></i></button>
                                                                @endcan
                                                            </td>
                                                        </tr>

                                                </table>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                @php($count++)
                            @empty
                                <div class="alert alert-warning">
                                    <strong>No se encontraron datos</strong>
                                </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="form-group">
                        <label for="Observaciones" for="name" class="col-form-label text-md-right">{{ __('Observaciones') }}</label>
                        <input id="Observaciones" class="form-control labelform" name="Observaciones" value="{{ $detallePedidoc->Detalles->Observaciones }}" disabled/>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="UpdateItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar Item Pedido # {{ $detallePedidoc->Detalles->NumeroPedido }} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="updateItem" method="POST" action="{{route('updateItem') }}">
                    @csrf
                    <input type="hidden" id="idCodigo" name="idCodigo">
                    <input type="hidden" name="cabeza" value="{{ $detallePedidoc->Detalles->id }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Tipo Entrega</label>
                            <select class="form-control" id="TipoEntregaUpdate" name="TipoEntregaUpdate">
                                <option>Invitro</option>
                                <option>Adaptado</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Semana Entrega</label>
                            <input class="form-control" id="semanaEntregaUpdate" name="semanaEntregaUpdate">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Cantidad Entrega</label>
                            <input class="form-control" id="CantidadEntregaUpdate" name="CantidadEntregaUpdate">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NewItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="NuevoitemPedido" method="POST" action="{{route('NuevoitemPedido') }}">
                        @csrf
                        <input type="hidden" name="cabeza" value="{{ $detallePedidoc->Detalles->id }}">
                        <input type="hidden" name="IdVaridad" id="IdVaridad"/>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Tipo Entrega</label>
                                <select class="form-control" name="TipoEntrega" required="required">
                                    <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                    <option value="Invitro">Invitro</option>
                                    <option value="Adaptado">Adaptado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-form-label text-md-right">{{ __('Semana') }}</label>
                                <input type="week" class="form-control labelform" required="required" id="SemanaEntrega" name="SemanaEntrega">
                            </div>

                            <div class="form-group">
                                <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                <input type="number" class="form-control labelform" required="required" min="1" id="Cantidad" name="cantidadInicial" autocomplete="off">
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="NewVariedad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nueva Variedad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="NuevoitemPedido" method="POST" action="{{route('NewVariedad') }}">
                        @csrf
                        <input type="hidden" name="cabeza" value="{{ $detallePedidoc->Detalles->id }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Variedad</label>
                                <select class="form-control selectpicker" id="Variedad" name="Variedad" data-live-search="true">
                                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                    @foreach( $Variedades as $variedades)
                                        <option value="{{ $variedades->id }}">{{ $variedades->Codigo }}/{{ $variedades->NombreGenero }}/{{ $variedades->Nombre_Variedad }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tipo Entrega</label>
                                <select class="form-control selectpicker" name="TipoEntrega" id="TipoEntrega">
                                    <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                    <option value="Invitro">Invitro</option>
                                    <option value="Adaptado">Adaptado</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <label for="" class="col-form-label text-md-right">{{ __('Semana') }}</label>
                                    <input type="week" class="form-control labelform" id="SemanaV" name="SemanaV">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                        <input type="number" class="form-control labelform" min="1" id="Cantidad" name="Cantidad" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="DeleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <i class="text-center fa fa-exclamation-triangle fa-5x">
                    </i>
                    <h1 class="text-danger modal-title" id="exampleModalLabel">Cancelar Pedido </h1>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteItem" method="POST" action="{{route('DeleteItem') }}">
                        @csrf
                        <input type="hidden" name="cabeza" value="{{ $detallePedidoc->Detalles->id }}">
                        <input type="hidden" name="Detalle" id="Detalles">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Causal cancelación </label>
                                <select class="form-control" name="CausalCancelarPedido" required="required" id="CausalCancelarPedido">
                                    <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                    <option value="Solicitado por Cliente">Solicitado por Cliente</option>
                                    <option value="Darwin">Darwin</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">Cancelar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
    <script>
        $(document).ready(function () {
            $('#TablaDetallesPedido').DataTable({
                paging: false,
                info: false,
                searching: false,
                "language": {

                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros _TOTAL_",
                    "Previous": "Anterior",
                },
            });
        });

        $('#UpdateItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('#TipoEntregaUpdate').val(data.TipoEntregaModificada);
            modal.find('#semanaEntregaUpdate').val(data.SemanaEntregaModificada);
            modal.find('#CantidadEntregaUpdate').val(data.CantidadInicialModificada);
            modal.find('#idCodigo').val(data.id);
        });

        $('#DeleteItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever');
            var modal = $(this);
            modal.find('#Detalles').val(data.id);
        });

        function Variedad($count) {
            $('#IdVaridad').val($('#IdVaridad-' + $count).val());
        }


        function ValidaProgramas($count) {
            if ($('#Programas-' + $count).val().length < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Seleccione Programa',
                });
                return false;
            } else {
                $('#ProgramasH').val($('#Programas-' + $count).val());
                $('#IdVaridadH').val($('#IdVaridad-' + $count).val());
                $('#PLaneacionVaridedad').submit();

            }
        }

    </script>
@endsection
