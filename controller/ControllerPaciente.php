<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	session_start();
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');

	function crearPaciente(){
		$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idDatosDemograficos'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	function listarPacientes($pacientes){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarPacientes.php");
        $view = new ListarPacientes();
        $view->show($pacientes);
    }

    function mostrarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarPacientes.php");
        $view = new MostrarPaciente();
        $view->show();
    }

    function agregarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarPaciente.php");
        $view = new AgregarPaciente();
        $view->show();
    }

    function modificarPaciente(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ModificarPaciente.php");
        $view = new ModificarPaciente();
        $view->show();
    } 

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':
				//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		       		agregarPaciente();
		       	//	}
		       	break;
		    case 'agregarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    		$paciente = crearPaciente();
		       		if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
		       			mostrarPaciente($paciente);
		       		}
		       		else{
		       			agregarPaciente();
		       		}
		       //	}
		        break;
		    case 'modificarPaciente':
		    //	if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		        	$paciente = crearPaciente();
		        	if(RepositorioPaciente::getInstance()->modificarPaciente($paciente)){
		        		listarPacientes();
		        	}
		       // }
		        break;
		    case 'eliminarPaciente':
		    	//if(($_SESSION['usuario'])->esAdministrador()){
		    		$paciente = crearPaciente();
		        	if(RepositorioPaciente::getInstance()->eliminarPaciente($paciente)){
		        		listarPacientes();
		        	}
		       // }
		        break;
		    case 'mostrarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		        	mostrarPaciente();
		       // }
		        break;
		    case 'listarPacientes':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista() || ($_SESSION['usuario'])->esAdministrador()){
		    		$pacientes = RepositorioPaciente::getInstance()->devolverPacientes();
		        	listarPacientes($pacientes);
		       // }
		        break;
		    }
		}

	

