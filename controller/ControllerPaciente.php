<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	session_start();
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');

	function crearPaciente(){
		$paciente = new Paciente($_POST['id'], $_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idDatosDemograficos'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	function listarPacientes(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarPacientes.php");
        $view = new ListarPacientes();
        $view->show(RepositorioPaciente::getInstance()->devolverPacientes());
    }

    function mostrarPaciente($paciente){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarPaciente.php");
        $view = new MostrarPaciente();
        $view->show($paciente);
    }

    function agregarPaciente($obrasSociales,$tiposDeDocumento){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarPaciente.php");
        $view = new AgregarPaciente();
        $view->show($obrasSociales,$tiposDeDocumento);
    }

    function modificarPaciente($paciente,$obrasSociales,$tiposDeDocumento){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/FormularioModificarPaciente.php");
        $view = new ModificarPaciente();
        $view->show($paciente,$obrasSociales,$tiposDeDocumento);
    } 

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':
				//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
					$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       		agregarPaciente($obrasSociales,$tiposDeDocumento);
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
		    case 'modificacionDePaciente':
		    	$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']);
		    	$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    	$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		    	modificarPaciente($paciente,$obrasSociales,$tiposDeDocumento);
		    	break;
		    case 'modificarPaciente':
		    //	if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		        	RepositorioPaciente::getInstance()->modificarPaciente(crearPaciente());
		        	mostrarPaciente(RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']));
		       // }
		        break;
		    case 'eliminarPaciente':
		    	//if(($_SESSION['usuario'])->esAdministrador()){
		        	if(RepositorioPaciente::getInstance()->eliminarPaciente($_POST['id'])){
		        		listarPacientes();
		        	}
		       // }
		        break;
		    case 'mostrarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    		$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']);
		        	mostrarPaciente($paciente);
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

	

