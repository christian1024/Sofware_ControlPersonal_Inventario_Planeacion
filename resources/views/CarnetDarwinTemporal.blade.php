{{--<img src="{{ asset('imagenes/hex0.jpg'}}"></img--}}


<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<html lang="es">
<head>
    <title>Carnet</title>
    <style>
        .contenedor {
            position: relative;
            display: inline-block;
            text-align: center;
        }

        .textoNombre {
            position: absolute;
            top: 222px;
            left: -5px;
            text-align: center;
        }

        .centradoImg {
            position: absolute;
            top: 44%;
            left: 50%;
            transform: translate(-50%, -51%);
        }
    </style>
</head>
<body>
<div class="contenedor">
    <img src="{{ public_path('imagenes/CarnetTemporal.jpg') }}"/>

    <div class="centradoImg">
        <h2> <strong> EMPLEADO</strong> </h2>
        <h2><strong> TEMPORAL </strong></h2>
    </div>

    <div class="textoNombre">


    </div>

    <div style="position: absolute; left: 170px; top: 280px;">

    </div>


</div>


{{--<img src="{{ asset('imagenes/hex0.jpg') }} " class="img-circle" alt="User Image">--}}
</body>
</html>




