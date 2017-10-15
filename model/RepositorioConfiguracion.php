<?php

	require_once("PDORepository.php");
	require_once("ClaseConfiguracion.php");

	class RepositorioConfiguracion extends PDORepository{

		private static $instance;

      	public static function getInstance() {
          	if (!isset(self::$instance)) {
              	self::$instance = new RepositorioConfiguracion();
          	}

          	return self::$instance;
      	} 

		public function modificarConfiguracionHospital($datosConfiguracion) {
				$conexion = $this->getConnection();

				$query = $conexion->prepare("UPDATE configuracion SET titulo=:titulo, descripcion=:descripcion, email_contacto=:contacto, cantidad_elementos_pagina=:cantElem, habilitado=:habilitado WHERE id=1");
	
				$query->bindParam(':titulo', $datosConfiguracion->getTitulo());
				$query->bindParam(':descripcion', $datosConfiguracion->getDescripcion());
				$query->bindParam(':contacto', $datosConfiguracion->getContacto());
				$query->bindParam(':cantElem', $datosConfiguracion->getCantElem());

				return $query->execute() == 1;
		}
	}