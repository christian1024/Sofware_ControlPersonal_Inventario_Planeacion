@extends('layouts.Principal')
@section('contenidoPrincipal')

    <div class="card row"{{-- style="margin-top:10px;"--}}>
        <div>
            <h3>Programas Pendientes</h3>
        </div>

        <div>
            <div class="col-lg-12 box box-body spaceTap">

                <div class="col-lg-12 container-fluid">
                    <div class="table-responsive">

                        <table id="TablaPorgramas" width="100%" class="table table-hover display nowrap col-lg-12 cell-border">
                            <thead>
                            <tr>
                                <th>Codigo Variedad</th>
                                <th>Nombre Variedad</th>
                                <th>Identificador</th>
                                <th>Semana Despacho</th>
                                <th>Semana Ultimo Movimiento</th>
                                <th>Fase Actual</th>
                                <th>Cantidad Plantas</th>
                               {{-- <th>UBICACION aCTUAL</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Programas as $Programa)
                                <tr>
                                    <td>{{ $Programa->CodigoVariedad }}</td>
                                    <td>{{ $Programa->Nombre_Variedad }}</td>
                                    <td>{{ $Programa->Indentificador }}</td>
                                    <td>{{ $Programa->SemanaDespacho }}</td>
                                    <td>{{ $Programa->SemanUltimoMovimiento }}</td>
                                    <td>{{ $Programa->NombreFase }}</td>
                                    <td>{{ $Programa->CantidadPlantas }}</td>
                                   {{-- <td>{{ $Programa->UbicacionActual }}</td>--}}

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
