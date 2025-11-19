@extends('layouts.Principal')
@section('contenidoPrincipal')


    <div class="card row">
        <!--Pestañas-->
        <div class="col-lg-12 card card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @can('VerGenerarPedido')
                    <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#GenerarPedido"><span>Generar Pedido</span></a></li>
                @endcan
                @can('VerListaPedidos')
                    <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#OrdenesPedido"><span>Ordenes de Pedido</span></a></li>
                @endcan
            </ul>

            <div class="tab-content" id="myTabContent">
                @can('VerGenerarPedido')
                    <div id="GenerarPedido" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                        <form id="CrearPedidoPre" method="POST" action="{{ route('NewPedidoSolicitado') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="form-row">
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label for="cliente" class="col-form-label">{{ __('Cliente') }}</label>
                                        <select class="form-control labelform" required="required" name="id_cliente" id="id_cliente">
                                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                            @foreach($ClientesAct as $ClientesActs)
                                                <option value="{{ $ClientesActs->id }}"> {{ $ClientesActs->Nombre }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="" class="col-form-label text-md-right">{{ __('Semana Sugerida ') }}<i class="glyphicon glyphicon-calendar"></i></label>
                                        <input type="week" onchange="Fechas()" name="Semana" id="Semana" class="form-control labelform">

                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <label for="cliente" class="col-form-label">{{ __('Tipo Programa') }}</label>
                                    <select class="form-control labelform" name="TipoPrograma" id="TipoPrograma" required>
                                        <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                        <option value="Nucleo">Nucleo</option>
                                        <option value="Especial">Especial</option>
                                        <option value="Adicional">Adicional</option>
                                        <option value="Exportación">Exportación</option>
                                    </select>
                                </div>

                                <div class="col-lg-2">
                                    <label for="cliente" class="col-form-label">{{ __('Radicados Cancelados') }}</label>
                                    <select class="form-control labelform" name="RadicadoCancelado" id="RadicadoCancelado">
                                        <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                        @foreach($detallescanceladossinasignara as $detallescanceladossinasignaras )
                                            <option value="{{ $detallescanceladossinasignaras->id }}">
                                                {{ $radicadofinalAsignar }}-
                                                {{ $detallescanceladossinasignaras->NumeroPedido }}-
                                                {{ $detallescanceladossinasignaras->id }}
                                                ({{$detallescanceladossinasignaras->Codigo}}/{{ $detallescanceladossinasignaras->Indicativo }})

                                            </option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-lg-1">
                                    <div class="form-group">
                                        <label for="" class="col-form-label text-md-right">{{ __('Numero Pedido') }}</label>
                                        <input type="text" class="form-control labelform" disabled value="{{ $radicadofinalAsignar }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-row " style="margin-top: 30px">
                                <div class="col-lg-4 divborderdetalle">
                                    <div style="margin-top: 10px">
                                        <div class="col-lg-12">
                                            <label>Variedad</label>
                                            <select class="form-control selectpicker" id="Variedad" name="Variedad" data-live-search="true">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                @foreach( $Variedades as $variedades)
                                                    <option value="{{ $variedades->id }}">{{ $variedades->Codigo }}/{{ $variedades->NombreGenero }}/{{ $variedades->Nombre_Variedad }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-lg-12">
                                            <label>Tipo Entrega</label>
                                            <select class="form-control selectpicker" id="TipoEntrega">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                <option value="Invitro">Invitro</option>
                                                <option value="Adaptado">Adaptado</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-12" style="margin-top: 10px">
                                            <div class="form-group">
                                                <label for="" class="col-form-label text-md-right">{{ __('Semana') }}</label>
                                                <input type="week" class="form-control labelform" id="SemanaV" name="SemanaV">
                                            </div>
                                        </div>

                                        <div class="col-lg-12" style="margin-top: 10px">
                                            <div class="form-group">
                                                <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                                <input type="number" class="form-control labelform" min="1" id="Cantidad" autocomplete="off">
                                            </div>
                                        </div>


                                        <div class="col-lg-12" style="margin-top: 10px">

                                            <button class="btn btn-primary  btn-lg btn-block" type="button" id="CrearRegistro">Generar</button>

                                        </div>

                                        <div class="col-lg-12" style="margin-top: 30px"></div>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div class="table table-responsive div1">
                                        <table class="table table-hover table table-striped table-bordered" id="tableRegistroOdenes">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Variedad</th>
                                                <th>Tipo Entrega</th>
                                                <th>Cantidad</th>
                                                <th>Semana</th>
                                                <th>Eliminar</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="comment">Observaciones:</label>
                                        <textarea class="form-control" rows="2" id="Observaciones" style="resize:none;" name="Observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12" style="margin-top: 20px">
                                <button class="btn btn-success  btn-lg btn-block" id="giardarpedido" type="submit">Guardar</button>
                            </div>
                        </form>

                    </div>
                @endcan

                @can('VerListaPedidos')
                    <div id="OrdenesPedido" class="tab-pane fade" role="tabpanel" aria-labelledby="contact-tab">

                        <div class="form-row">

                            <div class="col-md-12 col-lg-12 col-xs-12" style="margin-top: 10px"></div>

                            <div class="col-md-12 col-lg-12 col-xl-12" style="margin-top: -15px;">


                                <div class="table table-responsive " style="height: 480px">
                                    <table class="table table-hover" id="OrdenesPedidos">
                                        <thead>
                                        <tr>
                                            {{-- <th>Item</th>--}}
                                            <th>Numero de Orden</th>
                                            <th>Codigo Interno</th>
                                            <th>Procedencia</th>
                                            <th>Cliente</th>
                                            <th>Semana Entrega</th>
                                            <th>Estado</th>
                                            <th>Accion</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($count=1)
                                        @forelse($Pedidos as $Pedido)
                                            <tr>
                                                {{-- <td>{{ $count }}</td>--}}
                                                <td>{{ $Pedido->NumeroPedido }}</td>
                                                <td>{{ $Pedido->id }}</td>
                                                <td>{{ $Pedido->IdcabezaInicial }}</td>
                                                <td>{{ $Pedido->Nombre }}</td>
                                                <td>{{ $Pedido->SemanaEntrega }}</td>
                                                <td>{{ $Pedido->EstadoDocumento }}</td>
                                                <td>
                                                    @if($Pedido->EstadoDocumento =='Solicitado')
                                                        @can('btnSolicitadoPlaneacion')
                                                            <a href="{{ route('OrdenPedidoDetalle',['id'=>encrypt($Pedido->id)]) }}" class="btn btn-warning" data-placement="left" data-toggle="tooltip" data-html="true" title="Ver Detalles" style="position: center"><i class="fa fa-check"></i> </a>
                                                        @endcan
                                                    @elseif($Pedido->EstadoDocumento =='PreConfirmado')
                                                        @can('btnPreconfirmadoPlaneacion')
                                                            <a href="{{ route('DetallesPedidoPreConfirmado',['id'=>encrypt($Pedido->id)]) }}" class="btn btn-primary" data-placement="left" data-toggle="tooltip" data-html="true" title="Ver Detalles" style="position: center"><i class="fa fa-check"></i> </a>
                                                        @endcan
                                                    @elseif($Pedido->EstadoDocumento =='Aceptado')
                                                        @can('btnAceptadoPlaneacion')
                                                            <a href="{{ route('ViewPedidoAceptado',['id'=>encrypt($Pedido->id)]) }}" class="btn btn-success" data-placement="left" data-toggle="tooltip" data-html="true" title="Ver Detalles Aceptados" style="position: center"><i class="fa fa-check-circle"></i> </a>
                                                        @endcan
                                                    @elseif($Pedido->EstadoDocumento =='Cancelado')
                                                        @can('btnCanceladoPlaneacion')
                                                            <a href="{{ route('ViewPedidoAceptado',['id'=>encrypt($Pedido->id)]) }}" class="btn btn-danger" data-placement="left" data-toggle="tooltip" data-html="true" title="Ver Detalles Cancelados" style="position: center"><i class="fa fa-times"></i> </a>
                                                        @endcan
                                                    @endif
                                                </td>
                                            </tr>
                                            @php($count++)
                                        @empty
                                            <div class="alert alert-danger">No Hay Datos</div>
                                        @endforelse

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            </div>
        </div>

    </div>

    <script>


        function Fechas() {
            let SemanaCabeza = $('#Semana').val();
            $('#SemanaV').val(SemanaCabeza);

            var cadena = "2019-W15",
                separador = "-W", // un espacio en blanco
                limite = 2,
                arregloDeSubCadenas = cadena.split(separador, limite);

            console.log(arregloDeSubCadenas); // la consola devolverá: ["cadena", "de"]
        }

        let array = [];
        let countRow = 0;
        let countRowD = 1;


        $(document).ready(function () {
            let token = $('#token').val();
            $("#CrearRegistro").click(function () {
                let Variedad = $('#Variedad').val();
                let Cantidad = $('#Cantidad').val();
                let TEntrega = $('#TipoEntrega').val();
                let Semana = $('#SemanaV').val();
                let RadicadoCancelado = $('#RadicadoCancelado').val();
                let nameVariedad = $('select[name="Variedad"] option:selected').text();
                let Fecha;

                if (Semana === '') {
                    Fecha = 'N/A'
                } else {
                    var separador = "-W", // un espacio en blanco
                        arregloDeSubCadenas = Semana.split(separador)[0],
                        arregloDeSubCadenass = Semana.split(separador)[1];

                    Fecha = arregloDeSubCadenas + '' + arregloDeSubCadenass;
                }
                if (Variedad === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Variedad',
                    });
                } else if (Cantidad === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cantidad Incorrecta',
                    });
                } else if (Cantidad <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cantidad Incorrecta debe ser mayor a 0',
                    });
                } else if (TEntrega === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tipo de entrega???',
                    });
                }/* else if (Semana === '') {
                    swal("Debes diligenciar semana")
                }*/ else {
                    let add = '<tbody>' +
                        '<tr>' +
                        '<td style="text-align: center">' + countRowD + '</td>' +
                        '<td>' + nameVariedad + '</td>' +
                        '<td>' + TEntrega + '</td>' +
                        '<td style="text-align: center">' + Cantidad + '</td>' +
                        '<td style="text-align: center">' + Fecha + '</td>' +
                        '<td style="text-align: center"><a class="btn btn-danger" title="Eliminar" onclick="EliminarFila(this,' + countRow + ')" style="position: center"><i class="fa fa-trash"></i></a></td>' +
                        '</tr>' +
                        '</tbody>';

                    $('#tableRegistroOdenes').append(add);
                    $('#Cantidad').val('');
                    $($('#id_cliente')).attr('disabled', true);
                    array[countRow] = {Variedad, Cantidad, TEntrega, Fecha};
                    countRow++;
                    countRowD++;

                }
            });

            $('#CrearPedidoPre').submit(function (event) { //este es el id del form
                    event.preventDefault();
                    $('#boton').attr("disabled", true);
                    let token = $('#token').val();
                    let dataform = {
                        id_cliente: $('#id_cliente').val(),
                        TipoPrograma: $('#TipoPrograma').val(),
                        Semana: $('#Semana').val(),
                        Observaciones: $('#Observaciones').val(),
                        RadicadoCancelado: $('#RadicadoCancelado').val(),
                    };
                    //alert(array);
                    if (array === null || array <= 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Debe Solicitar al menos una variedad',
                        });
                        return false;
                    }
                    if (dataform.Semana === '') {
                        Swal.fire({
                            title: 'Dato Incompleto',
                            text: 'Esta Generando un Pedido sin Semana de Entrega',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'SI, Guardar Sin Semana',
                            cancelButtonText: 'No, Asignar Semana'
                        }).then((result) => {
                            if (result.value) {
                                $('#giardarpedido').prop('disabled', true);
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': token},
                                    dataType: 'json',
                                    data: {dataform, array},//{datosformulario:{dataString},datostabla:array},//datos que envi
                                    url: "{{ route('NewPedidoSolicitado') }}",
                                    type: 'post',
                                    success: function (Result) {
                                        if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                            // console.log(Result.data);
                                            //console.log(Result.data.NumeroPedido);
                                            $("#CrearPedidoPre")[0].reset();//limpio formulario
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Datos Guardados',
                                                showConfirmButton: false,
                                            })
                                            //window.location.href='prueba/'+Result.cabeza.NumeroPedido;
                                            location.reload(true);
                                            //setInterval("actualizar()", 1500);
                                        } else {
                                            Swal.fire({
                                                icon: 'error',
                                                title: 'Oops...',
                                                text: 'Algo salio mal!',
                                            });
                                        }
                                    }
                                });
                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Asignar  Semana',
                                    showConfirmButton: false,
                                })
                            }
                        });

                    } else {
                        $('#giardarpedido').prop('disabled', true);
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},
                            dataType: 'json',
                            data: {dataform, array},//{datosformulario:{dataString},datostabla:array},//datos que envi
                            url: "{{ route('NewPedidoSolicitado') }}",
                            type: 'post',
                            success: function (Result) {
                                if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                    $("#CrearPedidoPre")[0].reset();//limpio formulario
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Datos Guardados',
                                        showConfirmButton: false,
                                    })
                                    //window.location.href='prueba/'+Result.cabeza.NumeroPedido;
                                    location.reload(true);

                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Algo salio mal!',
                                    });
                                }

                            }
                        });
                    }
                }
            );

            $('#giardarpedido').click(function () {

            });
            table = $('#OrdenesPedidos').DataTable({
                //aqui

                /*dom: '<"top"i>rt<"bottom"flp><"clear">',*/
                /*  dom: "Bfrtip",*/
                paging: false,
                info: false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros _TOTAL_",
                    "Previous": "Anterior",
                },


            });


        });

        function actualizar() {
            location.reload(true);
        }

        function EliminarFila(v, fila) {
            $(v).closest('tr').remove();
            array.splice(fila, 1);
            //$(v).deleteRow();
        }


    </script>

@endsection
