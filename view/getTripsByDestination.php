<?php
/**
 * Obtiene todos los viajes con determinado destino de la base de datos
 */

require '../model/trip.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$body = json_decode(file_get_contents("php://input"), true);

    $parametro = $body['destination'];

	if ($parametro) {

		// Tratar retorno
		$retorno = Trip::getByDestination($parametro);


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