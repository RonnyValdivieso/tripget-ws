<?php

/**
 * Representa el la estructura de los usuarios
 * almacenadas en la base de datos
 */
require '../database/database.php';
require '../filemanager/upload.php';

class Trip {
	function __construct() {
	}

	/**
	 * Retorna en la fila especificada de la tabla 'user'
	 *
	 * @param $id Identificador del registro
	 * @return array Datos del registro
	 */
	public static function getAll() {
		$consulta = "SELECT * FROM trip";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);
			// Ejecutar sentencia preparada
			$comando->execute();

			return $comando->fetchAll(PDO::FETCH_ASSOC);

		} catch (PDOException $e) {
			return false;
		}
	}

	/**
	 * Obtiene los campos de un viaje con un destino
	 * determinado
	 *
	 * @param 	$id 	identificador del viaje
	 * @return 	array
	 */
	public static function getById($id) {

		// Consulta del usuario
		$consulta = "SELECT t.id, u.username, u.photo, t.title, t.content, t.destination, t.budget, t.trip_date, t.food, 
							t.accommodation, t.trip_transportation, t.local_transportation, 
							t.entertainment, t.shopping, t.trip_image, 
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id) AS likes, 
							t.guest_id, t.trip_duration_id
					 FROM trip t
					 INNER JOIN user u ON t.user_id = u.id
					 WHERE t.id = ?";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($id));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}

	/**
	 * Obtiene los campos de un viaje con un destino
	 * determinado
	 *
	 * @param $destination 	destino del viaje
	 * @return array
	 */
	public static function getByDestination($destination, $order, $user_id) {

		$orderWay = "DESC";

		switch($order) {
			case '0':
				$order = "trip_date";
				break;

			case '1':
				$order = "budget";
				$orderWay = "ASC";
				break;

			case '2':
				$order = "budget";
				break;

			case '3':
				$order = "likes";
				break;
		}

		$consulta = "SELECT t.id, t.title, u.username, t.trip_date, 
							t.budget, u.photo, t.trip_image, 
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id) AS likes,
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id AND user_id = $user_id) AS liked
					 FROM trip t
					 INNER JOIN user u ON t.user_id = u.id
					 WHERE destination = ?
					 ORDER BY $order $orderWay";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($destination));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}

	/**
	 * Obtiene los campos de un viaje con un presupuesto
	 * determinado
	 *
	 * @param $budget 	presupuesto del viaje
	 * @return array
	 */
	public static function getByBudget($budget, $order, $user_id) {

		$orderWay = "DESC";

		switch($order) {
			case '0':
				$order = "trip_date";
				break;

			case '1':
				$order = "budget";
				$orderWay = "ASC";
				break;

			case '2':
				$order = "budget";
				break;

			case '3':
				$order = "likes";
				break;
		}

		// Consulta del usuario
		$consulta = "SELECT t.id, t.title, t.destination, u.username, 
							t.trip_date, t.budget, u.photo, t.trip_image, 
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id) AS likes,
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id AND user_id = $user_id) AS liked
					 FROM trip t
					 INNER JOIN user u ON t.user_id = u.id
					 WHERE budget <= ?
					 ORDER BY $order $orderWay";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($budget));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}

	/**
	 * Obtiene los campos de un viaje con un destino y presupuesto
	 * determinado
	 *
	 * @param $destination 	destino del viaje
	 * @param $budget 		presupuesto del viaje
	 * @return mixed
	 */
	public static function getByDestinationAndBudget($destination, $budget, $order, $user_id) {

		$orderWay = "DESC";

		switch($order) {
			case '0':
				$order = "trip_date";
				break;

			case '1':
				$order = "budget";
				$orderWay = "ASC";
				break;

			case '2':
				$order = "budget";
				break;

			case '3':
				$order = "likes";
				break;
		}

		// Consulta del usuario
		$consulta = "SELECT t.id, t.title, u.username, t.trip_date, t.budget, u.photo, t.trip_image, 
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id) AS likes,
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id AND user_id = $user_id) AS liked
					FROM trip t 
					INNER JOIN user u ON t.user_id = u.id 
					WHERE destination = ?
					AND budget <= ?
					ORDER BY $order $orderWay";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($destination, $budget));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}

	/**
	 * Actualiza un registro de la bases de datos basado
	 * en los nuevos valores relacionados con un identificador
	 *
	 * @param $id 					identificador
	 * @param $title 				nuevo titulo
	 * @param $content 				nuevo contenido
	 * @param $destination			nuevo destino
	 * @param $budget				nuevo presupuesto
	 * @param $trip_date			nueva fecha de viaje
	 * @param $food 				nuevo presupuesto para comida
	 * @param $accommodation		nuevo presupuesto para alojamiento
	 * @param $trip_transportation	Nuevo presupuesto para transporte
	 * @param $local_transportation	nueva presupuesto para transporte local
	 * @param $entertainment 		nuevo presupuesto para entretenimiento
	 * @param $shopping				nuevo presupuesto para compras
	 * @param $trip_image			nueva imagen
	 * @param $guest_id 			nuevo id de Numero de personas
	 * @param $trip_duration_id		nuevo id de duración de viaje
	 */
	public static function update($id, $title, $content, $destination, $budget, $trip_date, 
								  $food, $accommodation, $trip_transportation,
								  $local_transportation, $entertainment, $shopping, 
								  $guest_id, $trip_duration_id) {
		// Creando consulta UPDATE
		$consulta = "UPDATE trip 
					 SET title = '$title', content = '$content', destination = '$destination', 
					 	 budget = '$budget', trip_date = '$trip_date', food = '$food', 
					 	 accommodation = '$accommodation', trip_transportation = '$trip_transportation', 
					 	 local_transportation = '$local_transportation', entertainment = '$entertainment', 
					 	 shopping = '$shopping', guest_id = $guest_id, 
					 	 trip_duration_id = $trip_duration_id
			  	  	 WHERE id = $id";

		// Preparar la sentencia
		$cmd = Database::getInstance()->getDb()->prepare($consulta);

		// Relacionar y ejecutar la sentencia
		$cmd->execute(array($title, $content, $destination, $budget, $trip_date, $food, $accommodation,
							$trip_transportation, $local_transportation, $entertainment, $shopping,
							$guest_id, $trip_duration_id));

		return $cmd;
	}

	/**
	 * Insertar un nuevo usuario
	 *
	 * @param $title 				nuevo titulo
	 * @param $content 				nuevo contenido
	 * @param $destination			nuevo destino
	 * @param $budget				nuevo presupuesto
	 * @param $trip_date			nueva fecha de viaje
	 * @param $food 				nuevo presupuesto para comida
	 * @param $accommodation		nuevo presupuesto para alojamiento
	 * @param $trip_transportation	Nuevo presupuesto para transporte
	 * @param $local_transportation	nueva presupuesto para transporte local
	 * @param $entertainment 		nuevo presupuesto para entretenimiento
	 * @param $shopping				nuevo presupuesto para compras
	 * @param $trip_image			nueva imagen
	 * @param $guest_id 			nuevo id de Numero de personas
	 * @param $trip_duration_id		nuevo id de duración de viaje
	 * @return PDOStatement
	 */
	public static function insert($title, $content, $destination, $budget, $trip_date, 
								  $food, $accommodation, $trip_transportation,
								  $local_transportation, $entertainment, $shopping,
								  $guest_id, $trip_duration_id, $user_id) {

		// Sentencia INSERT
		$comando = "INSERT INTO trip (title, content, destination, budget, trip_date, 
						food, accommodation, trip_transportation, local_transportation,
						entertainment, shopping, guest_id, trip_duration_id, user_id)
					VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		$resultado = $sentencia->execute(
			array($title, $content, $destination, $budget, $trip_date, $food,
				  $accommodation, $trip_transportation, $local_transportation,
				  $entertainment, $shopping, $guest_id, $trip_duration_id, $user_id)
		);

		return $resultado;

	}

	/**
	 * Eliminar el registro con el identificador especificado
	 *
	 * @param 	$id identificador del usuario
	 * @return 	bool Respuesta de la eliminación
	 */
	public static function delete($id)
	{
		// Sentencia DELETE
		$comando = "DELETE FROM trip WHERE id = ?";

		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		return $sentencia->execute(array($id));
	}

	/**
	 * Aumentar un like al viaje
	 *
	 * @param $trip_id identificador del viaje
	 * @param $user_id identificador del usuario
	 * @return bool Respuesta de la eliminación
	 */
	public static function setLike($trip_id, $user_id) {

		$result = 0;

		$comando = "SELECT id FROM trip_likes
					WHERE trip_id = $trip_id
					AND user_id = $user_id";


		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		$resultado = $sentencia->execute(
			array($trip_id, $user_id)
		);

		$row = json_encode($sentencia->fetchAll(PDO::FETCH_ASSOC));

		$like_id = $resultado;

		if ($row != "[]") {
			$comando = "DELETE FROM trip_likes
						WHERE id = $like_id";

			$result = 2;
		} else {
			$comando = "INSERT INTO trip_likes(trip_id, user_id)
						VALUES ($trip_id, $user_id)";

			$result = 1;
		}

		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);
		$sentencia->execute(array($trip_id, $user_id));

		return $result;
	}

	/**
	 * Obtiene los viajes de un usuario
	 * determinado
	 *
	 * @param $id 	id del usuario
	 * @return array
	 */
	public static function getTripsByUserId($user_id, $order) {

		$orderWay = "DESC";

		switch($order) {
			case '0':
				$order = "trip_date";
				break;

			case '1':
				$order = "budget";
				$orderWay = "ASC";
				break;

			case '2':
				$order = "budget";
				break;

			case '3':
				$order = "likes";
				break;
		}

		// Consulta del usuario
		$consulta = "SELECT t.id, t.title, u.username, t.trip_date, t.budget, u.photo, t.trip_image, 
							(SELECT COUNT(*) FROM trip_likes WHERE trip_id = t.id) AS likes 
					FROM trip t 
					INNER JOIN user u ON t.user_id = u.id 
					WHERE user_id = ? 
					ORDER BY $order $orderWay";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($user_id));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}

	/**
	 * Obtiene los campos de un viaje con un destino
	 * determinado
	 *
	 * @param $id 	identificador del viaje
	 * @return array
	 */
	public static function getNotificationsById($id) {

		// Consulta del usuario
		// FALTA ------------------------------------------------
		$consulta = "SELECT (SELECT u.username FROM user
							 INNER JOIN trip_likes tl ON tl.user_id =  WHERE trip_id = t.id) AS likes, 
							u.photo, u.username, t.trip_image
					 FROM trip t
					 INNER JOIN user u ON t.user_id = u.id
					 WHERE t.id = ?";
		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);

			// Ejecutar sentencia preparada
			$comando->execute(array($id));
			
			// Capturar primera fila del resultado
			$row = $comando->fetchAll(PDO::FETCH_ASSOC);
			
			return $row;
		} catch (PDOException $e) {
			// Aquí puedes clasificar el error dependiendo de la excepción
			// para presentarlo en la respuesta Json
			return -1;
		}
	}
}

?>