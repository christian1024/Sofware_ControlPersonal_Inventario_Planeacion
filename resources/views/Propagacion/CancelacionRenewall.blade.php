@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="row">
        <div class="card card-body">

            <div class="card card-primary">
                <div class="card-header text-center">
                    <h3>Cancelación Renewall</h3>
                </div>
                <div class="card-body">
                    <div class="col-lg-12">
                        <form id="CargarProgramas" method="POST" action="{{ route('CargarPrograma') }}">
                            <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                            <div class="col-lg-2 ">
                                <label>Cajas</label>
                                <select class="labelform form-control" required id="Caja" name="Caja">
                                    <option selected="true" value="" disabled="disabled">Seleccione Caja</option>
                                    @foreach( $cajas as $caja)
                                        <option value=" {{ $caja->Caja }}"> {{ $caja->Caja }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div id="TablaDetalles" class="col-lg-12" style="display: none">
                <form id="GuardarEtiquetasMigradas" action="{{ route('MigrarEtiqueta') }}" method="post">
                    @csrf
                    <div class="card card-body">
                        <div class="card card-body">
                            <div class="row">

                                <div class="col-lg-6">
                                    <label>Causal Cancelacion</label>
                                    <select class="labelform form-control" required id="TpCancelacion" name="TpCancelacion">
                                        <option selected="true" value="" disabled="disabled">Seleccione Tipo Cancelacion</option>
                                        <option selected="true" value="" disabled="disabled">Seleccione Caja</option>
                                        @foreach( $TPCancelaciones as $TPCancelacione)
                                            <option value=" {{ $TPCancelacione->id }}"> {{ $TPCancelacione->TipoCancelacion }} </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="box box-body">
                            <label>Buscar</label>
                            <input type="text" id="search" placeholder="Escribe para buscar..."/>
                            <table id="TablaDetallesPrograma" class="table table-hover table-info display nowrap col-md-12 col-lg-12 col-xl-12 cell-border">
                                <thead class="bg-blue-gradient">
                                <tr>
                                    <th><input id="checkboxAll" type="checkbox"/></th>
                                    <th>Numero Caja</th>
                                    <th>Codigo Barras</th>
                                    <th>Variedad</th>
                                    <th>Bloque</th>
                                    <th>Nave</th>
                                    <th>Cama</th>
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
                                <button class="btn btn-primary" type="button" id="btnCambiar">Cancelar</button>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>




    </div>
    <input type="hidden" value="{{ csrf_token() }}" name="token" id="token">
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

            $("#checkboxAll").on("click", function () {
                $(".case").prop("checked", this.checked);
            });

            $('#Caja').change(function (event) {
                event.preventDefault();
                let caja = $('#Caja').val();
                let token = $('#token').val();
                let i = 0;
                $.ajax({
                    headers: {'X-CSRF-TOKEN': token},
                    data: {caja: caja},
                    url: '{{ route('DetallesCajaCancelacionRenewall') }}',
                    type: 'post',

                    success: function (Result) {

                        var tbHtml = '';
                        $.each(Result.Data, function (index, value) {

                            tbHtml += '<tr>' +
                                '<td>' + '<input type="checkbox" class="CheckedAK case" id="CheckedAK" name="CheckedAK[]" value="' + value.CodigoBarras + '">' + '</td>' +
                                '<td>' + value.Caja + '</td>' +
                                '<td>' + value.CodigoBarras + '</td>' +
                                '<td>' + value.NombreVariedad + '</td>' +
                                '<td>' + value.Bloque + '</td>' +
                                '<td>' + value.Nave + '</td>' +
                                '<td>' + value.Cama + '</td>' +
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
                let Cancelacion = $('#TpCancelacion').val()

                //console.log(Cancelacion);
                var arr = $('[name="CheckedAK[]"]:checked').map(function () {
                    return this.value;
                }).get();

                if (Cancelacion != null) {
                    if (arr.length > 0) {
                        let token = $('#token').val();
                        let DatosEviados = $('#GuardarEtiquetasMigradas').serialize();
                        $.ajax({
                            headers: {'X-CSRF-TOKEN': token},
                            dataType: 'json',
                            data: DatosEviados,
                            url: '{{route('CancelacionRenewall')}}',
                            type: 'post',
                            success: function (Result) {
                                //console.log(Result);

                                if (Result.data === 1) {//valida si viene lleno .data lo trae desde el controlador
                                    $('#Datos').val(Result.request);
                                    $('#ConsultarEtiquetas').submit();
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Datos Guardados',
                                        showConfirmButton: false,
                                        timer: 13500
                                    });
                                    location.reload();
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title:'Error',
                            text: 'Seleccione al menos uno dato',
                        });
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title:'Error',
                        text: 'Seleccione Tipo Cancelacion',
                    });
                }

            });
        });

    </script>
@endsection


