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

    <div class="content-header col-lg-12" style="margin-top: 20px">
        <div class="card card-primary card-outline col-lg-12">
            <div style="margin-top:15px; display: flex; justify-content:center; align-items: center;">

                <h4>Lectura Salida</h4>
            </div>
            <hr>

            <form id="LecturaSalidaRenewalCFProd" method="post" action="{{ route('LecturaSalidaRenewalCFProd') }}">
                <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">

                <div class="box box-body col-lg-12">

                    <div class="col-lg-12 ">
                        <div class="row">
                            <div class="col-lg-4 ">
                                <label>Codigo de Barras Caja</label>
                                <div class="input-group input-group-sm">
                                    <input type="text-" class="labelform form-control" autocomplete="off"
                                           id="BarcodeCaja" required name="BarcodeCaja">
                                    <span class="input-group-append">
                                    <button type="reset" class="btn btn-info btn-flat" id="reset">
                                        <i class="fas fa-spinner"></i>
                                    </button>
                                </span>
                                </div>
                            </div>

                            <div class="col-lg-4 ">
                                <label>Codigo de Barras</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="labelform form-control" autocomplete="off" id="Barcode"
                                           required
                                           name="Barcode">
                                </div>
                            </div>
                            <div class="col-lg-4 ">

                                <img src="{{ asset('Principal/img/counter.png') }}" height="25" width="25">
                                <label>Contador</label>
                                <div class="input-group input-group-sm">
                                    <input style="position: center; text-align: center;" placeholder="0"
                                           class="labelform form-control" id="count" disabled>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div id="ErrorDiv" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>ERROR BARCODE</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                    <div id="BarcodeNoInventario" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>BARCODE NO ESTA EN INVENTARIO</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                    <div id="BarcodeYaleido" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>BARCODE YA FUE LEIDO</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                    <div id="BarcodeNoLeidoEntradas" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>BARCODE NO LEIDO EN ENTRADAS</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                    <div id="BarcodeDosHoras" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>TIEMPO EN CUARTO FRIO MENOR A 2 HORAS</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                    <div id="BarcodeNoCaja" class="col-lg-12 " style="margin-top: 10px; display: none">
                        <div class="col-lg-4 "></div>
                        <div class="alert-danger col-lg-4 "
                             style="display: flex; justify-content:center; align-items: center;">
                            <label>CODIGO DE BARRAS NO PERTENECE A LA CAJA</label>
                        </div>
                        <div class="col-lg-4 "></div>
                    </div>
                </div>
                <button style="display: none" type="submit">guardar</button>
            </form>
        </div>
    </div>
    <div class="card card-primary card-outline col-lg-12">
        <div class="">
            <div class="box box-body col-lg-12">
                <div style="margin-top:20px; display: flex; justify-content:center; align-items: center;">
                    <h4>Ultima Lectura</h4>
                </div>
                <hr>

                <div class="col-lg-12">

                    <div class="dataTables_wrapper dt-bootstrap4">
                        <div class="table" style="margin-left: 1px">
                            <table class="table-bordered table-striped dataTable scroll" id="TableCodigosBarras"
                                   style="width:100%">
                                <thead class="bg-blue-gradient" style="width: 100%">
                                <tr>
                                    <th>Variedad</th>
                                    <th>Cant. Necesaria</th>
                                    <th>Cant. Inventario</th>
                                    <th>Cant. Empacada</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

                {{-- <span id="count"></span>--}}
                <audio id="error">
                    <source src="{{asset('sonido/alerta.mp3')}}" type="audio/ogg">
                </audio>
            </div>
        </div>

        <script>
            let cout = 1;
            $(document).ready(function () {
                $("#BarcodeCaja").focus();
                /*document.getElementById("Barcode").focus();
                $("input:text:visible:first").focus();*/

                $('#reset').click(function () {
                    $("#BarcodeCaja").focus();
                });
            });

            $('#LecturaSalidaRenewalCFProd').submit(function (event) {
                event.preventDefault();
                let DatosEviados = $('#LecturaSalidaRenewalCFProd').serialize();//paso todos los datos del form a una variable
                let barcode = $("#Barcode").val();//asigno input a una variable para validar
                let token = $('#token').val();//valido el token

                let caja = $("#Barcode").val();

                if (barcode.length === 9) {
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $("#Barcode").val('');//limpio campo

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        dataType: 'json',
                        data: DatosEviados,//datos que envio
                        url: '/LecturaSalidaRenewalCFProd',//ruto post
                        type: 'post',
                        success: function (Result) {
                            if (Result.data === 1) {
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').hide();
                                $('#Barcode').css('border-color', '');
                                $('#BarcodeLeido').css('border-color', '');
                                $('#caja').val(Result.ultimalectura.Caja);

                                var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);

                                $('#count').val(cout);
                                cout++;
                            } else if (Result.data === 2) {
                                $('#error')[0].play();
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').show();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').hide();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');

                                //var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);

                            } else if (Result.data === 3) {
                                $('#error')[0].play();
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').show();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').hide();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');

                                //var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);
                            } else if (Result.data === 4) {
                                $('#error')[0].play();
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').show();
                                $('#BarcodeNoCaja').hide();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');

                                //var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);
                            } else if (Result.data === 5) {
                                $('#error')[0].play();
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').show();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');

                                //var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);
                            } else {
                                $('#error')[0].play();
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').show();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').hide();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');

                                //var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            $.each(error.responseJSON.errors, function (i, item) {
                                alertify.error(item)
                            });
                        }
                    });
                } else if (barcode.length === 10) {
                    $('#ErrorDiv').hide();//si es bien no muestre
                    $('#BarcodeYaleido').hide();
                    $("#Barcode").val('');//limpio campo

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},//toekn
                        dataType: 'json',
                        data: DatosEviados,//datos que envio
                        url: '/LecturaSalidaRenewalCFProd',//ruto post
                        type: 'post',
                        success: function (Result) {
                            if (Result.data === 1) {
                                console.log()
                                $('#ErrorDiv').hide();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $('#BarcodeNoCaja').hide();
                                $('#Barcode').css('border-color', '');
                                $('#BarcodeLeido').css('border-color', '');
                                $('#caja').val(Result.ultimalectura.Caja);

                                var tbHtml = '';
                                $.each(Result.detallecaja, function (i, item) {
                                    //! Vamos agregando a nuestra tabla las filas necesarias !/
                                    tbHtml += '<tr>' +
                                        '<td>' + item.Nombre_Variedad + '</td>' +
                                        '<td>' + item.CantNecesaria + '</td>' +
                                        '<td>' + item.CantInventario + '</td>' +
                                        '<td>' + item.CantEmpacada + '</td>' +
                                        '</tr>';
                                });
                                $('#TableCodigosBarras tbody').html(tbHtml);

                                /*$('#count').val(cout);
                                cout++;*/
                            } else {
                                $('#error')[0].play();
                                $('#ErrorDiv').show();//si es bien no muestre
                                $('#BarcodeNoInventario').hide();//si es bien no muestre
                                $('#BarcodeYaleido').hide();
                                $('#BarcodeNoLeidoEntradas').hide();
                                $('#BarcodeDosHoras').hide();
                                $("#Barcode").val('');
                                $("#Barcode").css('border-color', 'red');
                                $('#VarLei').val('');
                                $('#Caja').val('');
                            }
                        },
                        error: function (e) {
                            console.log(e);
                            $.each(error.responseJSON.errors, function (i, item) {
                                alertify.error(item)
                            });
                        }
                    });
                    return true;
                } else {
                    $(document).ready(function () {
                        $('#error')[0].play();
                        $('#ErrorDiv').show();
                        $('#BarcodeNoInventario').hide();
                        $('#BarcodeYaleido').hide();
                        $('#BarcodeNoLeidoEntradas').hide();
                        $("#Barcode").val('');
                        $("#Barcode").css('border-color', 'red');
                        $('#VarLei').val('');
                        $('#Caja').val('');
                    });
                    return false;
                }
            });

        </script>

@endsection
