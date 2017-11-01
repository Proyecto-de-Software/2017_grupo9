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

      	public function obtenerDatosDeConfiguracion(){
      		$conexion = $this->getConnection();
      		$query = $conexion->prepare("SELECT * FROM configuracion");
      		$query->execute();
      		$resultado = $query->fetchAll();
      		if(count($resultado)>0){
  				$configuracion = new Configuracion($resultado[0]['titulo'],$resultado[0]['descripcion_hospital'],$resultado[0]['descripcion_guardia'],$resultado[0]['descripcion_especialidades'],$resultado[0]['email_contacto'],$resultado[0]['cantidad_elementos_pagina'],$resultado[0]['habilitado']);
  				$configuracion->setId($resultado[0]['id']);
      			return $configuracion;
      		}
      		else return false;

      	}
      	public function datosParaLaVista(){
      		$config = obtenerDatosDeConfiguracion();
      		$datosConfigurados =array(
	    		'habilitado' => $config->getHabilitado(),
	    		'titulo' => $config->getTitulo(),
	            'hospital' => $config->getDescripcionHospital(),
	            'guardia' => $config->getDescripcionGuardia(),
	            'especialidades' => $config->getDescripcionEspecialidades(),
	            'contacto' => $config->getContacto()
        	);
        	return $datosConfigurados;
      	}
      	public function crearConfiguracionHospital($configuracion){
      		$conexion = $this->getConnection();
			$query = $conexion->prepare("INSERT INTO configuracion(titulo,descripcion_hospital, email_contacto, cantidad_elementos_pagina, habilitado,descripcion_guardia,descripcion_especialidades) VALUES(:titulo, :descripcion_hospital,:contacto, :cantElem, :habilitado, :descripcion_guardia, :descripcion_especialidades)");

			$query->bindParam(':titulo', $configuracion->getTitulo());
			$query->bindParam(':descripcion_hospital', $configuracion->getDescripcionHospital());
			$query->bindParam(':descripcion_guardia', $configuracion->getDescripcionGuardia());
			$query->bindParam(':descripcion_especialidades', $configuracion->getDescripcionEspecialidades());
			$query->bindParam(':contacto', $configuracion->getContacto());
			$query->bindParam(':cantElem', $configuracion->getCantElem());
			$query->bindParam(':habilitado', $configuracion->getHabilitado());

			return $query->execute() == 1;
      	}
		public function modificarConfiguracionHospital($configuracion) {
				$conexion = $this->getConnection();
				$query = $conexion->prepare("UPDATE configuracion SET titulo=:titulo, descripcion_hospital=:descripcion_hospital,email_contacto=:contacto, cantidad_elementos_pagina=:cantElem, habilitado=:habilitado, descripcion_guardia=:descripcion_guardia,descripcion_especialidades=:descripcion_especialidades  WHERE id=:id");
				$query->bindParam(':id', $configuracion->getId());
				$query->bindParam(':titulo', $configuracion->getTitulo());
				$query->bindParam(':descripcion_hospital', $configuracion->getDescripcionHospital());
				$query->bindParam(':descripcion_guardia', $configuracion->getDescripcionGuardia());
				$query->bindParam(':descripcion_especialidades', $configuracion->getDescripcionEspecialidades());
				$query->bindParam(':contacto', $configuracion->getContacto());
				$query->bindParam(':cantElem', $configuracion->getCantElem());
				$query->bindParam(':habilitado', $configuracion->getHabilitado());
				return $query->execute() == 1;
		}
	}