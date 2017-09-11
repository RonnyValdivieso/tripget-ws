<?php
/**
 * Obtiene el token del usuario con determinado id de la base de datos
 */

require '../model/user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$body = json_decode(file_get_contents("php://input"), true);

	if (isset($body['account_id'])) {

		// Tratar retorno
		$retorno = User::getIdByToken(
			$body['account_id']
		);


		if ($retorno) {

			$users["status"] = "1";
			$users["users"] = $retorno;
			// Enviar objeto json de los viajes
			print json_encode($users);
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