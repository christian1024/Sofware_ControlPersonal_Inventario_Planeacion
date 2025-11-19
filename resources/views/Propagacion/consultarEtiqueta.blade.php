@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="panel panel-primary">

            <div class="card border-primary">
                <div class="card-header card card-primary text-center" style="background-color:  #1a8cff">
                    <h3>Detalle Etiqueta</h3>
                </div>
                <div class="card-body text-primary">
                    <form id="CargarDatosCodigo">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="form-row">
                            <div class="col-lg-4">
                                <label>Codigo Barras</label>
                                <input type="text" minlength="9" maxlength="9" class="labelform form-control" autocomplete="off" id="CodigoBarras" required name="CodigoBarras">
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-success" type="submit" id="CargarProgramas">Cargar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="TablaDetalles" class="col-lg-12" style="display: none; margin-top: 25px">
                <form id="formularioGuardar">
                    @csrf
                    <div class="panel-primary">
                        <div class="box box-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <label for="" class="col-form-label text-md-right">{{ __('Plot ID Origen Nuevo') }}</label>
                                    <input type="number" maxlength="5" minlength="3" name="PlotIDOrigenNuevo" id="PlotIDOrigenNuevo" class="labelform">
                                </div>
                                <div class="col-lg-6">
                                    <label for="" class="col-form-label text-md-right">{{ __('Procedencia Nueva') }}</label>
                                    <input type="text" name="ProcedenciaNueva" id="ProcedenciaNueva" autocomplete="off" class="labelform">
                                </div>
                            </div>

                            <div class="box box-body" style="margin-top: 10px">
                                <table id="TablaDetallesCodigo" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                    <thead class="bg-blue-gradient">
                                    <tr>

                                        <th>Nombre_Variedad</th>
                                        <th>NombreGenero</th>
                                        <th>PlotIDNuevo</th>
                                        <th>PlotIDOrigen</th>
                                        <th>CodigoIntegracion</th>
                                        <th>CodigoBarras</th>
                                        <th>ProcedenciaInv</th>
                                        <th>SemaDespacho</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                                <div class="col-lg-12 box box-info" style="">
                                    <input type="hidden" name="IdCodigoBarras" id="IdCodigoBarras">
                                    <button class="btn btn-success btn-lg btn-block" style="margin-top: 25px" type="button" id="btnCambiar">Guardar</button>
                                </div>
                            </div>

                        </div>


                    </div>

                </form>
            </div>



        </div>


    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">
    <script>


        $(document).ready(function () {
            $("#CargarDatosCodigo").submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let DatosEviados = $('#CargarDatosCodigo').serialize();//paso todos los datos del for a una variable
                let Codigo = $('#CodigoBarras').val('')
                //console.log(DatosEviados);

                if (Codigo.length === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Verifique el Codigo',
                    });
                } else {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: DatosEviados,
                        url: '{{ route('DetallesEtiqueta') }}',
                        type: 'post',
                        success: function (Result) {
                            //console.log(Result)
                            var tbHtml = '';
                            $.each(Result.Data, function (index, value) {
                                $('#IdCodigoBarras').val(value.CodigoBarras)
                                tbHtml += '<tr>' +
                                    /*'<td>' + '<input type="checkbox" class="CheckedAK case" id="CheckedAK" name="CheckedAK[]" value="' + value.CodigoBarras + '">' + '</td>' +*/
                                    '<td>' + value.Nombre_Variedad + '</td>' +
                                    '<td>' + value.NombreGenero + '</td>' +
                                    '<td>' + value.PlotIDNuevo + '</td>' +
                                    '<td>' + value.PlotIDOrigen + '</td>' +
                                    '<td>' + value.CodigoIntegracion + '</td>' +
                                    '<td>' + value.CodigoBarras + '</td>' +
                                    '<td>' + value.ProcedenciaInv + '</td>' +
                                    '<td>' + value.SemaDespacho + '</td>' +
                                    '</tr>';

                            });
                            $('#TablaDetallesCodigo tbody').html(tbHtml);
                        },
                    });
                    $('#TablaDetalles').show();
                }

            });


            $("#btnCambiar").click(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let pLotidNuevo = $('#PlotIDOrigenNuevo').val();
                let ProcedenciaNueva = $('#ProcedenciaNueva').val();
                let DatosEviados = $('#formularioGuardar').serialize();//paso todos los datos del for a una variable
                $('#CodigoBarras').val('')

                if (pLotidNuevo.length >= '3' && pLotidNuevo.length <= '5' && ProcedenciaNueva.length >= '1') {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: DatosEviados,
                        url: '{{ route('UpdatePlotIdOrigen') }}',
                        type: 'post',
                        success: function (Result) {
                            if (Result.Data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Datos Guardados',
                                    showConfirmButton: false,
                                    timer: 13500
                                });
                                $('#TablaDetalles').hide();
                                $('#IdCodigoBarras').val('');
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Llame a sistemas algo salio mal',
                                });
                            }
                        }

                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops',
                        text: 'Revise sus datos',
                    });

                }
            });
        });

    </script>
@endsection

