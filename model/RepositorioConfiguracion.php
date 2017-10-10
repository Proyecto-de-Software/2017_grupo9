<?php

	require_once("PDORepository.php");
	require_once("ClaseConfiguracion.php");

	class RepositorioConfiguracion extends PDORepository{

		public function modificarConfiguracionHospital($datosConfiguracion) {
				$conexion = $this->getConnection();

				$query = $conexion->prepare("UPDATE configuracion SET titulo=:titulo, descripcion=:descripcion, email_contacto=:contacto, cantidad_elementos=:cantElem, habilitado=:habilitado");

				$query->bindParam(':titulo', $datosConfiguracion->getTitulo());
				$query->bindParam(':descripcion', $datosConfiguracion->getDescripcion());
				$query->bindParam(':contacto', $datosConfiguracion->getContacto());
				$query->bindParam(':cantElem', $datosConfiguracion->getCantElem());
				$query->bindParam(':habilitado', $datosConfiguracion->getHabilitado());

				return $query->execute() == 1;
		}
	}