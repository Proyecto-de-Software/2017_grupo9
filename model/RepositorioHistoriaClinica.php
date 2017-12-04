<?php

	require_once("PDORepository.php");
 


	class RepositorioHistoriaClinica extends PDORepository{
		private static $instance;

      	public static function getInstance() {
	    	if (!isset(self::$instance)) {
	    		self::$instance = new RepositorioPaciente();
	    	}

        	return self::$instance;
        }


        public function agregarControl($control){
        	
        }
	}

?>