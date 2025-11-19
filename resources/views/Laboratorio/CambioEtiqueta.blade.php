@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row">
        <div class="">
            <div class="card-header text-center"><h3>Migracion Etiqueta</h3></div>
            <div class="card-body">
                <div class="form-row">
                    <form id="CargarProgramas" method="POST" class="form-group col-lg-9" action="{{ route('CargarPrograma') }}">
                        <div class="form-row">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="form-group col-lg-3">
                                <label>Cuarto</label>
                                <select class="labelform form-control" required id="IDCuarto2" name="IDCuarto2">
                                    <option selected="true" value="" disabled="disabled">Seleccione Cuarto</option>
                                    @foreach( $cuartosAc as $cuartosAcv)
                                        <option value=" {{ $cuartosAcv->id }}"> {{ __('Cuarto') }} {{ $cuartosAcv->N_Cuarto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Estante</label>
                                <select class="labelform form-control" required id="IDEstante2" name="IDEstante2">

                                </select>
                            </div>
                            <div class="col-lg-3 col-lg-3 ">
                                <label>Nivel</label>
                                <select class="labelform form-control" id="IDPiso2" required name="IDPiso2">

                                </select>
                            </div>
                            <div class="col-lg-3 col-lg-3">
                                <button class="btn btn-success" type="submit" id="CargarProgramas">Cargar</button>
                            </div>
                        </div>
                    </form>
                    <div class="form-group col-lg-3">
                        <div class="" id="programas" style="display: none">
                            <label>Programas</label>
                            <select class="form-control" data-show-subtext="true" required id="SelectPorgramas" name="SelectPorgramas">
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-primary card-outline" id="TablaDetalles" style="display: none">
        <div class="col-lg-12">
            <form id="GuardarEtiquetasMigradas" action="{{ route('MigrarEtiqueta') }}" method="post">
                @csrf
                <div class="panel-primary">
                    <div class="card card-body ">
                        <div class="row">

                            <div class="col-lg-6">
                                <label>Cliente</label>
                                <select class="labelform form-control" required id="cliente" name="cliente">
                                    <option selected="true" value="" disabled="disabled">Seleccione Cliente</option>
                                    @foreach( $clientes as $cliente)
                                        <option value=" {{ $cliente->id }}"> {{ $cliente->Indicativo }}, {{ $cliente->Nombre }}</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="col-lg-3">
                                <label for="" class="col-form-label text-md-right">{{ __('Fecha Despacho') }}</label>
                                <input type="week" name="week" id="week" max="2030-W52" class="form-control labelform">
                            </div>

                            <div class="col-xs-3">
                                <input type="checkbox" id="EnviarStock" class="EnviarStock" name="EnviarStock" value="1">
                                <label for="subscribeNews">Enviar a Stock</label><br>
                                <input type="checkbox" id="EnviarMultiplicacion" class="EnviarMultiplicacion" name="EnviarMultiplicacion" value="2">
                                <label for="subscribeNews">Enviar a Multiplicacion</label><br>
                                <input type="checkbox" id="EnviarEnraizamiento" class="EnviarEnraizamiento" name="EnviarEnraizamiento" value="3">
                                <label for="subscribeNews">Enviar a Enraizamiento</label><br>
                            </div>
                        </div>
                    </div>
                    <div class="box box-body">
                        <label>Buscar</label>
                        <input type="text" id="search" placeholder="Escribe para buscar..."/>
                        <table id="TablaDetallesPrograma" class="table table-hover display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                            <thead class="bg-blue-gradient">
                            <tr>
                                <th><input id="checkboxAll" type="checkbox"/></th>
                                <th>Identificador</th>
                                <th>BarCode</th>
                                <th>TipoContenedor</th>
                                <th>SemanUltimoMovimiento</th>
                                <th>SemanaDespacho</th>
                                <th>Cliente</th>
                                <th>Fase</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>

                        </table>
                    </div>
                    <div class="col-lg-12">
                        <div class="col-lg-10">
                            <span style="color: red;"><h5></h5></span>

                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary" type="button" id="btnCambiar">Migrar</button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <form id="ConsultarEtiquetas" action="{{ route('ImprimirEtiquetasMigradas') }}" method="post" style="display: none">
        @csrf
        <input type="hidden" id="Datos" name="Datos">
        <input type="hidden" id="FechaNew" name="FechaNew">
        <input type="hidden" id="ClienteNew" name="ClienteNew">
    </form>

    <div class="modal fade bd-example-modal-lg" id="ModalCargar" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog modal-sm">
            <div id="loader" class="text-center" style="margin-top: 350px">
                <div class="spinner-grow text-primary" role="status">
                </div>
                <div class="spinner-grow text-secondary" role="status">
                </div>
                <div class="spinner-grow text-success" role="status">
                </div>
                <div class="spinner-grow text-danger" role="status">
                </div>
                <div class="spinner-grow text-warning" role="status">
                </div>
                <div class="spinner-grow text-info" role="status">
                </div>
                <div class="spinner-grow text-light" role="status">
                </div>
                <div class="spinner-grow text-dark" role="status">
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">
    <!-- Optional: include a polyfill for ES6 Promises for IE11 -->
    <script>
        $("#search").keyup(function () {
            _this = this;
            // Muestra los tr que concuerdan con la busqueda, y oculta los demás.
            $.each($("#TablaDetallesPrograma tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });

        $(document).ready(function () {
            let checked;
            let contador;

            $("#checkboxAll").on("click", function () {
                $(".case").prop("checked", this.checked);
            });

            $('#IDCuarto2').change(function () {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    url: '/Cuarto/' + this.value + '/Cuarto',
                    success: function (Result) {

                        $("#IDEstante2").empty().selectpicker('destroy').append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
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

                        $("#IDPiso2").empty().selectpicker('destroy').append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
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

            $("#CargarProgramas").submit(function (event) {
                event.preventDefault();
                let token = $('#token').val();
                let Cuarto = $('#IDCuarto2').val();
                let estante = $('#IDEstante2').val();
                let nivel = $('#IDPiso2').val();
                let dataform = {Cuarto: Cuarto, Estante: estante, Nivel: nivel};

                //console.log(dataform);
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: dataform,
                    url: '{{ route('CargarPrograma') }}',
                    type: 'post',
                    dataType: 'json',
                    success: function (Result) {
                        $("#SelectPorgramas").empty().selectpicker('destroy').append('<option selected="true" value="" disabled="disabled">Seleccione uno...</option>');
                        $.each(Result.Data, function (index, value) {
                            $('#programas').show();
                            //console.log(Result.Data);
                            //console.log(value.Indentificador);
                            $("#SelectPorgramas").append('<option value="' + value.CodigoVariedad + ',' + value.Indentificador + ',' + value.SemanaDespacho + ',' + value.SemanUltimoMovimiento + ',' + value.ID_FaseActual + '">' + value.Indentificador + ' CantPlan ' + value.CantidadPlantas + '</option>');
                        });
                    }
                });

            });

            $('#SelectPorgramas').change(function (event) {
                event.preventDefault();
                let valor = $('#SelectPorgramas').val();
                let token = $('#token').val();
                let Cuarto = $('#IDCuarto2').val();
                let estante = $('#IDEstante2').val();
                let nivel = $('#IDPiso2').val();
                let i = 0;


                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {valor: valor, Cuarto: Cuarto, estante: estante, nivel: nivel},
                    url: '{{ route('Detallesprogramas') }}',
                    type: 'post',

                    success: function (Result) {

                        var tbHtml = '';
                        $.each(Result.Data, function (index, value) {

                            tbHtml += '<tr>' +
                                '<td>' + '<input type="checkbox" class="CheckedAK case" id="CheckedAK" name="CheckedAK[]" value="' + value.BarCode + '">' + '</td>' +
                                '<td>' + value.Indentificador + '</td>' +
                                '<td>' + value.BarCode + '</td>' +
                                '<td>' + value.TipoContenedor + '</td>' +
                                '<td>' + value.SemanUltimoMovimiento + '</td>' +
                                '<td>' + value.SemanaDespacho + '</td>' +
                                '<td>' + value.Cliente + '</td>' +
                                '<td>' + value.NombreFase + '</td>' +
                                '</tr>';
                            i++;

                        });
                        $('#TablaDetallesPrograma tbody').html(tbHtml);

                    },
                });
                $('#TablaDetalles').show();

            });

            $(document).click(function () {
                checked = $(".CheckedAK:checked").length;
                //console.log(checked);
                $('#total').val(checked);
                $("h5").text("Tienes Actualmente " + checked + " Etiquetas " + "Seleccionadas");
            });

            $('#btnCambiar').click(function () {
                var arr = $('[name="CheckedAK[]"]:checked').map(function () {
                    return this.value;
                }).get();
                $('#ok').val(arr);
                if (arr.length > 0) {
                    let token = $('#token').val();
                    let checbocStock = ($('input:checkbox[name=EnviarStock]:checked').val());
                    let EnviarMultiplicacion = ($('input:checkbox[name=EnviarMultiplicacion]:checked').val());
                    let EnviarEnraizamiento = ($('input:checkbox[name=EnviarEnraizamiento]:checked').val());
                    let cliente = $('#cliente').val();
                    let week = $('#week').val();
                    let DatosEviados = $('#GuardarEtiquetasMigradas').serialize();
                    let Fecha;
                    if (week === '') {
                        Fecha = '';
                    } else {
                        var separador = "-W", // un espacio en blanco
                            year = week.split(separador)[0],
                            weeks = week.split(separador)[1];
                        Fecha = year + '' + weeks;
                    }

                    if (checbocStock === '1') {
                        //alert('entro a stock');

                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},
                            dataType: 'json',
                            data: DatosEviados,
                            url: "{{ route('MigrarEtiqueta') }}",
                            type: 'post',

                            beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                $('#ModalCargar').modal('show');
                            },
                            success: function (Result) {
                                //console.log(Result);
                                let codigos = Result.request;
                                //console.log(codigos);
                                // $('#GuardarEtiquetasMigradas').submit();
                                if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                    Swal.fire({
                                        title: 'Re imprimir?',
                                        text: 'Desea Imprimir Las etiquetas?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'SI',
                                        cancelButtonText: 'No'
                                    }).then((result) => {
                                        if (result.value) {
                                            $('#Datos').val(Result.request);
                                            $('#ConsultarEtiquetas').submit();
                                        } else {
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Datos Guardados',
                                                showConfirmButton: false,
                                                timer: 13500
                                            })
                                            location.reload();
                                        }
                                    })
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        text: 'Algo salio mal!',
                                    });
                                }
                            },
                            complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                $('#ModalCargar').modal('hide');
                            },
                        });

                    } else if (EnviarMultiplicacion === '2') {
                        if (Fecha > 0 && cliente > 0) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': token},
                                dataType: 'json',
                                data: DatosEviados,
                                url: "{{ route('MigrarEtiqueta') }}",
                                type: 'post',
                                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                    $('#ModalCargar').modal('show');
                                },
                                success: function (Result) {
                                    let codigos = Result.request;
                                    if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                        Swal.fire({
                                            title: 'Re imprimir?',
                                            text: 'Desea Imprimir Las etiquetas?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'SI',
                                            cancelButtonText: 'No'
                                        }).then((result) => {
                                            if (result.value) {
                                                $('#Datos').val(Result.request);
                                                $('#ConsultarEtiquetas').submit();
                                            } else {
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Datos Guardados',
                                                    showConfirmButton: false,
                                                    timer: 13500
                                                })
                                                location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Algo salio mal!',
                                        });
                                    }
                                },
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                    $('#ModalCargar').modal('hide');
                                },
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Debe llenar semana y cliente!',
                            })
                        }
                    } else if (EnviarEnraizamiento === '3') {
                        if (Fecha > 0 && cliente > 0) {
                            $.ajax({
                                headers: {'X-CSRF-TOKEN': token},
                                dataType: 'json',
                                data: DatosEviados,
                                url: "{{ route('MigrarEtiqueta') }}",
                                type: 'post',
                                beforeSend: function () { // Before we send the request, remove the .hidden class from the spinner and default to inline-block.
                                    $('#ModalCargar').modal('show');
                                },
                                success: function (Result) {
                                    let codigos = Result.request;
                                    //console.log(codigos);
                                    // $('#GuardarEtiquetasMigradas').submit();
                                    if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                        Swal.fire({
                                            title: 'Re imprimir?',
                                            text: 'Desea Imprimir Las etiquetas?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'SI',
                                            cancelButtonText: 'No'
                                        }).then((result) => {
                                            if (result.value) {
                                                $('#Datos').val(Result.request);
                                                $('#ConsultarEtiquetas').submit();
                                            } else {
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Datos Guardados',
                                                    showConfirmButton: false,
                                                    timer: 13500
                                                })
                                                location.reload();
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Oops...',
                                            text: 'Algo salio mal!',
                                        });
                                    }
                                }
                                ,
                                complete: function () { // Set our complete callback, adding the .hidden class and hiding the spinner.
                                    $('#ModalCargar').modal('hide');
                                },

                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Debe llenar semana y cliente!',
                            })
                        }
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Seleccione Tipo de movimiento!',
                        })
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: 'Seleccione al menos un Codigo!',
                    })
                }
            });

            $("#CambiarEtiqueta").on('hidden.bs.modal', function () {
                $('input.EnviarStock').prop('checked', false);
                $("#cliente").val(false);
                $("#week").val(false);
                $("input.EnviarStock").removeAttr("checked");
                $("input.EnviarMultiplicacion").removeAttr("checked");
                $("input.EnviarEnraizamiento").removeAttr("checked");
                $('#TablaClonada tbody').empty();
            });


            $("#cliente").on('change', function () {
                var op = $(this).val();
                if (op >= 1) {
                    //alert('as');
                    $("#EnviarStock").attr('disabled', 'disabled');

                    //$("#EnviarStock").prop('disabled', true);
                }
            });

            $("#week").on('change', function () {
                //alert('as');
                $("#EnviarStock").attr('disabled', 'disabled');
                //$("#EnviarStock").prop('disabled', true);

            });

            $('.EnviarStock').on('click', function () {
                if ($(this).is(':checked')) {
                    // Hacer algo si el checkbox ha sido seleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                    $("#cliente").prop("disabled", true);
                    $("#week").prop("disabled", true);
                    $("#EnviarMultiplicacion").attr('disabled', 'disabled');
                    $("#EnviarEnraizamiento").attr('disabled', 'disabled');

                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                    $("#cliente").prop("disabled", false);
                    $("#week").prop("disabled", false);
                    $("input.EnviarMultiplicacion").removeAttr("disabled");
                    $("input.EnviarEnraizamiento").removeAttr("disabled");

                }
            });

            $('.EnviarMultiplicacion').on('click', function () {
                if ($(this).is(':checked')) {
                    // Hacer algo si el checkbox ha sido seleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                    $("#EnviarStock").attr('disabled', 'disabled');
                    $("#EnviarEnraizamiento").attr('disabled', 'disabled');

                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                    $("input.EnviarStock").removeAttr("disabled");
                    $("input.EnviarEnraizamiento").removeAttr("disabled");

                }
            });

            $('.EnviarEnraizamiento').on('click', function () {
                if ($(this).is(':checked')) {
                    // Hacer algo si el checkbox ha sido seleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido seleccionado");
                    $("#EnviarStock").attr('disabled', 'disabled');
                    $("#EnviarMultiplicacion").attr('disabled', 'disabled');

                } else {
                    // Hacer algo si el checkbox ha sido deseleccionado
                    //alert("El checkbox con valor " + $(this).val() + " ha sido deseleccionado");
                    $("input.EnviarStock").removeAttr("disabled");
                    $("input.EnviarMultiplicacion").removeAttr("disabled");

                }
            });
        });

    </script>
@endsection

