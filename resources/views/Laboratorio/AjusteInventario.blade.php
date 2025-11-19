@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="col-lg-12">
            <h2 style="text-align: center">Ajuste De Inventario</h2>
        </div>
        <div class="card border-primary text-center">
            <div class="col-lg-12">
                <label>Tipo De Ajuste</label>
                <select class="labelform text-center" name="cambiar" id="cambiar">
                    <option selected="true" value="" disabled="disabled">Seleccione uno..</option>
                    @foreach( $TipInventarios as $TipInventario)
                        <option value="{{ $TipInventario->id }}"> {{ $TipInventario->TipoSalida_Ajuste }} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div id="RetornoInventario" style="display: none;">
            <div class="card border-secondary text-center">
                <div class="card-header"><h3>Retorno Inventario</h3></div>
                <div class="card-body">
                    <form id="LecAjusteInventarioRetorno" method="post" action="{{ route('LecAjusteInventarioRetorno') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <input type="hidden" value="2" name="id_TipoSalidaR">
                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label>Cuarto</label>
                                <select class="labelform form-control" required id="IDCuarto2" name="IDCuarto2">
                                    <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                    @foreach( $cuartosAc as $cuartosAcv)
                                        <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Estante</label>
                                <select class="labelform form-control" required id="IDEstante2" name="IDEstante2">
                                </select>


                            </div>
                            <div class="form-group col-lg-4">
                                <label>Nivel</label>
                                <select class="labelform form-control" id="IDPiso2" required name="IDPiso2">
                                </select>

                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-lg-4">
                                <label>Codigo de Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="BarcodeR" required name="BarcodeR">
                            </div>
                        </div>
                        <button style="display: none" type="submit">guardar</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="Traslado" style="display: none">
            <div class="card border-secondary text-center">
                <div class="card-header"><h3>Traslado</h3></div>
                <div class="card-body">
                    <form id="LecAjusteInventarioTraslado" method="post" action="{{ route('LecAjusteInventarioTraslado') }}">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <input type="hidden" value="3" name="id_TipoSalidaT">
                        <div class="form-row">
                            <div class="col-lg-4 form-group ">
                                <label>Cuarto</label>
                                <select class="labelform form-control" required id="IDCuarto3" name="IDCuartoT3">
                                    <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                    @foreach( $cuartosAc as $cuartosAcv)
                                        <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-4 form-group ">
                                <label>Estante</label>
                                <select class="labelform form-control" required id="IDEstante3" name="IDEstanteT3">
                                </select>

                            </div>

                            <div class="col-lg-4 form-group ">
                                <label>Nivel</label>
                                <select class="labelform form-control" id="IDPiso3" required name="IDPisoT3">
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group  col-lg-4 ">
                                <label>Codigo de Barras</label>
                                <input type="text" class="labelform form-control" autocomplete="off" id="BarcodeT" required name="BarcodeT">
                            </div>
                        </div>
                        <button style="display: none" type="submit">guardar</button>
                    </form>
                </div>
            </div>

        </div>
        <div id="ErrorDiv" class="col-lg-12 " style="display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>ERROR BARCODE SIN SALIDA O CON VIRUS</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>
        <div id="ErrorBarcode" class="col-lg-12 " style="display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>ERROR BARCODE</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>
        <div id="BarcodeYaleido" class="col-lg-12 " style="display: none">
            <div class="col-lg-4 "></div>
            <div class="alert-danger col-lg-4 " style="display: flex; justify-content:center; align-items: center;">
                <label>Ya Ubicado</label>
            </div>
            <div class="col-lg-4 "></div>
        </div>

    </div>


    <form id="DatosLeidos">
        <div class="text-center">

            <div class="card card-primary card-outline">

                <div style="display: flex; justify-content:center; align-items: center;">
                    <h4>Ultima Lectura</h4>
                </div>
                <hr>

                <div class="row">
                    <div class="col">
                        <div class="">
                            <i class="fa fa-barcode"><label> Codigo Barras</label></i>
                            <input id="BarcodeLeido" class="labelform form-group" disabled>
                        </div>
                        <div class="">
                            <i class="fab fa-pagelines"> <label> Variedad</label></i>
                            <input class="labelform form-group" id="VarLei" disabled>
                        </div>
                    </div>
                    <div class="col">
                        <div class="">
                            <i class="fa fa-user-circle"><label> Empleado</label></i>
                            <input class="labelform form-group" id="EmpleadoL" disabled>
                        </div>
                        <div class="">
                            <i class="fa fa-list"><label> Cantidad</label></i>
                            <input class="labelform form-group" id="Cantidalei" disabled>
                        </div>
                    </div>

                    <div class="col">
                        <div class="">
                            <i class="fa fa-user-circle"><label> Patinador</label></i>
                            <input class="labelform form-group" id="patinadorFinal" disabled>
                        </div>

                        <div class="">
                            <div class="">
                                <i class="fa fa-calculator"><label> Contador</label></i>
                                <input style="position: center; text-align: center;" placeholder="0" class="labelform form-group" id="count" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <span id="count"></span>--}}
                <audio id="error">
                    <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
                </audio>


            </div>


        </div>
    </form>

    <script>

        $('#cambiar').change(function () {
            let valorCambiado = $(this).val();
            $('#DatosLeidos').trigger("reset");
            if (valorCambiado == 1) {
                $('#AjusteInventario').show();
                $('#RetornoInventario').hide();
                $('#Traslado').hide();
                $('#BarcodeYaleido').hide();//si es bien no muestre
                $('#ErrorDiv').hide();
                $('#ErrorBarcode').hide();

            } else if (valorCambiado == 2) {
                $('#AjusteInventario').hide();
                $('#RetornoInventario').show();
                $('#Traslado').hide();
                $('#BarcodeYaleido').hide();//si es bien no muestre
                $('#ErrorDiv').hide();
                $('#ErrorBarcode').hide();
            } else if (valorCambiado == 3) {
                $('#AjusteInventario').hide();
                $('#RetornoInventario').hide();
                $('#Traslado').show();
                $('#BarcodeYaleido').hide();//si es bien no muestre
                $('#ErrorDiv').hide();
                $('#ErrorBarcode').hide();
            }
        });

        let cout = 1;
        let cout2 = 1;
        let cout3 = 1;
        $('#IDCuarto').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cuarto/' + this.value + '/Cuarto',
                success: function (Result) {

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
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDEstante').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Estante/' + this.value + '/Estante',
                success: function (Result) {

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
                    // console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDCuarto2').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cuarto/' + this.value + '/Cuarto',
                success: function (Result) {

                    $("#IDEstante2").empty().selectpicker('destroy');
                    $("#IDEstante2").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEstante2").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                    });
                    $('#IDEstante2').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDEstante2').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Estante/' + this.value + '/Estante',
                success: function (Result) {

                    $("#IDPiso2").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDPiso2").append('<option value="' + item.id + '">' + item.N_Nivel + '</option>');
                    });
                    $('#IDPiso2').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDCuarto3').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Cuarto/' + this.value + '/Cuarto',
                success: function (Result) {

                    $("#IDEstante3").empty().selectpicker('destroy');
                    $("#IDEstante3").append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                    $.each(Result.Data, function (i, item) {
                        $("#IDEstante3").append('<option value="' + item.id + '">' + item.N_Estante + '</option>');
                    });
                    $('#IDEstante3').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#IDEstante3').change(function () {
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                url: '/Estante/' + this.value + '/Estante',
                success: function (Result) {

                    $("#IDPiso3").empty().selectpicker('destroy');
                    $.each(Result.Data, function (i, item) {
                        $("#IDPiso3").append('<option value="' + item.id + '">' + item.N_Nivel + '</option>');
                    });
                    $('#IDPiso3').selectpicker({
                        size: 4,
                        liveSearch: true,
                    });
                },
                error: function (e) {
                    //console.log(e);
                    $.each(error.responseJSON.errors, function (i, item) {
                        alertify.error(item)
                    });
                }
            });
        });

        $('#LecAjusteInventarioTraslado').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecAjusteInventarioTraslado').serialize();
            let barcode = $("#BarcodeT").val();
            let token = $('#token').val();

            if (barcode.length >= 6 && barcode.length <= 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#BarcodeT").val('');//limpio campo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{ route('LecAjusteInventarioTraslado') }}",
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        // console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#BarcodeLeido').css('border-color', '');
                            $('#BarcodeLeido').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            /*$('#patinadorFinal').val(Result.consulta.Primer_Nombre + ' ' + Result.consulta.Segundo_Nombre + ' ' + Result.consulta.Primer_Apellido + ' ' + Result.consulta.Segundo_Apellido);*/
                            $('#count').val(cout2);
                            cout2++;
                        } else if (Result.data === 0) {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        } else if (Result.data === 2) {
                            $('#error')[0].play();
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'CODIGO NO HA SIDO INGRESADO',
                            })
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red');
                            $('#BarcodeYaleido').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorDiv').show();
                    $('#BarcodeYaleido').hide();
                    $("#BarcodeT").val('').css('border-color', 'red');

                });
                return false;
            }
        });

        $('#LecAjusteInventarioRetorno').submit(function (event) {
            event.preventDefault();
            let DatosEviados = $('#LecAjusteInventarioRetorno').serialize();
            let barcode = $("#BarcodeR").val();
            let token = $('#token').val();

            //console.log(DatosEviados);

            if (barcode.length === 9) { //valido ancho tanto minimo como maximo
                $('#ErrorDiv').hide();//si es bien no muestre
                $('#BarcodeYaleido').hide();
                $("#BarcodeR").val('');//limpio campo
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},//toekn
                    data: DatosEviados,//datos que envio
                    url: "{{ route('LecAjusteInventarioRetorno') }}",
                    type: 'post',
                    success: function (Result) {//que si la respuesa esta bien la guarde en result
                        console.log(Result);// si aqui lo muestra jaja
                        if (Result.data === 1) {
                            $('#BarcodeYaleido').hide();//si es bien no muestre
                            $('#ErrorBarcode').hide();
                            $('#BarcodeLeido').css('border-color', '').val(Result.barcode);
                            $('#patinadorFinal').val(Result.consulta[0].Primer_Nombre + ' ' + Result.consulta[0].Segundo_Nombre + ' ' + Result.consulta[0].Primer_Apellido + ' ' + Result.consulta[0].Segundo_Apellido);
                            $('#VarLei').val(Result.consulta[1].Nombre_Variedad);
                            $('#Cantidalei').val(Result.consulta[1].CantContenedor);
                            $('#EmpleadoL').val(Result.consulta[2].Primer_Nombre + ' ' + Result.consulta[2].Segundo_Nombre + ' ' + Result.consulta[2].Primer_Apellido + ' ' + Result.consulta[2].Segundo_Apellido);
                            /*$('#patinadorFinal').val(Result.consulta.Primer_Nombre + ' ' + Result.consulta.Segundo_Nombre + ' ' + Result.consulta.Primer_Apellido + ' ' + Result.consulta.Segundo_Apellido);*/
                            $('#count').val(cout3);
                            cout3++;
                        } else if (Result.data === 2) {
                            $('#BarcodeLeido').css('border-color', 'red').val(barcode);
                            $('#patinadorFinal').val('');
                            $('#VarLei').val('');
                            $('#Cantidalei').val('');
                            $('#EmpleadoL').val('');
                            $('#ErrorDiv').show();
                            $('#ErrorBarcode').hide();
                            $('#error')[0].play();
                        } else {
                            $('#BarcodeLeido').css('border-color', 'red').val(barcode);
                            $('#ErrorBarcode').show();
                            $('#ErrorDiv').hide();
                            $('#error')[0].play();
                        }
                    }
                });
                return true;
            } else {
                $(document).ready(function () {
                    $('#error')[0].play();
                    $('#ErrorBarcode').show();
                    $('#ErrorDiv').hide();
                    $("#BarcodeR").val('').css('border-color', 'red');
                    $('#BarcodeLeido').val(barcode);
                    $('#patinadorFinal').val('');
                    $('#VarLei').val('');
                    $('#Cantidalei').val('');
                    $('#EmpleadoL').val('');
                });
                return false;
            }
        });
    </script>
@endsection
