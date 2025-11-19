@extends('layouts.Principal')
@section('contenidoPrincipal')
    <div class="row">

        <div class="card card-body">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Programas Pendientes Por Recoger</h3>
                </div>
                <div class="card-body">
                    <div class="table table-responsive">
                        <table id="TablaPorgramas" class="table table-hover  cell-border">
                            <thead>
                            <tr>
                                <th>Genero</th>
                                <th>Variedad</th>
                                <th>Ubicacion</th>
                                <th>Semana Despacho</th>
                                <th>Identificador</th>
                                <th>Plantas Total</th>
                                {{-- <th>UBICACION aCTUAL</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($programasInvs as $Programa)
                                <tr>
                                    <td>{{ $Programa->NombreGenero }}</td>
                                    <td>{{ $Programa->NombreVariedad }}</td>
                                    <td>{{ $Programa->UbicacionActual }}</td>
                                    <td>{{ $Programa->SemanaDespacho }}</td>
                                    <td>{{ $Programa->Indentificador }}</td>
                                    <td>{{ $Programa->plantas }}</td>


                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function () {

            $('#TablaPorgramas').DataTable({
                dom: "Bfrtip",
                paging: true,
                "ordering": false,
                "language": {
                    "search": "Buscar:",
                    "info": "Mostrando Página _PAGE_ de _PAGES_, Registros Activos _TOTAL_",
                    "Previous": "Anterior",
                },

                buttons: [
                    {
                        extend: 'excelHtml5',

                        text: ' <i class="fa fa-file-excel-o"> &nbsp Excel</i>',
                        titleAttr: 'Excel',
                        title: 'Programas pendientes',
                        customize: function (xlsx) {
                            var sheet = xlsx.xl.worksheets['Programaspendientes.xml'];
                            $('row c[r^="A1"]', sheet).attr('s', '55');
                            //return (columns[0] + ' ' + columns[1] + ' ' + columns[2] + ' ' + columns[3]);
                        },

                    },

                ],

            });

        });

    </script>
@endsection
