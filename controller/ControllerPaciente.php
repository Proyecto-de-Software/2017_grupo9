<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/view/TwigView.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/controller/ControllerSeguridad.php");

	if(!isset($_SESSION)) {
		sec_session_start();
	} else {
		session_regenerate_id();
	}

	function obtenerConfiguracion(){
    	return RepositorioConfiguracion::getInstance()->datosParaLaVista();
    }

    $config = obtenerConfiguracion();
	if(!$config['habilitado']){
	    header("Location: /../");
	}

	function usuarioActual(){
    	if(isset($_SESSION['idUsuario'])){
    		$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_SESSION['idUsuario']);
    		return array(	'logueado'=>true, 
    						'username'=>$usuario->getNombreUsuario(),
    						'roles'=>RepositorioRol::getInstance()->buscarRolesDeUsuario($_SESSION['idUsuario']),
    						'idUsuario'=>$_SESSION['idUsuario'],
    						'token'=>$_SESSION['token']
    					);
    	}
    	else return false;
    }


	function crearPaciente(){
		$paciente = new Paciente($_POST['apellido'], $_POST['nombre'], $_POST['domicilio'], $_POST['telefono'], $_POST['fechaNacimiento'], $_POST['genero'], $_POST['idObraSocial'], $_POST['idTipoDocumento'], $_POST['numeroDoc']);
		return $paciente;
	}

	function listarPacientes($pacientes){
	    echo TwigView::getTwig()->render('administracionPacientes.twig', array('usuarioActual' => usuarioActual(),'lista'=>$pacientes,'configuracion'=>obtenerConfiguracion()));
   	}

    function mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento){
	    echo TwigView::getTwig()->render('administracionMostrarPaciente.twig', array('usuarioActual' => usuarioActual(), 'paciente' => $paciente, 'tipoDeDocumento' => $tipoDeDocumento, 'obraSocial' => $obraSocial, 'configuracion'=>obtenerConfiguracion()));
    }

    function agregarPaciente($obrasSociales,$tiposDeDocumento){
	    echo TwigView::getTwig()->render('administracionAgregarPaciente.twig', array('usuarioActual' => usuarioActual(), 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales, 'configuracion'=>obtenerConfiguracion()));
    }

    function modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento){
	    echo TwigView::getTwig()->render('administracionAgregarPaciente.twig', array('usuarioActual' => usuarioActual(), 'paciente' => $paciente, 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales, 'configuracion'=>obtenerConfiguracion()));
    } 

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':

				//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) {
					$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       		agregarPaciente($obrasSociales,$tiposDeDocumento);
		       	} else {
	    			header("Location: /../");
	    		}
		       	//	}
		       	break;
		    case 'agregarPaciente':
		    	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {
		    		$paciente = crearPaciente();

        			if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
		    			$obraSocial = RepositorioPaciente::getInstance()->devolverObraSocialPorId($paciente->getIdObraSocial());
		    			$tipoDeDocumento = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());
		       			mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento);
		       		}
		       		else{
						$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    			$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       			agregarPaciente($obrasSociales,$tiposDeDocumento);
		       		}
		       	} else {
	    			header("Location: /../");
	    		}
		        break;
		    case 'modificacionDePaciente':
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_update')){
			    	$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
			    	$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
			    	$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
			    	modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento);
			    } else {
	    			header("Location: /../");
	    		}
		    	break;
		    case 'modificarPaciente':
		    //	if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_update')){
		        	RepositorioPaciente::getInstance()->modificarPaciente(crearPaciente());
		        	mostrarPaciente(RepositorioPaciente::getInstance()->buscarPacientePorId($_POST['id']));
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'eliminarPaciente':
		    	//if(($_SESSION['usuario'])->esAdministrador()){
		   		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_destroy')){
		        	if(RepositorioPaciente::getInstance()->eliminarPaciente($_GET['id'])){
		        		listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes());
		        	}
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'mostrarPaciente':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista()){
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_show')){
		    		$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
		    		$obraSocial = RepositorioPaciente::getInstance()->devolverObraSocialPorId($paciente->getIdObraSocial());
		    		$tipoDeDocumento = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());
		    		mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento);
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		    case 'listarPacientes':
		    	//if(($_SESSION['usuario'])->esPediatra() || ($_SESSION['usuario'])->esRecepcionista() || ($_SESSION['usuario'])->esAdministrador()){
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
		        	listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes());
		        } else {
	        		header("Location: /../");
    			}
		       // }
		        break;
		}
	}	

