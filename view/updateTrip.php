<?php

require '../model/trip.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    $budget = $body['food'] + $body['accommodation'] + $body['trip_transportation'] +
                  $body['local_transportation'] + $body['entertainment'] +
                  $body['shopping'];

    // Insertar like
    $retorno = Trip::update(
        $body['title'],
        $body['content'],
        $body['destination'],
        $budget,
        $body['trip_date'],
        $body['food'],
        $body['accommodation'],
        $body['trip_transportation'],
        $body['local_transportation'],
        $body['entertainment'],
        $body['shopping'],
        $body['guest_id'],
        $body['trip_duration_id']
    );

    if ($retorno) {
        // Código de éxito
        print json_encode(
            array(
                'status' => '1',
                'message' => 'Actualizacion exitosa')
        );
    } else {
        // Código de falla
        print json_encode(
            array(
                'status' => '2',
                'message' => 'Actualizacion fallida')
        );
    }
}

?>