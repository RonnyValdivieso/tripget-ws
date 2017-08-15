<?php
/**
 * Obtiene todas los usuarios de la base de datos
 */

require '../model/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Manejar petición GET
    $users = User::getAll();

    if ($users) {

        $datos["estado"] = 1;
        $datos["users"] = $users;

        print json_encode($datos);
    } else {
        print json_encode(array(
            "estado" => 2,
            "mensaje" => "Ha ocurrido un error"
        ));
    }
}

?>