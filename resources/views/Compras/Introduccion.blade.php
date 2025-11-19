@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        @can('VistaIntroducciones')
            <div class="col-lg-12">
                <div id="tabs" class="col-md-12 col-lg-12 col-xs-12 box box-body spaceTap" style="margin-top:10px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @can('NuevaIntroducciones')
                            <li>
                                <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#crearIntroduccion"><span>Nueva Introducción</span></a>
                            </li>
                        @endcan
                        @can('ListaIntroducciones')
                            <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#VerIntroducciones"><span>Introducciones Pendientes</span></a></li>
                        @endcan

                        @can('ReporteIntroduccion')
                            <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#ReporteIntro"><span>Consulta Introducciones</span></a></li>
                        @endcan
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @can('NuevaIntroducciones')
                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" id="crearIntroduccion">
                                <div>
                                    <form id="NewIntroduccion" method="POST" action="{{ route('NewIntroduccion') }}">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                        <div class="box box-default">
                                            <h3>Nueva Introducción</h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="" class="col-form-label text-md-right">{{ __('Semana Introduccion') }}</label>
                                                    <input type="week" name="semaIntro" max="2035-W52" id="semaIntro" class="form-control labelform">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">

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

                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="cliente" class="col-form-label">{{ __('Tipo Introduccion') }}</label>
                                                    <select class="form-control labelform" name="TIntro" id="TIntro" required="required">
                                                        <option selected="true" value="" id="select" disabled="disabled">Seleccione.....</option>
                                                        <option value="1"> Adaptado</option>
                                                        <option value="2"> Invitro</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4">
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
                                                <div class="form-group">
                                                    <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                                    <input type="number" name="Cantidad" min="1" id="Cantidad" class="form-control labelform">
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label for="cliente" class="col-form-label">{{ __('Comentario') }}</label>
                                                    <textarea class="form-control labelform" id="Comentario" name="Comentario"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row text-center" style="margin-top: 20px">
                                            <button class="btn btn-success  btn-block" id="CrearRegistro" type="button">Cargar</button>
                                        </div>

                                        <div class="row">
                                            <div id="tablaMostrar" class="col-lg-12" style="display: none">
                                                <div class="" style="margin-top: 10px">
                                                    <div class="table-responsive">
                                                        <table id="TablaIntroduccion" class="table table-hover table-bordered" style="width:100%;">

                                                            <thead>
                                                            <tr>
                                                                <td>item</td>
                                                                <td>cliente</td>
                                                                <td>Variedad</td>
                                                                <td>Cantidad</td>
                                                                <td>Tipo Intro</td>
                                                                <td>Identificador</td>
                                                                <td>Eliminar</td>
                                                            </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="row col-lg-12" style="margin-top: 20px">
                                                    <button class="btn btn-block btn-outline-success" type="submit">Guardar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        @endcan

                        @can('ListaIntroducciones')
                            <div id="VerIntroducciones" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                                @can('TablaIntroducciones')
                                    <div class="box box-default">
                                        <div class="table-responsive">
                                            <table id="ViewIntroducciones" class="table table-hover table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Cliente Introducción</th>
                                                    <th>Codigo Introducción</th>
                                                    <th> Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @php( $count =1)
                                                @foreach( $Introducciones as $Introduccione)
                                                    <tr>
                                                        <td>{{ $count }}</td>
                                                        <td>{{ $Introduccione->Nombre }}</td>
                                                        <td>{{ $Introduccione->CodIntroducion }}</td>
                                                        <td style="text-align: center">
                                                            <a type="button" class="Detalles btn btn-primary btn-circle btn-sm" data-toggle="modal" data-whatever="{{ json_encode(['Detalles'=>$Introduccione])}}" data-target="#DetallesIntroduccion">
                                                                <i data-toggle="tooltip" title="Detalles Impresion" class="fa fa-info"></i>
                                                            </a>
                                                            @can('BtnIntroducciones')
                                                                <a href="{{ route('ImprimirIntroduccion',['codigo'=>$Introduccione->CodIntroducion]) }}" class="btn btn-success btn-circle btn-sm imprimir" {{--data-whatever="{{ json_encode(['Detalles'=>$Introduccione])}}--}}>
                                                                    <i data-toggle="tooltip" title="Generar Etiquetas" class="fa fa-print"></i>
                                                                </a>
                                                            @endcan
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

                        @can('ReporteIntroduccion')
                            <div id="ReporteIntro" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">
                                <div class="col-12">
                                    <div class="col-12">
                                        <label>Fecha Inicio</label>
                                        <input type="date" id="idInicialdate">

                                        <label>Fecha Fin</label>
                                        <input type="date" id="idFinaldate">

                                        <button class="btn btn-success" type="button" id="CargarIntroducciones">Cargar</button>
                                    </div>
                                    <div class="col-12" style="margin-top: 30px">
                                        <div class="box box-body table-responsive">
                                            <table id="TablaReporteIntro" class="table table-hover table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Cliente Introducción</th>
                                                    <th>Codigo Introducción</th>
                                                    <th> Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>

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
    </div>
    @endcan
    {{-- modal calculo semans--}}
    <div class="modal fade bigEntrance2" id="DetallesIntroduccion" role="dialog">
        <div class="modal-dialog modal-lg " style="width: 80% !important; margin-top: 80px">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">

                    <h3 class="modal-title"><i class="fa fa-briefcase" style="font-size: 40px; color: #0b97c4"></i> Detalles Introducción</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12" style="margin-top: 15px">
                        <div class="table table-responsive" id="mostrarSimuladorTabla">
                            <table class="table table-hover" id="TablaDetalleIntroduccion">
                                <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Variedad</th>
                                    <th>Identificador</th>
                                    <th>Cantidad Etiquetas</th>
                                    <th>Contenedor</th>
                                    <th>Tipo Introducción</th>

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

                            <label>Cantidad Total Etiquetas</label>
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

    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
    <script>

        let array = [];
        let countRow = 0;
        let countRowD = 1;
        $(document).ready(function () {
            let token = $('#token').val();
            $("#CrearRegistro").click(function () {
                let VariedadCodigo = $('#IDVariedad').val();
                let TipoIntro = $('#TIntro').val();
                let ValTipoIntro = $('select[name="TIntro"] option:selected').text();
                let Cantidad = $('#Cantidad').val();
                let ClienteyIndicatico = $('#id_cliente').val();
                //let Contenedor = $('#IDContenedor').val();
                let nameVariedad = $('select[name="IDVariedad"] option:selected').text();
                let NameCliente = $('select[name="id_cliente"] option:selected').text();
                let Comentario = $('#Comentario').val();
                let intro = $('#semaIntro').val();
                //let NameContenedor = $('select[name="IDContenedor"] option:selected').text();
                //alert(TipoIntro);

                //console.log(intro);
                /* var now = new Date(), i = 0, f, sem = (new Date(now.getFullYear(), 0, 1).getDay() > 0) ? 1 : 0;
                 while ((f = new Date(now.getFullYear(), 0, ++i)) < now) {
                     if (!f.getDay()) {
                         sem++;
                     }
                 }*/
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

                if (intro.length <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Semana Incorrecta',
                    });
                } else if (Cantidad <= 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Cantidad Incorrecta',
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
                } else if (TipoIntro === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Tipo de introduccion',
                    });
                } else {
                    if (idCliente.length > 0) {
                        $('#tablaMostrar').show();
                        $($('#id_cliente')).attr('disabled', true);
                        var week = intro.split("-W");
                        let add = '<tbody>' +
                            '<tr>' +
                            '<td style="text-align: center">' + countRowD + '</td>' +
                            '<td>' + NameCliente + '</td>' +
                            '<td>' + nameVariedad + '</td>' +
                            '<td style="text-align: center">' + Cantidad + '</td>' +
                            '<td style="text-align: center">' + ValTipoIntro + '</td>' +
                            '<td style="text-align: center">' + Indicativo + Codigo + week[0] + week[1] + '</td>' +
                            '<td style="text-align: center"><a class="btn btn-danger" title="Eliminar" onclick="EliminarFila(this,' + countRow + ')" style="position: center"><i class="fa fa-trash"></i></a></td>' +
                            '</tr>' +
                            '</tbody>';

                        $('#TablaIntroduccion').append(add);
                        $('#Cantidad').val('');
                        $('#Comentario').val('');
                        $('.selectpicker').selectpicker('render');
                        $('#IDContenedor').selectpicker('render');
                        let identificador = Indicativo + Codigo + week[0] + week[1];
                        array[countRow] = {IdVariedad, Cantidad, idCliente, Comentario, identificador, TipoIntro};
                        countRow++;
                        countRowD++;
                        array = array.filter(function (e) {
                            return e
                        });
                    }
                }
            });

            $('#NewIntroduccion').submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    dataType: 'json',
                    data: {array},//{datosformulario:{dataString},datostabla:array},//datos que envi
                    url: "{{ route('NewIntroduccion') }}",
                    type: 'POST',
                    success: function (Result) {
                        //console.log(Result.data);
                        if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                            $("#NewIntroduccion")[0].reset();//limpio formulario
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
            array.splice(fila, 1);
           // $(v).deleteRow(v);
        }


        $('#ViewIntroducciones').DataTable({
            // dom: "Bfrtip",
            paging: false,
            "language": {
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                "Previous": "Anterior",
            },
        });


        $("#CargarIntroducciones").on('click', function () {
            // alert('algo paso');
            let token = $('#token').val();
            let FeIncial = $('#idInicialdate').val();
            let FeFinal = $('#idFinaldate').val();
            let count = 1;
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {FeIncial: FeIncial, FeFinal: FeFinal},
                url: "{{ route('ConsultaIntroducciones') }}",
                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.data, function (index, value) {

                        /* Vamos agregando a nuestra tabla las filas necesarias */
                        //console.log(Result.total.CantidadTotal);
                        tbHtml += '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.Nombre + '</td>' +
                            '<td>' + value.CodIntroducion + '</td>' +
                            '<td class="text-center" style="align-content: center">' +
                            '<a type="button" class="btn btn-success btn-circle btn-sm" onclick="DetallesD(' + value.CodIntroducion + ')"><i data-toggle="tooltip" title="Detalles" class="fa fa-info"></i></a> ' +

                            '</tr>';
                        count++;
                    });
                    $('#TablaReporteIntro tbody').html(tbHtml);
                },
            });
        })

        /*detalles de introducciones faltantes por imprimir*/
        $('.Detalles').on('click', function () {
            let token = $('#token').val();
            let Detalles = $(this).data('whatever');
            //console.log(Detalles.Detalles.CodIntroducion);
            let CodigoIntro = Detalles.Detalles.CodIntroducion;
            let count = 1;
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {CodigoIntro: CodigoIntro},
                url: "{{ route('DetallesIntroducion') }}",
                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.data, function (index, value) {

                        let fase = value.IdTipoFase;
                        if (fase === '1') {
                            fase = 'Adaptado';
                        } else {
                            fase = 'Invitro';
                        }

                        /* Vamos agregando a nuestra tabla las filas necesarias */
                        //console.log(Result.total.CantidadTotal);
                        tbHtml += '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.Nombre_Variedad + '</td>' +
                            '<td>' + value.Identificador + '</td>' +
                            '<td>' + value.Cantidad + '</td>' +
                            '<td>' + value.TipoContenedor + '</td>' +
                            '<td><label>' + fase + '</label></td>' +
                            '</tr>';
                        count++;

                        $('#CantidadTotal').val(Result.total.CantidadTotal);
                    });
                    $('#TablaDetalleIntroduccion tbody').html(tbHtml);
                },
            });
        });

        /*detalles de la tabla de consulta*/
        function DetallesD($cod) {
            //alert($cod);
            let token = $('#token').val();
            let count = 1;

            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {CodigoIntro: $cod},
                url: "{{ route('DetallesIntroducion') }}",
                type: 'post',

                success: function (Result) {
                    var tbHtml = '';
                    $.each(Result.data, function (index, value) {
                        let fase = value.IdTipoFase;
                        if (fase === '1') {
                            fase = 'Adaptado';
                        } else {
                            fase = 'Invitro';
                        }

                        /!* Vamos agregando a nuestra tabla las filas necesarias *!/
                        //console.log(Result.total.CantidadTotal);
                        tbHtml += '<tr>' +
                            '<td>' + count + '</td>' +
                            '<td>' + value.Nombre_Variedad + '</td>' +
                            '<td>' + value.Identificador + '</td>' +
                            '<td>' + value.Cantidad + '</td>' +
                            '<td>' + value.TipoContenedor + '</td>' +
                            '<td><label>' + fase + '</label></td>' +
                            '</tr>';
                        count++;

                        $('#CantidadTotal').val(Result.total.CantidadTotal);
                    });
                    $('#TablaDetalleIntroduccion tbody').html(tbHtml);
                    $("#DetallesIntroduccion").modal();
                },
            });
        }
    </script>
@endsection
