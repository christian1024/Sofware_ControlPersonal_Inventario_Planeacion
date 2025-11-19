<?php

namespace App\Http\Controllers;

use App\Model\Cargos;
use App\User;
use Illuminate\Http\Request;

class AppsiembrasController extends Controller
{
    public function DatosEnrada(Request $request)
    {
        $data = json_decode(file_get_contents('php://input'));

        for ($i = 1; $i < count($data); $i++) {
            //dd($array[$i]['TipoIntro']);
            print_r($data);
        }
        dd('pausa');
    }

    static function consultarAerolinia()
    {
        $user = 'CIFLORES7';
        $psw = 'Admon.2018*';
        $ip = '200.91.234.245';
        $nit = '830092332';
        $cadena = '
        <mic:consultarDestinatarios>
             <mic:Numero_identificacion>' . $nit . '</mic:Numero_identificacion>
             <!--Optional:-->
             <mic:usuario>' . $user . '</mic:usuario>
             <!--Optional:-->
             <mic:contrasena>' . $psw . '</mic:contrasena>
             <!--Optional:-->
             <mic:ip_equipo>' . $ip . '</mic:ip_equipo>
         </mic:consultarDestinatarios>
        ';

        $funcion = 'consultarDestinatarios';
        $client = new nusoap_client('http://pruebas-webservices.ica.gov.co:83/wscostanciasICA/WS_COSTANCIAS.asmx?wsdl', true);
        $client->soap_defencoding = 'UTF-8';
        $client->decode_utf8 = FALSE;
        $client->namespaces = array(
            'SOAP-ENV' => "http://schemas.xmlsoap.org/soap/envelope/",
            'mic' => "http://microsoft.com/"
        );
        $result = $client->call($funcion, $cadena);
        if ($client->fault) {
            return $result;
        } else {
            $error = $client->getError();
            if ($error) {
                return $error;
            } else {
                return $result;
            }
        }
    }
}
