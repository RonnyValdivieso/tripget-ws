<?php
/**
 * Obtiene todos los viajes con determinado destino y presupuesto de la base de datos
 */

require '../model/trip.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_GET['destination']) && isset($_GET['budget'])) {

        // Tratar retorno
        $retorno = Trip::getByDestinationAndBudget(
            $_GET['destination'],
            $_GET['budget']
        );


        if ($retorno) {

            $trips["status"] = "1";
            $trips["trips"] = $retorno;
            // Enviar objeto json de los viajes
            print json_encode($trips);
        } else {
            // Enviar respuesta de error general
            print json_encode(
                array(
                    'status' => '2',
                    'message' => 'No se obtuvo el registro'
                )
            );
        }

    } else {
        // Enviar respuesta de error
        print json_encode(
            array(
                'status' => '3',
                'message' => 'Se necesitan parametros'
            )
        );
    }
}

?>