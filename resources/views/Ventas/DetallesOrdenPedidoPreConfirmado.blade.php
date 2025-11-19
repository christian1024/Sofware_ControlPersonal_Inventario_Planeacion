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
                            <th>Genero</th>
                            <th>Codigo Variedad</th>
                            <th>Variedad</th>
                            <th>Tipo Entrega</th>
                            <th>Cantidad Solicitada</th>
                            <th>Semana Solicitada</th>
                            <th>Semana Confirmada</th>
                            <th>Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php($count = 1)
                        @forelse(  $detallePedidoc->DetallesD as $detallePedidoDs)
                            @if($detallePedidoDs->Flag_Activo === '1' || $detallePedidoDs->FlagActivo_CancelacionPreConfirmado === '1')
                                <tr>
                                    <td> {{ $count }}</td>
                                    <td> {{ $detallePedidoDs->NombreGenero }}</td>
                                    <td> {{ $detallePedidoDs->Codigo }}</td>
                                    <td> {{ $detallePedidoDs->nombre_Variedad }}</td>
                                    <td> {{ $detallePedidoDs->TipoEntregaModificada }}</td>
                                    <td> {{ $detallePedidoDs->CantidadInicialModificada }}</td>
                                    <td> {{ $detallePedidoDs->SemanaEntregaModificada }}</td>
                                    <td> {{ $detallePedidoDs->SemanaPlaneacionDespacho }}</td>
                                    <td>
                                        @if($detallePedidoDs->FlagActivo_EstadoPreConfirmacion === '1')
                                            <span> Confirmado</span>
                                        @elseif($detallePedidoDs->FlagActivo_CancelacionPreConfirmado === '1' && $detallePedidoDs->Flag_Activo === '0' )
                                            <span> Cancelada</span>
                                        @else
                                            @can('CancelacionItemPlaneado')
                                                <a href="{{ route('CancelacionItemPedidoPreConfirmado',['id'=>encrypt($detallePedidoDs->id),'idCabeza'=>encrypt($detallePedidoDs->id_CabezaPedido)]) }}" class="btn btn-danger btn-circle btn-sm" type="button" style="position: center">
                                                    <i class="fas fa-trash" title="Cancelar"></i>
                                                </a>
                                            @endcan
                                            @can('ConfirmacionItemPlaneado')
                                                <a href="{{ route('ConfirmacionItemPedidoPreConfirmado',['id'=>encrypt($detallePedidoDs->id),'idCabeza'=>encrypt($detallePedidoDs->id_CabezaPedido)]) }}" class="btn btn-success btn-circle btn-sm" type="button" style="position: center">
                                                    <i class="fas fa-check" title="Confirmar"></i>
                                                </a>
                                            @endcan
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
@endsection

