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

                <div class="col"></div>
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


            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="form-group">
                        <label for="Observaciones" for="name" class="col-form-label text-md-right">{{ __('Observaciones') }}</label>
                        <input id="Observaciones" class="form-control labelform" name="Observaciones" value="{{ $detallePedidoc->Detalles->Observaciones }}" disabled/>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">


            <div class="col-lg-12">
                <div class="table table-responsive ">
                    <table class="table table-hover" id="TablaDetallesPedido">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th>Interno</th>
                            <th>Genero</th>
                            <th>Codigo Variedad</th>
                            <th>Variedad</th>
                            <th>Tipo Entrega</th>
                            <th>Cantidad Solicitada</th>
                            <th>Semana Confirmada</th>
                            <th>Accion</th>

                        </tr>
                        </thead>
                        <tbody>
                        @php($count = 1)
                        @forelse(  $detallePedidoc->DetallesD as $detallePedidoDs)
                            <tr>
                                <td> {{ $count }}</td>
                                <td> {{ $detallePedidoDs->id }}</td>
                                <td> {{ $detallePedidoDs->NombreGenero }}</td>
                                <td> {{ $detallePedidoDs->Codigo }}</td>
                                <td>
                                    <div class="card">
                                        <div class="card-header " style="cursor: move;">
                                            {{ $detallePedidoDs->nombre_Variedad }}
                                            @php($caracteristicas = \App\Http\Controllers\OrdenesPedidoLaboratorioController::DetallesPlaneacionSemanaAsemanaC(encrypt($detallePedidoDs->id)))
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool btn btn-success btn-circle btn-sm" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-hover" id="TablaDetallesPedido">
                                                <thead>
                                                <tr>
                                                    <th>Semana</th>
                                                    <th>Cantidad</th>
                                                    <th>Fase</th>
                                                    <!--<th>Accion</th>-->
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                @foreach($caracteristicas as $caracteristica)
                                                    <tbody>
                                                    <tr>
                                                        <td> {{ $caracteristica->SemanaMovimiento }}</td>
                                                        <td>{{ $caracteristica->CantidadPlantas }}</td>
                                                        <td>{{ $caracteristica->NombreFase }}</td>
                                                        <!--<td>
                                                            <button type="button" class="btn btn-success btn-circle btn-sm" data-card-widget="collapse">
                                                            <i class="fas fa-check"></i>
                                                            </button>
                                                        </td>-->

                                                    </tr>
                                                    </tbody>
                                                @endforeach
                                            </table>

                                        </div>

                                    </div>

                                </td>
                                <td> {{ $detallePedidoDs->TipoEntregaModificada }}</td>
                                <td> {{ $detallePedidoDs->CantidadInicialModificada }}</td>
                                <td> {{ $detallePedidoDs->SemanaPlaneacionDespacho }}</td>
                                <td>
                                    @can('btnCancelarPedidoPlaneado')
                                        <button class="btn btn-danger btn-circle btn-sm" type="button" data-toggle="modal" data-target="#DeleteItem" data-whatever="{{ json_encode($detallePedidoDs) }}" style="position: center">
                                            <i class="fas fa-trash" title="Cancelar"></i>
                                        </button>
                                    @endcan
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
                {{--<a id="GuardarPlaneacion" class="btn btn-success btn-block">Guardar Planeación</a>--}}
            </div>
        </div>
    </div>

    <div class="modal fade" id="DeleteItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-danger">
                    <i class="text-center fa fa-exclamation-triangle fa-5x">
                    </i>
                    <h1 class="text-danger modal-title" id="exampleModalLabel">Cancelar Item</h1>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="deleteItem" method="POST" action="{{route('DeleteItemPlaneado') }}">
                        @csrf
                        <input type="hidden" name="cabeza" value="{{ $detallePedidoc->Detalles->id }}">
                        <input type="hidden" name="Detalle" id="Detalles">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Causal cancelación </label>
                                <select class="form-control" name="CausalCancelarPedido" required="required" id="CausalCancelarPedido">
                                    <option selected="true" value="" disabled="disabled">Seleccione Uno</option>
                                    @foreach($caulesCancelaciones as $causal)
                                        <option value="{{ $causal->id }}">{{ $causal->causalCancelacion }}</option>
                                    @endforeach
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

    <script>
        $('#DeleteItem').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var data = button.data('whatever');
            var modal = $(this);
            modal.find('#Detalles').val(data.id);
        });
    </script>

@endsection

