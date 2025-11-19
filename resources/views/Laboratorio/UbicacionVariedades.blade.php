@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="card row">
        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 style="text-align: center">Ubicación Variedad</h3>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="col-8">
                        <label>Variedad</label>
                        <select class="selectpicker" data-show-subtext="true" name="idVariedad" id="variedad" data-live-search="true" required="required">
                            <option selected="true" value="" disabled="disabled">Seleccione.....</option>
                            @foreach($VariedadesActivas as $VariedadesActiva)
                                <option style="width:190px" value="{{ $VariedadesActiva->id }}">
                                    {{ $VariedadesActiva->Codigo }}
                                    {{ $VariedadesActiva->Nombre_Variedad }}
                                </option>
                            @endforeach
                        </select>
                        <a class="btn btn-success" target="_blank" id="ConsultarVar">Consultar</a>

                        <label>Genero</label>
                        <input id="Genero" disabled="disabled" style="width:120px">

                    </div>

                </div>
                <div class="card-body" style="display: none;" id="VariedadesConsultadas">
                    <div>
                        <div class="col-12">
                            <div class="box box-body table-responsive">
                                <table id="TablaVariedadesConsultadas" class="table table-hover table-bordered">
                                    <thead>
                                    <tr>
                                        <th>Ubicacion</th>
                                        <th>Introducción</th>
                                        <th>Cant Conte</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#ConsultarVar').on('click', function () {
                let token = $('#token').val();
                let variedad = $('#variedad').val();
                let count = 1;
                if (variedad === null) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Seleccione una variedad',
                    });

                } else {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': token},
                        data: {variedad: variedad},
                        url: "{{ route('DestallesUbicacionVariedades') }}",
                        type: 'post',

                        success: function (Result) {
                            var tbHtml = '';
                            $.each(Result.data, function (index, value) {

                                tbHtml += '<tr>' +
                                    '<td>' + value.ubicacion + '</td>' +
                                    '<td>' + value.Indentificador + '</td>' +
                                    '<td>' + value.CantContenedores + '</td>' +
                                    '</tr>';
                                count++;

                                $('#VariedadesConsultadas').show();
                            });
                            $('#TablaVariedadesConsultadas tbody').html(tbHtml);
                        },
                    });
                }

            })

        });

        $('#variedad').change(function (event) {
            event.preventDefault();
            let token = $('#token').val();
            let valor = $('#variedad').val();
            $.ajax({
                headers: {'X-CSRF-TOKEN': token},
                data: {valor: valor},
                url: "{{route('DetalleInfoTecnicaVar')}}",
                type: 'post',
                success: function (Result) {
                    $.each(Result.data, function (index, value) {
                        $('#Genero').val(value.NombreGenero);
                    });
                },
            });

        });
    </script>
@endsection

