<?php
/**
 * Obtiene un viaje con determinado id de la base de datos
 */

require '../model/trip.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$body = json_decode(file_get_contents("php://input"), true);

	if (isset($body['id'])) {

		// Tratar retorno
		$retorno = Trip::getById(
			$body['id']
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