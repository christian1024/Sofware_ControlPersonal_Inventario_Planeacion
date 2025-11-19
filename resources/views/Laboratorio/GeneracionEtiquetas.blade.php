@extends('layouts.Principal')
@section('contenidoPrincipal')

    <style>
        hr {
            margin-top: -2px;
            margin-bottom: 20px;
            border: 0;
            border-top: 1px solid #3c8dbc;
        }

        .prueba {
            border-radius: 11px 11px 11px 11px;
            -moz-border-radius: 11px 11px 11px 11px;
            -webkit-border-radius: 11px 11px 11px 11px;
            background-color: #0a0a0a1f;
            text-align: center;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>

    <div class="col-lg-12">
        <div class="box box-body">
            <div class="col-lg-12">
                <div align="center"><h2>GENERAR ETIQUETAS DE INVENTARIO</h2></div>
            </div>
        </div>

        <div class="box box-primary">
            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
            <div class="col-lg-12 prueba">
                <div class="col-lg-12">
                    <label>Modo de Impresion</label>
                    <select class="labelform text-center" name="cambiar" id="cambiar">
                        <option selected="true" value="" disabled="disabled">Seleccione uno..</option>
                        <option value="Por Ubicacion" >Por Ubicacion</option>
                        <option value="Por Radicado" >Por Radicado</option>
                        {{--@foreach($TipSalidas as $TipSalida)
                            <option value="{{ $TipSalida->id }}"> {{ $TipSalida->TipoSalida_Ajuste }} </option>
                        @endforeach--}}
                    </select>
                </div>
            </div>
            <form method="get" action="{{ route('GenerarEtiquetasInventario') }}">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                <div id="Ubicacion" class="col-lg-12 box box-body" style="display: none">
                    <div class="col-lg-3">

                            <label for="Cuarto" class="control-label">{{ __('Cuarto') }}</label>

                            <select class="labelform form-control" required="required" name="IDCuarto" id="IDCuarto">
                                <option selected="true" value="" disabled="disabled">Seleccione Cuarto...</option>
                                @foreach( $cuartosAc as $cuartosAcv)
                                    <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                @endforeach
                            </select>

                    </div>
                    <div class="col-lg-3 ">
                            <label for="Estante" class="control-label">{{ __('Estante') }}</label>

                            <select class="labelform form-control" required="required" name="IDEstante" id="IDEstante">
                                <option selected="true" value="" disabled="disabled">Seleccione Estante...</option>

                            </select>
                    </div>
                    <div class="col-lg-3 ">
                            <label for="Cuarto" class="control-label">{{ __('Nivel') }}</label>

                            <select class="labelform form-control" required="required" name="IDPiso" id="IDPiso">
                                <option selected="true" value="" disabled="disabled">Seleccione Nivel...</option>

                            </select>
                    </div>
                    <div class="col-lg-3 ">
                            <label for="Cuarto" class="control-label">{{ __('Etapa') }}</label>

                            <select class="labelform form-control" required="required" name="id_Etapa" id="id_Etapa">
                                <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                @foreach( $etapas AS $etapa)
                                    <option value="{{ $etapa->id }}"> {{ $etapa->NombreFase }} </option>
                                @endforeach
                            </select>
                    </div>

                    <div id="GetEtiquetas" >
                        {{--<input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">--}}
                        <div class="col-lg-4"></div>
                        <div class="col-lg-4" style="margin-top: 20px">
                            <button type="submit" class="btn btn-success  btn-block"><i class="fa fa-barcode"></i>  Generar Etiquetas</button>
                        </div>
                    </div>
                </div>
            </form>
            <form method="get" action="{{ route('GenerarEtiquetasInventario1') }}">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                <div id="Radicado" class="col-lg-12 box box-body" style="display: none">
                    <div class="col-lg-3">

                            <label for="Cuarto" class="control-label">{{ __('# Radicado') }}</label>

                        <input type="text" class="labelform form-control" autocomplete="off" id="NumRadicado" required name="NumRadicado">

                    </div>

                    <div id="GetEtiquetas1" >
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                        <div class="col-lg-4"></div>
                        <div class="col-lg-4" style="margin-top: 20px">
                            <button type="submit" class="btn btn-success  btn-block"><i class="fa fa-barcode"></i>  Generar Etiquetas</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <script>
        let cout = 1;
        $('#IDCuarto').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/CuartoEtiquetas/' + this.value + '/Cuarto',
                success: function (Result) {
                    console.log(Result);
                    $("#IDEstante").empty().selectpicker('destroy');
                    $("#IDEstante").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEstante").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                    });
                    $('#IDEstante').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDEstante').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/EstanteEtiquetas/' + this.value + '/Estante',
                success: function (Result) {
                    console.log(Result);
                    $("#IDPiso").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDPiso").append('<option value="' + item.id + '">' + item.N_Nivel + '</option>');
                    });
                    $('#IDPiso').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        function justNumbers(e) {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;

            return /\d/.test(String.fromCharCode(keynum));
        }

        $('#cambiar').change(function () {
            let valorCambiado = $(this).val();
            if (valorCambiado == 'Por Ubicacion') {
                $('#Ubicacion').show();
                $('#Radicado').hide();
            } else if (valorCambiado == 'Por Radicado') {
                $('#Ubicacion').hide();
                $('#Radicado').show();
            }
        });

        @if(session()->has('creado'))
        $(document).ready(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["success"]("Etiquetas Generadas Correctamente");
            /*window.location.href = '/GenerarEtiquetas';*/
        });
        @endif

        @if(session()->has('existe'))
        $(document).ready(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["error"]("Numero de Radicado No Existente");
            /*window.location.href = '/Barcode';*/
        });
        @endif

        @if(session()->has('impreso'))
        $(document).ready(function () {
            toastr.options = {
                "closeButton": false,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-center",
                "preventDuplicates": false,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };
            toastr["error"]("Etiquetas ya Impresas");
            /*window.location.href = '/Barcode';*/
        });
        @endif

    </script>
@endsection
