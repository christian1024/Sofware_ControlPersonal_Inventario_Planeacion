@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        @can('VistaIntroducciones')
            <div class="col-lg-12">
                <div id="tabs" class="col-md-12 col-lg-12 col-xs-12 box box-body spaceTap" style="margin-top:10px;">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        @can('NuevaIntroduccionfutura')
                            <li>
                                <a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#crearIntroduccion"><span>Nueva Introducción Futura</span></a>
                            </li>
                        @endcan
                        @can('ListaIntroduccionesFuturas')
                            <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#VerIntroducciones"><span>Introducciones Futuras creadas</span></a></li>
                        @endcan

                    </ul>
                    <div class="tab-content" id="myTabContent">
                        @can('NuevaIntroducciones')
                            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab" id="crearIntroduccion">
                                <div class="card">
                                    <form id="NewIntroduccion" method="POST" action="{{ route('NewIntroduccion') }}">
                                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                                        <div class="card card-body text-center">
                                            <h3>Introducción Futura</h3>
                                        </div>

                                        <div class="card card-body">
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
                                                        <label for="" class="col-form-label text-md-right">{{ __('Variedad') }}</label>
                                                        <select class="form-control labelform selectpicker" data-live-search="true" name="IDVariedad" id="IDVariedad">
                                                            <option selected="true" value="0" id="select" disabled="disabled">N/A</option>
                                                            @foreach($variedades as $variedad)
                                                                <option value="{{ $variedad->id }}">{{ $variedad->Codigo }} {{ $variedad->Nombre_Variedad }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="" class="col-form-label text-md-right">{{ __('Genero') }}</label>
                                                        <select class="form-control labelform selectpicker" data-live-search="true" name="IDGenero" id="IDGenero">
                                                            <option selected="true" value="0" id="select" disabled="disabled">N/A</option>
                                                            @foreach($Generos as $Genero)
                                                                <option value="{{ $Genero->id }}">{{ $Genero->NombreGenero }} </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="" class="col-form-label text-md-right">{{ __('Cantidad') }}</label>
                                                        <input type="number" name="Cantidad" min="1" value="0" id="Cantidad" class="form-control labelform">
                                                    </div>
                                                </div>
                                            </div>


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
                                                                <td>week</td>
                                                                <td>cliente</td>
                                                                <td>Variedad</td>
                                                                <td>Genero</td>
                                                                <td>Cantidad</td>
                                                                <td>Tipo Intro</td>
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
                                            <table id="ViewIntroduccionesFuturas" class="table table-hover table-bordered" style="width:100%;">
                                                <thead>
                                                <tr>
                                                    <td>Semana Ingreso </td>
                                                    <td>cliente</td>
                                                    <td>Variedad</td>
                                                    <td>Genero</td>
                                                    <td>Cantidad</td>
                                                    <td>Tipo Intro</td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($introducionesfuturas as $introfut)
                                                    <tr>
                                                        <td>{{ $introfut->SemanaIntroduccion}}</td>
                                                        <td>{{ $introfut->Nombre}}</td>
                                                        <td>{{ $introfut->Nombre_Variedad}}</td>
                                                        <td>{{ $introfut->NombreGenero}}</td>
                                                        <td>{{ $introfut->Cantidad}}</td>
                                                        <td>{{ $introfut->TipoIntroduccion}}</td>

                                                    </tr>
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
            </div>
    </div>
    @endcan


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
                let nameVariedad = $('select[name="IDVariedad"] option:selected').text();
                let IDGenero = $('select[name="IDGenero"] option:selected').text();
                let IDGeneroD = $('#IDGenero').val();
                let NameCliente = $('select[name="id_cliente"] option:selected').text();
                let intro = $('#semaIntro').val();

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
                } else if (NameCliente === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione Cliente',
                    });
                }else if (IDGenero === 'N/A' && nameVariedad==='N/A') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Selecciones Genero o Especie',
                    });
                }

                else if (NameCliente === 'Seleccione.....') {
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
                        //$($('#id_cliente')).attr('disabled', true);
                        let add = '<tbody>' +
                            '<tr>' +
                            '<td style="text-align: center">' + countRowD + '</td>' +
                            '<td>' + intro + '</td>' +
                            '<td>' + NameCliente + '</td>' +
                            '<td>' + nameVariedad + '</td>' +
                            '<td>' + IDGenero + '</td>' +
                            '<td style="text-align: center">' + Cantidad + '</td>' +
                            '<td style="text-align: center">' + ValTipoIntro + '</td>' +
                            '<td style="text-align: center"><a class="btn btn-danger" title="Eliminar" onclick="EliminarFila(this,' + countRow + ')" style="position: center"><i class="fa fa-trash"></i></a></td>' +
                            '</tr>' +
                            '</tbody>';

                        $('#TablaIntroduccion').append(add);
                        $('#Cantidad').val('');
                        $('.selectpicker').selectpicker('render');
                        $('#IDContenedor').selectpicker('render');

                        array[countRow] = {intro, IdVariedad, IDGeneroD, Cantidad, idCliente, ValTipoIntro};
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
                    url: "{{ route('GuarddarIntroduciconesFuturas') }}",
                    type: 'POST',
                    success: function (Result) {
                        //console.log(Result.data);
                        if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                            $("#NewIntroduccion")[0].reset();//limpio formulario
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Datos Guardados Exitosamente',
                                showConfirmButton: false,
                                timer: 13500
                            });
                            location.reload();

                        } else {
                            Swal.fire({
                                position: 'center',
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


        $('#ViewIntroduccionesFuturas').DataTable({
            // dom: "Bfrtip",
            dom: "Bfrtip",
            "paging": true,
            buttons: [
                'excel'
            ],
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "zeroRecords": "No hay registros disponibles",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Buscar:",
                "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
        });




    </script>
@endsection
