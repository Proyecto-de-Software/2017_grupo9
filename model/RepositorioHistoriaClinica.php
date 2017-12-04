<?php

	require_once("PDORepository.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseControl.php');
 


	class RepositorioHistoriaClinica extends PDORepository{
		private static $instance;

      	public static function getInstance() {
	    	if (!isset(self::$instance)) {
	    		self::$instance = new RepositorioHistoriaClinica();
	    	}

        	return self::$instance;
        }
        public  function obtenerControles($idPaciente){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare('SELECT * FROM control_salud WHERE paciente_id=:paciente_id');
        	$query->bindParam(':paciente_id', $idPaciente);
        	$query->execute();
        	$controles = [];
       		$resultado = $query->fetchAll();
       		foreach ($resultado as $control) {
       			array_push($controles, new Control($control));
       		}
       		return $controles;
        }

        public function buscarControlPorId($idControl){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare('SELECT * FROM control_salud WHERE id=:idControl');
        	$query->bindParam(':idControl', $idControl);
        	$resultado = $query->execute();
        	if($resultado){
        		$control = $query->fetchAll()[0];
        		return new Control($control);
        	}
        	else{
        		return false;
        	}
        }
        public function agregarControl($control){
        	
        }
	}

?>