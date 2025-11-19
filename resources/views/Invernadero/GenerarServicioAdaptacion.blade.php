@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        @can('VistaAdaptacion')
            <div id="tabs" class="col-md-12 col-lg-12 col-xs-12 box box-body spaceTap">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @can('NuevaAdaptacion')
                        <li>
                            <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#crearAdaptacion"><span>Nueva Adaptación</span></a>
                        </li>
                    @endcan
                    @can('VerAdaptaciones')
                        <li>
                            <a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#VerAdaptaciones"><span>Adaptaciones Pendientes</span></a>
                        </li>
                    @endcan
                </ul>
                <div class="tab-content" id="myTabContent">
                    @can('NuevaAdaptacion')
                        <div id="crearAdaptacion" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                            <div>
                                <form id="NewAdaptacion" method="POST" action="{{ route('NewAdaptacion') }}">
                                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                    <div class="box box-default">
                                        <h3>Nueva Adaptación</h3>
                                    </div>

                                    <div class="row">

                                        <div class="col-lg-4">

                                            <div class="form-group">
                                                <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                                <input type="number" name="Cantidad" min="1" id="Cantidad" class="form-control labelform">
                                            </div>

                                            <div class="form-group">
                                                <label for="" class="col-form-label text-md-right">{{ __('Genero\Variedad') }}</label>
                                                <select class="form-control labelform selectpicker" data-live-search="true" name="IDVariedad" id="IDVariedad">
                                                    <option selected="true" value="" id="select" disabled="disabled">Seleccione.....</option>
                                                    @foreach($variedades as $variedad)
                                                        <option value="{{ $variedad->id }},{{ $variedad->Codigo }}">{{ $variedad->Codigo }} {{ $variedad->NombreGenero }}/{{ $variedad->Nombre_Variedad }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">

                                            <div>
                                                <div class="form-group">
                                                    <label for="" class="col-form-label text-md-right">{{ __('Semana Entrada') }}</label>
                                                    <input type="week" name="SemanaEntrada" id="SemanaEntrada" max="2030-W52" class="form-control labelform">
                                                </div>
                                            </div>

                                            <div>
                                                <div class="form-group">
                                                    <label for="" class="col-form-label text-md-right">{{ __('Semana Despacho') }}</label>
                                                    <input type="week" name="SemanaDespacho" id="SemanaDespacho" max="2030-W52" class="form-control labelform">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-lg-4">

                                            <div>
                                                <div class="form-group">
                                                    <label for="cliente" class="col-form-label">{{ __('Cliente') }}</label>
                                                    <select class="form-control labelform" name="id_cliente" id="id_cliente">
                                                        <option selected="true" value="" id="select" disabled="disabled">Seleccione.....</option>
                                                        @foreach($clientes as $cliente)
                                                            <option value="{{ $cliente->id }},{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <label for="CodigoInterno" class="col-form-label">{{ __('Codigo Interno') }}</label>
                                                    <input type="text" name="CodigoInterno" id="CodigoInterno" class="form-control labelform">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row" style="margin-top: 20px">
                                        <div class="col-lg-3"></div>
                                        <div class="col-lg-6">
                                            <button class="btn btn-success  btn-block" id="CrearRegistro" type="button">Cargar</button>
                                        </div>
                                        <div class="col-lg-3" style="margin-top: 10px"></div>
                                    </div>
                                    {{-- <div class="col-lg-12">
                                         <div class="col-lg-2">

                                         </div>
                                         <div class="col-lg-2">
                                             <div class="form-group">
                                                 <label for="" class="col-form-label text-md-right">{{ __('Semana Entrada') }}</label>
                                                 <input type="week" name="SemanaEntrada" id="SemanaEntrada" max="2030-W52" class="form-control labelform">
                                             </div>
                                         </div>
                                         <div class="col-lg-2">
                                             <div class="form-group">
                                                 <label for="" class="col-form-label text-md-right">{{ __('Semana Despacho') }}</label>
                                                 <input type="week" name="SemanaDespacho" id="SemanaDespacho"  max="2030-W52" class="form-control labelform">
                                             </div>
                                         </div>

                                         <div class="col-lg-3">
                                             <div class="form-group">
                                                 <label for="" class="col-form-label text-md-right">{{ __('Genero\Variedad') }}</label>
                                                 <select class="form-control labelform selectpicker" data-live-search="true" name="IDVariedad" id="IDVariedad">
                                                     <option selected="true" value="" id="select" disabled="disabled">Seleccione.....</option>
                                                     @foreach($variedades as $variedad)
                                                         <option value="{{ $variedad->id }},{{ $variedad->Codigo }}">{{ $variedad->Codigo }} {{ $variedad->NombreGenero }}/{{ $variedad->Nombre_Variedad }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="col-lg-3">
                                             <div class="form-group">
                                                 <label for="cliente" class="col-form-label">{{ __('Cliente') }}</label>
                                                 <select class="form-control labelform" name="id_cliente" id="id_cliente">
                                                     <option selected="true" value="" id="select" disabled="disabled">Seleccione.....</option>
                                                     @foreach($clientes as $cliente)
                                                         <option value="{{ $cliente->id }},{{ $cliente->Indicativo }}"> {{ $cliente->Nombre }} - {{ $cliente->Tipo }} </option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                         </div>


                                     </div>

                                     <div class="col-lg-12" style="margin-top: 20px">
                                         <div class="col-lg-3"></div>
                                         <div class="col-lg-6">
                                             <button class="btn btn-success  btn-block" id="CrearRegistro" type="button">Cargar</button>
                                         </div>
                                         <div class="col-lg-3" style="margin-top: 10px"></div>
                                     </div>--}}

                                    <div id="tablaMostrar" style="display: none">
                                        <div class="col-lg-12">
                                            <div class="table table-responsive">
                                                <table class="table table-hover table table-striped table-bordered" id="TablaAdaptacion">
                                                    <thead>
                                                    <tr>
                                                        <td>item</td>
                                                        <td>cliente</td>
                                                        <td>Variedad</td>
                                                        <td>Cantidad</td>
                                                        <td>Semana Entrada</td>
                                                        <td>Semana Despacho</td>
                                                        <td>Eliminar</td>
                                                    </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="col-lg-12" style="margin-top: 20px">
                                            <div class="col-lg-3"></div>
                                            <div class="col-lg-6">
                                                <button class="btn btn-success  btn-block" type="submit">Guardar</button>
                                            </div>
                                            <div class="col-lg-3" style="margin-top: 10px"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endcan

                    @can('VerAdaptaciones')
                        <div id="VerAdaptaciones" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                            @can('VerAdaptaciones')
                                <div class="box box-default">
                                    <div class="table-responsive">
                                        <table id="tablaAdapacionPen" class="table table-info" style="width:100%;">
                                            <thead>
                                            <tr>
                                                <th>Item</th>
                                                {{--<th>Variedad</th>--}}
                                                <th>Cliente</th>
                                                {{--<th>Cantidad</th>--}}
                                                <th>Codigo Adaptacion</th>
                                                <th> Acciones</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php( $count =1)
                                            @foreach( $adaptacionespendetientes as $adaptacionpendetiente)
                                                <tr>
                                                    <td>{{ $count }}</td>
                                                    {{--<td>{{ $adaptacionpendetiente->Nombre_Variedad }}</td>--}}
                                                    <td>{{ $adaptacionpendetiente->Nombre }}</td>
                                                    {{--<td>{{ $adaptacionpendetiente->Cantidad }}</td>--}}
                                                    <td>{{ $adaptacionpendetiente->CodAdaptacion }}</td>

                                                    <td style="text-align: center">
                                                        <a type="button" class="btn btn-primary btn btn-circle Detalles" data-toggle="modal" data-whatever="{{ json_encode(['Detalles'=>$adaptacionpendetiente])}}" data-target="#DetallesIntroduccion">
                                                            <i data-toggle="tooltip" title="Detalles Adaptacion" class="fa fa-eye"></i>
                                                        </a>

                                                        <a href="{{ route('ImprimirAdaptacion',['codigo'=>$adaptacionpendetiente->CodAdaptacion]) }}" class="btn btn-success btn btn-circle imprimir" {{--data-whatever="{{ json_encode(['Detalles'=>$Introduccione])}}--}}>
                                                            <i data-toggle="tooltip" title="Generar Etiquetas" class="fa fa-print"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                                @php($count++)
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    @endcan
                </div>
            </div>
        @endcan
        {{-- modal calculo semans--}}
        <div class="modal fade bigEntrance2" id="DetallesIntroduccion" role="dialog">
            <div class="modal-dialog modal-lg " style="width: 80% !important; margin-top: 80px">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title"><i class="fa fa-briefcase" style="font-size: 40px; color: #0b97c4"></i> Detalles Adapatación</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div>
                        <div class="col-lg-12" style="margin-top: 15px">
                            <div class="table table-responsive" id="mostrarSimuladorTabla">
                                <table class="table table-hover" id="TablaDetalleIntroduccion">
                                    <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Variedad</th>
                                        <th>Identificador</th>
                                        <th>Cantidad Plantas</th>
                                        <th>Contenedor</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="col-lg-9"></div>
                            <div class="col-lg-3">

                                <label>Cantidad Total Plantas</label>
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <input type="text" id="CantidadTotal" class="form-control labelform" disabled>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
    <script>

        let array = [];
        let countRow = 0;
        let countRowD = 1;
        $(document).ready(function () {
            let token = $('#token').val();
            $("#CrearRegistro").click(function () {
                let VariedadCodigo = $('#IDVariedad').val();
                let SemanaEntrada = $('#SemanaEntrada').val();
                let SemanaDespacho = $('#SemanaDespacho').val();
                let Cantidad = $('#Cantidad').val();
                let CodigoInterno = $('#CodigoInterno').val();
                let ClienteyIndicatico = $('#id_cliente').val();
                let nameVariedad = $('select[name="IDVariedad"] option:selected').text();
                let NameCliente = $('select[name="id_cliente"] option:selected').text();
                //let NameContenedor = $('select[name="IDContenedor"] option:selected').text();
                //alert(SemanaEntrada);
                if (VariedadCodigo === null) {

                } else {
                    var separadorVar = ",",
                        IdVariedad = VariedadCodigo.split(separadorVar)[0],
                        Codigo = VariedadCodigo.split(separadorVar)[1];
                }
                if (ClienteyIndicatico === null) {
                } else {
                    var separadorClei = ",", // un espacio en blanco
                        idCliente = ClienteyIndicatico.split(separadorClei)[0],
                        Indicativo = ClienteyIndicatico.split(separadorClei)[1];
                }

                if (SemanaEntrada === '') {
                } else {
                    var SeparadorSemana = "-W", // un espacio en blanco
                        ano = SemanaEntrada.split(SeparadorSemana)[0],
                        semana = SemanaEntrada.split(SeparadorSemana)[1];
                    semanaReal = ano + semana;
                }
                if (SemanaDespacho === '') {
                } else {
                    var SeparadorSemanaDes = "-W", // un espacio en blanco
                        anoDes = SemanaDespacho.split(SeparadorSemanaDes)[0],
                        semanaDes = SemanaDespacho.split(SeparadorSemanaDes)[1];
                    semanaRealDes = anoDes + semanaDes;
                }

                if (Cantidad <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cantidad Incorrecta',
                    });
                } else if (SemanaEntrada === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'seleccione Semana entrada',
                    });
                } else if (SemanaDespacho === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'seleccione Semana despacho',
                    });
                } else if (nameVariedad === 'Seleccione.....') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Variedad',
                    });
                } else if (nameVariedad === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Variedad',
                    });
                } else if (NameCliente === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Cliente',
                    });
                } else if (NameCliente === 'Seleccione.....') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Cliente',
                    });
                } else {
                    if (idCliente.length > 0) {
                        $('#tablaMostrar').show();
                        $($('#id_cliente')).attr('disabled', true);
                        $('#CodigoInterno').val('');
                        //$($('#Comentario')).prop('disabled', true);
                        let add = '<tbody>' +
                            '<tr>' +
                            '<td style="text-align: center">' + countRowD + '</td>' +
                            '<td>' + NameCliente + '</td>' +
                            '<td>' + nameVariedad + ' ' + CodigoInterno + '</td>' +
                            '<td style="text-align: center">' + Cantidad + '</td>' +
                            '<td>' + semanaReal + '</td>' +
                            '<td>' + semanaRealDes + '</td>' +
                            '<td style="text-align: center"><a class="btn btn-danger" title="Eliminar" onclick="EliminarFila(this,' + countRow + ')" style="position: center"><i class="fa fa-trash"></i></a></td>' +
                            '</tr>' +
                            '</tbody>';

                        $('#TablaAdaptacion').append(add);
                        $('#Cantidad').val('');
                        let identificador = Indicativo + Codigo + semanaReal;
                        array[countRow] = {IdVariedad, Cantidad, idCliente, semanaReal, semanaRealDes, identificador, CodigoInterno};
                        countRow++;
                        countRowD++;
                        array = array.filter(function (e) {
                            return e
                        });
                    }
                }
            });

            $('#NewAdaptacion').submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                //console.log(array);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    dataType: 'json',
                    data: {array},//{datosformulario:{dataString},datostabla:array},//datos que envi
                    url: "{{ route('NewAdaptacion') }}",
                    type: 'POST',
                    success: function (Result) {
                        //console.log(Result.data);
                        if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                            $("#NewAdaptacion")[0].reset();//limpio formulario
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Datos Guardados Exitosamente',
                                showConfirmButton: false,
                                timer: 13500
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Revise la informacion algo salio mal',
                                showConfirmButton: false,
                                timer: 13500
                            });
                        }
                    }
                });
            });


        });

        function EliminarFila(v, fila) {
            $(v).closest('tr').remove();
            //delete array[fila];
            array.splice(fila, 1);
            //$(v).deleteRow();
        }

        $('#TablaDetalleIntroduccion, #tablaAdapacionPen').DataTable({

            // dom: "Bfrtip",
            paging: false,
            "language": {
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                "Previous": "Anterior",
            },
        });

        $('.Detalles').on('click', function () {
            let token = $('#token').val();
            let Detalles = $(this).data('whatever');

            //console.log(Detalles.Detalles.CodIntroducion);
            let CodigoIntro = Detalles.Detalles.CodAdaptacion;
            let count = 1;

            //alert(CodigoIntro);
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {CodigoIntro: CodigoIntro},
                url: "{{ route('DetallesAdaptacion') }}",

                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.data, function (index, value) {

                        let fase = value.IdTipoFase;

                        console.log(Result);
                        tbHtml += '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.Nombre_Variedad + ' ' + value.CodigoInterno + '</td>' +
                            '<td>' + value.Identificador + '</td>' +
                            '<td>' + value.Cantidad + '</td>' +
                            '<td>' + value.TipoContenedor + '</td>' +
                            '</tr>';
                        count++;

                        $('#CantidadTotal').val(Result.total.CantidadTotal);
                    });
                    $('#TablaDetalleIntroduccion tbody').html(tbHtml);
                },
            });
        });
    </script>
@endsection
