<?php

require '../model/trip.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    // Insertar like
    $retorno = Trip::setLike(
        $body['trip_id'],
        $body['user_id']
    );

    if ($retorno) {
        // Código de éxito
        print json_encode(
            array(
                'status' => '1',
                'message' => 'Creacion exitosa')
        );
    } else {
        // Código de falla
        print json_encode(
            array(
                'status' => '2',
                'message' => 'Creacion fallida')
        );
    }
}

?>