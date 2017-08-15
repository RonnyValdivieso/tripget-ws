<?php

/**
 * Representa el la estructura de los usuarios
 * almacenadas en la base de datos
 */
require '../database/database.php';

class User {
	function __construct() {
	}

	/**
	 * Retorna en la fila especificada de la tabla 'user'
	 *
	 * @param $id Identificador del registro
	 * @return array Datos del registro
	 */
	public static function getAll() {
		$consulta = "SELECT * FROM user";
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
	 * Obtiene los campos de un usuario con un identificador
	 * determinado
	 *
	 * @param $id Identificador del usuario
	 * @return mixed
	 */
	public static function getById($id) {
		// Consulta del usuario
		$consulta = "SELECT id, account_id, username, name,
							last_name, email, photo
					 FROM user
					 WHERE id = ?";

		try {
			// Preparar sentencia
			$comando = Database::getInstance()->getDb()->prepare($consulta);
			// Ejecutar sentencia preparada
			$comando->execute(array($id));
			// Capturar primera fila del resultado
			$row = $comando->fetch(PDO::FETCH_ASSOC);
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
	 * @param $id      identificador
	 * @param $username nueva descripcion
	 * @param $name    nueva fecha limite de cumplimiento
	 * @param $last_name   nueva last_name
	 * @param $email   nuevo email
	 * @param $photo   nueva photo
	 */
	public static function update($id, $username, $name, $last_name, $email, $photo) {
		// Creando consulta UPDATE
		$consulta = "UPDATE user" .
			" SET username=?, name=?, last_name=?, email=?, photo=? " .
			"WHERE id=?";

		// Preparar la sentencia
		$cmd = Database::getInstance()->getDb()->prepare($consulta);

		// Relacionar y ejecutar la sentencia
		$cmd->execute(array($username, $name, $last_name, $email, $photo));

		return $cmd;
	}

	/**
	 * Insertar un nuevo usuario
	 *
	 * @param $username     nombre de usuario del nuevo registro
	 * @param $name 		nombre del nuevo registro
	 * @param $last_name    apellido del nuevo registro
	 * @param $email 		correo electronico del nuevo registro
	 * @param $photo		foto del nuevo registro
	 * @return PDOStatement
	 */
	public static function insert($username, $name, $last_name, $email, $photo) {

		// Sentencia INSERT
		$comando = "INSERT INTO user (username, name, last_name, email, photo)
					VALUES(?, ?, ?, ?, ?)";

		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		return $sentencia->execute(
			array($username, $name, $last_name, $email, $photo)
		);

	}

	/**
	 * Eliminar el registro con el identificador especificado
	 *
	 * @param $id identificador del usuario
	 * @return bool Respuesta de la eliminación
	 */
	public static function delete($id)
	{
		// Sentencia DELETE
		$comando = "DELETE FROM user WHERE id=?";

		// Preparar la sentencia
		$sentencia = Database::getInstance()->getDb()->prepare($comando);

		return $sentencia->execute(array($id));
	}
}

?>