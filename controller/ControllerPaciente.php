<?php

	session_start();
	require_once("ClasePaciente.php");
	require_once("RepositorioPaciente.php");
	require_once("RepositorioUsuario.php");

	public function crearPaciente(){
		$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idDatosDemograficos'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	if(isset($_GET['action']){
		switch ($_GET['action']) {
		    case 'agregarPaciente':
		    	if(RepositorioUsuario::getInstance()->esPediatra($_SESSION['roles']) || RepositorioUsuario::getInstance()->esRecepcionista($_SESSION['roles'])){
		    		$paciente = crearPaciente();
		       		if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
		       			ResourceController::getInstance()->mostrarPaciente($paciente);
		       		}
		       		else{
		       			ResourceController::getInstance()->agregarPaciente();
		       		}
		       	}
		        break;
		    case 'modificarPaciente':
		    	if(RepositorioUsuario::getInstance()->esPediatra($_SESSION['roles']) || RepositorioUsuario::getInstance()->esRecepcionista($_SESSION['roles'])){
		        	RepositorioPaciente::getInstance()->modificarPaciente(crearPaciente());
		        	ResourceController::getInstance()->pacientes();
		        }
		        break;
		    case 'eliminarPaciente':
		    	if(RepositorioUsuario::getInstance()->esAdministrador($_SESSION['roles'])){
		        	RepositorioPaciente::getInstance()->eliminarPaciente(crearPaciente());
		        	ResourceController::getInstance()->pacientes();
		        }
		        break;
		    }
		    case 'mostrarPaciente':
		    	if(RepositorioUsuario::getInstance()->esPediatra($_SESSION['roles']) || RepositorioUsuario::getInstance()->esRecepcionista($_SESSION['roles'])){
		        	RepositorioPaciente::getInstance()->eliminarPaciente(crearPaciente());
		        	ResourceController::getInstance()->paciente();
		        }
		        break;
		    }
		    case 'listarPacientes':
		    	if(RepositorioUsuario::getInstance()->esPediatra($_SESSION['roles']) || RepositorioUsuario::getInstance()->esRecepcionista($_SESSION['roles'])){
		        	RepositorioPaciente::getInstance()->eliminarPaciente(crearPaciente());
		        	ResourceController::getInstance()->pacientes();
		        }
		        break;
		    }
		}

	