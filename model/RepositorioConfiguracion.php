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
				//$query = $conexion->prepare("UPDATE configuracion SET titulo='titulo', descripcion='descripcion', email_contacto='contacto@hotmail.com', cantidad_elementos_pagina=5, habilitado=1 WHERE id=1");

				$query->bindParam(':titulo', $datosConfiguracion->getTitulo());
				$query->bindParam(':descripcion', $datosConfiguracion->getDescripcion());
				$query->bindParam(':contacto', $datosConfiguracion->getContacto());
				$query->bindParam(':cantElem', $datosConfiguracion->getCantElem());
				$query->bindParam(':habilitado', $datosConfiguracion->getHabilitado());

				echo('titulo: '.$datosConfiguracion->getTitulo());
				echo ($datosConfiguracion->getTitulo());
				echo('descripcion: '.$datosConfiguracion->getDescripcion());
				echo('contacto: '.$datosConfiguracion->getContacto());
				echo('cantElem: '.$datosConfiguracion->getCantElem());
				echo('habilitado: '.$datosConfiguracion->getHabilitado());



				//print_r($conexion->errorInfo());

				//var_dump($datosConfiguracion);

				//return $query->execute() == 1
				if($query->execute() == 1){
					echo "TODO SALIO BIEN!";
				} else {
					echo "TODO SALIO MAL\n";
					echo "\nPDO::errorCode(): ", $query->errorCode();
				}
		}
	}