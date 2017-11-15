<?php

class ControllerPaciente extends Controller{
	
      public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerPaciente();
      	}
      	return self::$instance;
      }  

      public function crearPaciente(){
      	//Instancia un objeto de la clase Paciente, con los datos recibidos por POST desde el formulario de alta o edicion de datos del paciente.
      	$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
      } 

 
	
?>