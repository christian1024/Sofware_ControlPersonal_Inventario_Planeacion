@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card border-secondary text-center">
        <div class="card-header"><h3>Reactivar Codigo</h3></div>
        <div class="card-body">
            <div class="panel-body">
                <div class="row row-cols-2">
                    <div class="col">
                        <form id="CargarProgramas" method="POST" action="{{ route('DetallesProgramasReactivar') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="row row-cols-3">
                                <div class="col">
                                    <div>
                                        <label>Fecha Inicio</label>
                                        <input type="date" name="FechaInicio" id="FechaInicio" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Variedad</label>
                                        <select class="selectpicker form-control" data-show-subtext="true" name="idVariedad" id="idVariedad" data-live-search="true" required="required">
                                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                            @foreach($VariedadesActivas as $VariedadesActiva)
                                                <option style="width:190px" value="{{ $VariedadesActiva->id }}">
                                                    {{ $VariedadesActiva->Codigo }}
                                                    {{ $VariedadesActiva->Nombre_Variedad }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <label>Fecha Final</label>
                                        <input type="date" name="FechaFinal" id="FechaFinal" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Fase Actual</label>
                                        <select class="selectpicker form-control" data-show-subtext="true" name="FaseActual" id="FaseActual" data-live-search="true" required="required">
                                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                                            <option value="1">Introducción</option>
                                            <option value="2">Primer Transferencia</option>
                                            <option value="3">Segunda Transferencia</option>
                                            <option value="4">Banco Germoplasma</option>
                                            <option value="5">Stock</option>
                                            <option value="6">Multiplicación</option>
                                            <option value="7">Enraizamiento</option>
                                            <option value="8">Adaptación</option>
                                            <option value="9">Despacho</option>
                                            <option value="10">Servico Adaptacion</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="col-lg-4">
                                        <button class="btn btn-success" style="margin-top: 24px" type="submit" id="CargarProgramas">Cargar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col">
                        <div class="col-lg-12" style="display: none" id="programas">
                            <label>Programas</label>
                            <select class="labelform form-control" data-show-subtext="true" required id="SelectPorgramas" name="SelectPorgramas">
                            </select>
                        </div>
                    </div>
                </div>

                <div id="TablaDetalles" class="card card-primary card-outline" style="display: none">
                    <form id="GuardarEtiquetasMigradas" action="{{ route('MigrarEtiqueta') }}" method="post">
                        @csrf
                        <div class="panel-primary">
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
                                    <button class="btn btn-primary" type="button" id="btnActivar">Activar</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
        </div>
        <script>

            window.onload = function () {
                var fecha = new Date(); //Fecha actual
                var mes = fecha.getMonth() + 1; //obteniendo mes
                var dia = fecha.getDate(); //obteniendo dia
                var ano = fecha.getFullYear(); //obteniendo año
                if (dia < 10)
                    dia = '0' + dia; //agrega cero si el menor de 10
                if (mes < 10)
                    mes = '0' + mes //agrega cero si el menor de 10
                document.getElementById('FechaInicio').value = ano + "-" + mes + "-" + dia;
                document.getElementById('FechaFinal').value = ano + "-" + mes + "-" + dia;
            };

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
                    let SemanIntro = $('#SemanIntro').val();
                    let idVariedad = $('#idVariedad').val();
                    let FaseActual = $('#FaseActual').val();
                    let FechaiInicial = $('#FechaInicio').val();
                    let FechaFinal = $('#FechaFinal').val();
                    let dataform = {idVariedad: idVariedad, FaseActual: FaseActual, FechaIncial: FechaiInicial, FechaFinal: FechaFinal};


                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: dataform,
                        url: '{{ route('DetallesProgramasReactivar') }}',
                        type: 'post',
                        dataType: 'json',
                        success: function (Result) {
                            console.log(Result);
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
                    let FechaiInicial = $('#FechaInicio').val();
                    let FechaFinal = $('#FechaFinal').val();
                    let i = 0;
                    let semanaDespachoV;
                    let ClienteV;
                    //console.log(valor);
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: {valor: valor, FechaIncial: FechaiInicial, FechaFinal: FechaFinal},
                        url: '{{ route('DetallesTableProgramasReactivar') }}',
                        type: 'post',

                        success: function (Result) {

                            var tbHtml = '';
                            $.each(Result.Data, function (index, value) {
                                console.log(value.SemanaDespacho);
                                if (value.SemanaDespacho === null) {
                                    semanaDespachoV = '';
                                    ClienteV = '';
                                    //semanaDespachoV = value.SemanaDespacho;
                                } else {
                                    semanaDespachoV = value.SemanaDespacho;
                                    ClienteV = value.Cliente;
                                }

                                tbHtml += '<tr>' +
                                    '<td>' + '<input type="checkbox" class="CheckedAK case" id="CheckedAK" name="CheckedAK[]" value="' + value.BarCode + '">' + '</td>' +
                                    '<td>' + value.Indentificador + '</td>' +
                                    '<td>' + value.BarCode + '</td>' +
                                    '<td>' + value.TipoContenedor + '</td>' +
                                    '<td>' + value.SemanUltimoMovimiento + '</td>' +
                                    '<td>' + semanaDespachoV + '</td>' +
                                    '<td>' + ClienteV + '</td>' +
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

                $('#btnActivar').click(function () {
                    var arr = $('[name="CheckedAK[]"]:checked').map(function () {
                        return this.value;
                    }).get();
                    $('#ok').val(arr);
                    if (arr.length > 0) {
                        let token = $('#token').val();
                        let checbocStock = ($('input:checkbox[name=EnviarStock]:checked').val());
                        let DatosEviados = $('#GuardarEtiquetasMigradas').serialize();
                        //alert('entro a stock');
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},
                            dataType: 'json',
                            data: DatosEviados,
                            url: '{{ route('ActivarCodigo') }}',
                            type: 'post',
                            success: function (Result) {
                                //console.log(Result);
                                let codigos = Result.request;
                                //console.log(codigos);
                                // $('#GuardarEtiquetasMigradas').submit();
                                if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Datos Guardados',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    location.reload();

                                } else {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'Oops...',
                                        text: 'Revise la informacion algo salio mal.',
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Seleccione al menos un Codigo!',
                        });
                    }
                });

                /*   $("#CambiarEtiqueta").on('hidden.bs.modal', function () {
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
                   });*/
            });

        </script>
@endsection

