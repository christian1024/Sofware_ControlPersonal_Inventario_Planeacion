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
        <div class="card-header">
            <h3>Cargar Inventario</h3>
        </div>
        <div class="card-body">

            <div class="col-12 form-group row">
                <div class="col-6">
                    <form id="" method="POST" action="{{ route('LoadInventoryEtq') }}" enctype="multipart/form-data">
                        <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                        <div class="box box-body col-lg-12">
                            <div class="col-lg-12">
                                <label>Importar Etiquetas</label>
                                <input type="file" required name="LoadInventoryEtq">
                                <button type="submit" style="margin-top: 10px" class="btn btn-success"> {{ __('Cargar') }} </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div CLASS="col-6">
                    <input type="hidden" value="{{ csrf_token() }}" name="_token" id="token">
                    <button type="button" id="btnLimpiarTables" style="margin-top: 10px" class="btn btn-danger"> {{ __('Limpiar Tablas') }} </button>

                </div>
            </div>


        </div>

        <div class="card card-body">
            <div class="text-center">

                <h3>Total registros en la tablas<br> <strong> {{ $totalRegistro }} </strong></h3>
            </div>

        </div>
    </div>

    <script>

        $("#btnLimpiarTables").click(function () {

            Swal.fire({
                title: 'Limpiar Tablas',
                text: 'Esta Realizando un limpiado de las tablas',
                icon: 'error',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        url: '{{ route('Truncatetable') }}',
                        type: 'post',
                        success: function (Result) {
                            if (Result.ok === 1) {
                                iziToast.success({
                                    //timeout: 20000,
                                    title: 'success',
                                    position: 'center',
                                    message: 'Limpieza finalizada',
                                });
                                function waitFunc() {
                                    location.reload();
                                }
                                window.setInterval(waitFunc, 2000);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Algo salio mal LLamar a sistemas',
                                });

                            }
                        },
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Cancelado',
                    });

                }
            });


        });

        @if(session()->has('Existente'))
        $(document).ready(function () {
            iziToast.error({
                //timeout: 20000,
                title: 'Error',
                position: 'center',
                message: 'Hay variedades inexistentes',
            });
        });
        @endif


    </script>
@endsection
