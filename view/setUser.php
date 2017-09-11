<?php

require '../model/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $body = json_decode(file_get_contents("php://input"), true);

    // Insertar like
    $retorno = User::insert(
        $body['account_id'],
        $body['username'],
        $body['name'],
        $body['last_name'],
        $body['email']
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