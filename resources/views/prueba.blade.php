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
            top: 155px;
            left: -5px;
            text-align: center;
        }

        .centradoImg {
            position: absolute;
            top: 85px;
            left: 43%;
            transform: translate(-50%, -51%);
        }
    </style>
</head>
<body>

<header>
    <?php
    use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator as BarcodeGeneratorAlias;
    ?>

    <div>
        <table>

            <tr class="">

                <td style="width: 34mm;height: 29mm">
                    <img src="{{ public_path('imagenes/hex0.jpg') }}"/>

                    <div class="centradoImg">
                        <img src="{{ public_path('imagenes/1019101450a.jpg') }}" class="card-img-top" width="117" height="154" alt="User Image">
                    </div>

                    <div class="textoNombre">
                                <span style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; font-size: 12px">
                                        <b>CHRISTIAN RODRIGUEZ<br>
                                        JEFE DE TECNOLOGIA Y DESARROLLO<br>

                                    </b>
                                </span>

                        <div style="margin-left: 5px;">
                            <?php
                            // use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator as BarcodeGeneratorAlias;
                            $barcode = new BarcodeGeneratorAlias();
                            $barcode->setText(2168);
                            $barcode->setType(BarcodeGeneratorAlias::Code128);
                            $barcode->setScale(2);
                            $barcode->setThickness(15);
                            $barcode->setFontSize(5);
                            $code = $barcode->generate();
                            echo '<img style="font-size:7px; display: inline-block"" src="data:image/png;base64,' . $code . '" />';
                            ?>
                        </div>


                    </div>

                    <div style="position: absolute; left: 150px; top: 165px;">
                                <span style="font-family: Trebuchet MS, Verdana, Arial, Helvetica, sans-serif; font-size: 12px">
                                    <b>COD</b>
                                    <b>2168</b>
                                </span>
                    </div>

                </td>

            </tr>

        </table>
    </div>
</header>


{{--<img src="{{ asset('imagenes/hex0.jpg') }} " class="img-circle" alt="User Image">--}}
</body>
</html>




