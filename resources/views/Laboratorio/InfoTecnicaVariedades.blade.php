@extends('layouts.Principal')
@section('contenidoPrincipal')
    <style>
        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }
    </style>
    @can('verInfoTecnica')
        <div class="card">
            <div>
                <h3>Información Tecnica</h3>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    @can('verInfoTecnica')
                        <li><a class="nav-link active" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Infotecnica"><span>Estructurar Variedad</span></a></li>
                    @endcan
                    @can('InfoTecVarContenedor')
                        <li><a class="nav-link" id="home-tab" data-toggle="tab" role="tab" aria-controls="home" aria-selected="true" href="#Infotiposfrascos"><span>Estructurar Tipos Frascos</span></a></li>
                    @endcan
                </ul>
                <hr>
                <div class="tab-content" id="myTabContent">

                    @can('verInfoTecnica')
                        <div id="Infotecnica" class="tab-pane fade show active" role="tabpanel" aria-labelledby="home-tab">
                            <form action="{{ route('GuardarInfotecnicaLaboratorio') }}" method="post">
                                @csrf
                                <input type="hidden" name="total" id="total">
                                <div class="row">
                                    <div class="col-5">
                                        <div class="form-group">
                                            <label class=" control-label">Variedad</label>
                                            <select class="selectpicker" data-show-subtext="true" name="idVariedad" id="variedad" data-live-search="true" required="required">
                                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                                @foreach($VariedadesActivas as $VariedadesActiva)
                                                    <option value="{{ $VariedadesActiva->id }}">
                                                        {{ $VariedadesActiva->Codigo }}
                                                        {{ $VariedadesActiva->Nombre_Variedad }}
                                                        {{ $VariedadesActiva->NombreGenero }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            {{--<button id="Cargar" type="button" class="btn btn-success">Cargar</button>--}}
                                        </div>
                                    </div>
                                    <div id="InfoTableVarie" style="display: none">
                                        <table class="col-12">
                                            <thead>
                                            <tr>
                                                <th scope="col">Genero</th>
                                                <th scope="col">Variedad</th>
                                                <th scope="col">Codigo</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr class="info">
                                                <td><input type="text" disabled class="form-control labelform" id="Genero"></td>
                                                <td><input type="text" disabled class="form-control labelform" id="Variedad"></td>
                                                <td><input type="text" disabled class="form-control labelform" id="Codigo"></td>
                                            </tr>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="panel-primary">
                                        <div class="card">
                                            <table id="TableVariedadesActivas" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                                <thead class="bg-blue-gradient">
                                                <tr>
                                                    <th></th>
                                                    <th>Fase</th>
                                                    <th>Coeficiente Multiplicacion</th>
                                                    <th>Porcentaje Perdida</th>
                                                    <th>Porcentaje Por Fase</th>
                                                    <th>Semanas por fase</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    @can('Modificarinfotecnica')
                                        <div class="col-lg-12" id="guardarIn" style="display: none">

                                            <button class="btn-lg btn-block btn btn-outline-success">Guardar</button>


                                        </div>
                                    @endcan
                                </div>
                            </form>
                        </div>
                    @endcan
                    @can('InfoTecVarContenedor')
                        <div id="Infotiposfrascos" class="tab-pane fade show" role="tabpanel" aria-labelledby="home-tab">

                            <input type="hidden" name="total1" id="total1">
                            <div class="row">
                                <div class="col-5">
                                    <label for="ejemplo_email_3" class="control-label">Variedad</label>
                                    <select class="selectpicker" data-show-subtext="true" name="idVariedad" id="variedadfrasco" data-live-search="true" required="required">
                                        <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                        @foreach($VariedadesActivas as $VariedadesActiva)
                                            <option value="{{ $VariedadesActiva->id }}">
                                                {{ $VariedadesActiva->Codigo }}
                                                {{ $VariedadesActiva->Nombre_Variedad }}
                                                {{ $VariedadesActiva->NombreGenero }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{--<div class="form-group">
                                        <label class="col-lg-2 control-label">Identificador</label>
                                        <div class="col-lg-3">
                                            <input type="text" disabled class="form-control labelform" id="Datos1" placeholder="Identificador">
                                        </div>
                                    </div>--}}
                                </div>
                                <div id="InfoTableFrascos" style="display: none">
                                    <table class="col-lg-12">
                                        <thead>
                                        <tr>
                                            <th scope="col">Genero</th>
                                            <th scope="col">Variedad</th>
                                            <th scope="col">Codigo</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="info">
                                            <td><input type="text" disabled class="form-control labelform" id="Genero2"></td>
                                            <td><input type="text" disabled class="form-control labelform" id="Variedad2"></td>
                                            <td><input type="text" disabled class="form-control labelform" id="Codigo2"></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="panel-info">
                                    <div class="card">
                                        <table id="TableVariedadesActivas1" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                            <thead class="bg-blue-gradient">
                                            <tr>
                                                <th></th>
                                                <th>Fase</th>
                                                <th>Tipo Frasco Actual</th>
                                                <th>Cantidad Frasco</th>
                                                @can('ModificarInfoPorcontenedor')
                                                    <th>Accion</th>
                                                @endcan
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
        @can('ModificarInfoPorcontenedor')
            <div id="editarfrascos" class="modal fade" role="dialog">
                <form action="{{ route('GuardarInfoTecnicaFrascos') }}" method="post" id="GuardarInfoTecnicaFrascos">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="modal-dialog modal-md">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title"><i class="fa fa-flask" style="font-size: 40px; color: #0b97c4"></i> Editar Tipo Frasco</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body row">
                                <div class="col-lg-6">
                                    <label>Fase</label>
                                    <input id="NombreFase" name="Fase" class="form-control labelform" disabled>
                                    <input id="FaseMod" type="hidden" class="form-control labelform" name="FaseMod" required autofocus>
                                </div>

                                <div class="col-lg-6">
                                    <label>Variedad</label>
                                    <input id="NombreVarieda" name="Varieda" class="form-control labelform" disabled>
                                    <input id="VarMod" type="hidden" class="form-control labelform" name="VarMod" required autofocus>
                                </div>
                            </div>
                            <div class="">
                                <label for="frascos" class="col-lg-4 control-label">Tipos de Frascos</label>
                                <div class="col-lg-5">
                                    <select class="selectpicker" data-show-subtext="true" name="idFrascos" id="Frascos" data-live-search="true" required="required">
                                        <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                        @foreach( $tiposfrascos as $frascos)
                                            <option value="{{ $frascos->id }}"> {{$frascos->TipoContenedor }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="col-lg-12" id="guardarInFra">
                                    <div class="col-lg-9"></div>
                                    <div class="col-lg-3">
                                        <button class="btn btn-success  btn-lg btn-block" type="button" id="guardarFra">Guardar</button>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </form>
            </div>
        @endcan
        <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">
    @endcan
    <script>

        $(document).ready(function () {
            let indicador = 0;
            let indicador2 = 0;
            let token = $('#token').val();
            $('#variedad').change(function (event) {
                event.preventDefault();
                let valor = $('#variedad').val();
                //console.log(valor);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {valor: valor},
                    url: "{{ route('DetalleInfoTecnicaVar') }}",
                    type: 'post',

                    success: function (Result) {
                        var tbHtml = '';
                        $.each(Result.data, function (index, value) {
                            //console.log(Result.data.Codigo);
                            /* Vamos agregando a nuestra tabla las filas necesarias */
                            tbHtml += '<tr>' +
                                '<td><input type="hidden" name="Id_Fase-' + indicador + '" value="' + value.id_fase + '"></td>' +
                                '<td>' + value.NombreFase + '</td>' +
                                '<td><input name="CoeficienteMultiplicacion-' + indicador + '" value="' + value.CoeficienteMultiplicacion + '"></td>' +
                                '<td><input name="PorcentajePerdida-' + indicador + '" value="' + value.PorcentajePerdida + '"></td>' +
                                '<td><input name="PorcentajePerdidaFase-' + indicador + '" value="' + value.PorcentajePerdidaFase + '"></td>' +
                                '<td><input name="SemanasXFase-' + indicador + '" value="' + value.SemanasXFase + '"></td>' +
                                '</tr>';
                            indicador++;
                            $('#total').val(indicador);
                            $('#Genero').val(value.NombreGenero);
                            $('#Variedad').val(value.Nombre_Variedad);
                            $('#Codigo').val(value.Codigo);
                            $('#InfoTableVarie').show();

                            //$('#Datos').val(value.Codigo + ' ' + value.Nombre_Variedad);

                        });
                        $('#TableVariedadesActivas tbody').html(tbHtml);
                    },
                });
                $('#guardarIn').show();
            });

            $('#variedadfrasco').change(function (event) {
                event.preventDefault();
                let valor = $('#variedadfrasco').val();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {valor: valor},
                    url: "{{ route('DetalleInfoTecnicaVarFrasco') }}",
                    type: 'post',

                    success: function (Result) {
                        var tbHtml = '';
                        $.each(Result.data, function (index, value) {
                            /* Vamos agregando a nuestra tabla las filas necesarias */
                            tbHtml += '<tr>' +
                                '<td><input type="hidden" name="Id_Fase-' + indicador2 + '" value="' + value.id_fase + '"></td>' +
                                '<td>' + value.NombreFase + '</td>' +
                                '<td>' + value.TipoContenedor + '</td>' +
                                '<td>' + value.Cantidad + '</td>' +
                                '@can('ModificarInfoPorcontenedor')' +
                                '<td> ' +
                                '<button class="btn btn-primary btn-circle btn-sm" onclick="ActualizarCon(' + value.id_fase + ',' + "'" + value.NombreFase + "'" + ',' + "'" + value.Nombre_Variedad + "'" + ',' + value.id + ')">' +
                                '<i data-toggle="tooltip" data-placement="left" title="Modificar Frasco" class="fa fa-edit"></i>'
                            '</button>' +
                            '</td>' +
                            '@endcan' +
                            '</tr>';
                            indicador2++;
                            $('#total1').val(indicador2);
                            $('#Genero2').val(value.NombreGenero);
                            $('#Variedad2').val(value.Nombre_Variedad);
                            $('#Codigo2').val(value.Codigo);
                            $('#InfoTableFrascos').show();
                            //$('#Datos1').val(value.Codigo + ' ' + value.Nombre_Variedad);

                        });
                        $('#TableVariedadesActivas1 tbody').html(tbHtml);
                    },
                });
            });


            $('#guardarFra').click(function (event) {
                event.preventDefault();
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: $('#GuardarInfoTecnicaFrascos').serialize(),
                    url: "{{ route('GuardarInfoTecnicaFrascos') }}",
                    type: 'post',

                    success: function (Result) {
                        if (Result.data === 1) {
                            $('#InfoTableFrascos').hide();
                            $('#editarfrascos').modal('hide');
                            iziToast.success({
                                //timeout: 20000,
                                title: 'Perfecto',
                                position: 'center',
                                message: 'Guardado Exitosamente',
                            });
                            let valor = $('#variedadfrasco').val();
                            //console.log(valor);
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': token},
                                data: {valor: valor},
                                url: "{{ route('DetalleInfoTecnicaVarFrasco') }}",
                                type: 'post',
                                success: function (Result) {
                                    var tbHtml = '';
                                    $.each(Result.data, function (index, value) {
                                        /* Vamos agregando a nuestra tabla las filas necesarias */
                                        tbHtml += '<tr>' +
                                            '<td><input type="hidden" name="Id_Fase-' + indicador2 + '" value="' + value.id_fase + '"></td>' +
                                            '<td>' + value.NombreFase + '</td>' +
                                            '<td>' + value.TipoContenedor + '</td>' +
                                            '<td>' + value.Cantidad + '</td>' +
                                            '@can('ModificarInfoPorcontenedor')' +
                                            '<td> ' +
                                            '<button class="btn btn-primary btn-circle btn-sm" onclick="ActualizarCon(' + value.id_fase + ',' + "'" + value.NombreFase + "'" + ',' + "'" + value.Nombre_Variedad + "'" + ',' + value.id + ')">' +
                                            '<i data-toggle="tooltip" data-placement="left" title="Modificar Frasco" class="fa fa-edit"></i>'
                                        '</button>' +
                                        '</td>' +
                                        '@endcan' +
                                        '</tr>';
                                        indicador2++;
                                        $('#total1').val(indicador2);
                                        $('#Genero2').val(value.NombreGenero);
                                        $('#Variedad2').val(value.Nombre_Variedad);
                                        $('#Codigo2').val(value.Codigo);
                                        $('#InfoTableFrascos').show();
                                        //$('#Datos1').val(value.Codigo + ' ' + value.Nombre_Variedad);
                                    });
                                    $('#TableVariedadesActivas1 tbody').html(tbHtml);
                                },
                            });
                        }
                    },
                });
            });

        });

        function ActualizarCon(idFase, nombreFase, nombrevar, idvar) {

            $('#editarfrascos').modal('show');
            $('#NombreFase').val(nombreFase);
            $('#NombreVarieda').val(nombrevar);
            $('#FaseMod').val(idFase);
            $('#VarMod').val(idvar);
        }

        @if(session()->has('creado'))
        $(document).ready(function () {
            iziToast.success({
                //timeout: 20000,
                title: 'Perfecto',
                position: 'center',
                message: 'Guardado Exitosamente',
            });
        });
        @endif


    </script>

@endsection
