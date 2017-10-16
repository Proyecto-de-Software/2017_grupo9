<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseDatosDemograficos.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioDatosDemograficos.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');

	if(isset($_SESSION['usuario'])){
		session_start();
	}


	function crearPaciente(){
		$paciente = new Paciente('NULL', $_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], 'NULL', $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	function crearDatosDemograficos(){
		$datosDemograficos = new DatosDemograficos('NULL', $_POST['heladera'], $_POST['electricidad'], $_POST['mascota'], $_POST['tipoVivienda'], $_POST['tipoCalefaccion'], $_POST['tipoAgua']);
		return $datosDemograficos;
	}

	function listarPacientes(){
		//if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('paciente_index')){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarPacientes.php");
	        $view = new ListarPacientes();
	        $view->show(RepositorioPaciente::getInstance()->devolverPacientes());
	  //  } else {
	 //       header("Location: /../");
    //	}
    }

    function mostrarPaciente($paciente){
    	//if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('paciente_show')){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarPaciente.php");
	        $view = new MostrarPaciente();
	        $view->show($paciente);
	   // } else {
	    //    header("Location: /../");
    	//}
    }

    function agregarPaciente($obrasSociales,$tiposDeDocumento,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
    	//if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('paciente_new')){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarPaciente.php");
	        $view = new AgregarPaciente();
	        $view->show($obrasSociales,$tiposDeDocumento,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
	   // } else {
	   // 	header("Location: /../");
	   // }
    }

    function modificarPaciente($paciente,$obrasSociales,$tiposDeDocumento,$datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
    	//if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('paciente_update')){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/FormularioModificarPaciente.php");
	        $view = new ModificarPaciente();
	        $view->show($paciente,$obrasSociales,$tiposDeDocumento,$datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
	    //}
    } 

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':
				//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
					$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
			    	$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
			    	$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
			    	$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		       		agregarPaciente($obrasSociales,$tiposDeDocumento,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
		       	//	}
		       	break;
		    case 'agregarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){

		    		$paciente = crearPaciente();

		       		if($pacienteAgregado = RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
		       			mostrarPaciente($pacienteAgregado);
		       		}
		       		else{
		       		
		       			$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
			    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
				    	$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
				    	$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
				    	$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		       			agregarPaciente($obrasSociales,$tiposDeDocumento,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
		       		}
		            break;
		    case 'modificacionDePaciente':
		    	$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']);
		    	$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    	$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		    	$datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorId(1);
		    	$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
		    	$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
		    	$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		    	modificarPaciente($paciente,$obrasSociales,$tiposDeDocumento,$datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
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
	