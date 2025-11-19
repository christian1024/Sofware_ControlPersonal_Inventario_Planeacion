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
    <div class="card">
        <div class="card-header text-center">
            <h3>Siembras Confirmadas</h3>
        </div>
        <div class="card-body">
            <div class="col-12 form-group row">
                <table class="table table-bordered" id="ConfirmacionesSimebras">
                    <thead>
                    <tr class="thead-dark">
                        <th>plotid</th>
                        <th>codigo</th>
                        <th>genero</th>
                        <th>variedad</th>
                        <th>especie</th>
                        <th>plantas</th>
                        <th>canastillas</th>
                        <th>semana_siembra</th>
                        <th>procedencia</th>
                        <th>densidad</th>
                        <th>hora_luz</th>
                        <th>ubicacion</th>
                        <th>bandeja</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($siembras as $siembra)
                        <tr>
                            <td>{{ $siembra->PlotId }}</td>
                            <td>{{ $siembra->Codigo }}</td>
                            <td>{{ $siembra->NombreGenero }}</td>
                            <td>{{ $siembra->Nombre_Variedad }}</td>
                            <td>{{ $siembra->NombreEspecie }}</td>

                            @if($siembra->plantasconfirmadas >= $siembra->Legalizar )
                                <td>{{ $siembra->Legalizar }}</td>
                            @else
                                <td>{{ $siembra->plantasconfirmadas }}</td>
                            @endif

                            @if($siembra->plantasconfirmadas >= $siembra->Legalizar )
                                <td>{{ ceil($siembra->Legalizar /15) }}</td>
                            @else
                                <td>{{ ceil($siembra->plantasconfirmadas /15) }}</td>
                            @endif

                            <td>{{ $siembra->semanaConfirmacionModificada }}</td>
                            <td>{{ $siembra->Procedencia }}</td>
                            <td>{{ $siembra->Plantas_X_Canastilla }}</td>
                            <td>{{ $siembra->Horas_luz_producción }}</td>
                            <td>{{ $siembra->Bloque_siembra_Producción }}</td>
                            <td>{{ $siembra->tipo_de_bandeja }}</td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('#ConfirmacionesSimebras').DataTable({
            dom: "Bfrtip",
            "paging": true,
            "order": [[10, "asc"]],
            buttons: [{
                extend: 'excel',
                title: ''
            } ],
        });
    </script>
@endsection
