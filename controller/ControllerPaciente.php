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
	    echo TwigView::getTwig()->render('administracionPacientes.twig', array('usuarioActual' => usuarioActual(),'lista'=>$pacientes,'configuracion'=>obtenerConfiguracion(), 'paginado' => datosDePaginado()));
   	}

    function mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento){
	    echo TwigView::getTwig()->render('administracionMostrarPaciente.twig', array('usuarioActual' => usuarioActual(), 'paciente' => $paciente, 'tipoDeDocumento' => $tipoDeDocumento, 'obraSocial' => $obraSocial, 'configuracion'=>obtenerConfiguracion()));
    }

    function agregarPaciente($obrasSociales,$tiposDeDocumento,$validacion=[]){ //paranetro validacion = null
	    echo TwigView::getTwig()->render('administracionAgregarPaciente.twig', array('usuarioActual' => usuarioActual(), 'validacion'=>$validacion, 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales, 'configuracion'=>obtenerConfiguracion()));
    }

    function modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento,$validacion=[]){
	    echo TwigView::getTwig()->render('administracionModificarPaciente.twig', array('usuarioActual' => usuarioActual(), 'paciente' => $paciente, 'validacion'=>$validacion, 'tiposDeDocumento' => $tiposDeDocumento, 'obrasSociales' => $obrasSociales, 'configuracion'=>obtenerConfiguracion()));
    } 

    function datosDePaginado(){

    	$cantidadPacientes = (int)RepositorioPaciente::getInstance()->cantidadDePacientes();
    	$cantidadPorPagina = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
    	$cantidadDePaginas = ceil($cantidadPacientes/$cantidadPorPagina);
    	$actual = 1;
    	if(isset($_GET['page'])){
    		$actual = $_GET['page'];
    	}
    	if($actual <= 1){
    		$limit = 0;
    	}
    	else{
    		$limit = $cantidadPorPagina * ($actual - 1);
    	}
    	
    	$retorno = array(
    		'cantidadPorPagina' => $cantidadPorPagina,
    		'cantPaginas' =>  $cantidadDePaginas,
    		'actual' => $actual,
    		'limit' => $limit
    			);

    	return $retorno;
    }

	if(isset($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDePaciente':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) {
					$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
		       		agregarPaciente($obrasSociales,$tiposDeDocumento);
		       	} else {
	    			header("Location: /../");
	    		}
		       	break;
		    case 'agregarPaciente':
		    	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {
		    		$paciente = crearPaciente();
		    		$validacion = RepositorioPaciente::getInstance()->pacienteValido($paciente);
		    		if ($validacion['ok']){
						if(RepositorioPaciente::getInstance()->agregarPaciente($paciente)){
	        				$id = $paciente->getId();
			    			header("location: /../controller/ControllerPaciente.php/?action=mostrarPaciente&id=$id");
			       		}
			       		else{
			    			header("location: /../controller/ControllerPaciente.php/?action=altaDePaciente");
			       		}
			       	} else{		       		
			    		$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
		    			$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
						agregarPaciente($obrasSociales,$tiposDeDocumento,$validacion);
					}
			       	
		       	} else {
	    			header("Location: /../");
	    		}
		        break;
		    case 'modificacionDePaciente': //Ok
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
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_update')){
		    		$paciente = crearPaciente();
		    		$paciente->setId($_GET['id']);
		    		$validacion = $validacion = RepositorioPaciente::getInstance()->pacienteValido($paciente,true);
		    		$id = $paciente->getId();
					if($validacion['ok']){
			    		if(RepositorioPaciente::getInstance()->modificarPaciente($paciente)){
			    			header("location: /../controller/ControllerPaciente.php/?action=mostrarPaciente&id=$id");
		        		}
		        	}
		        	else {
		        		$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
				    	$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
				    	$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
				    	modificarPaciente($paciente, $obrasSociales, $tiposDeDocumento,$validacion);
		        	}
		        } else {
	        		header("Location: /../");
    			}
		        break;
		    case 'eliminarPaciente':
		   		if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_destroy')){
		        	if(RepositorioPaciente::getInstance()->eliminarPaciente($_GET['id'])){
		        		header("location: /../controller/ControllerPaciente.php/?action=listarPacientes");
						$paginado = datosDePaginado();
		        		listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes($paginado['limit'],$paginado['cantidadPorPagina']));
		        	}
		        } else {
	        		header("Location: /../");
    			}
		        break;
		    case 'mostrarPaciente': //Ok
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_show')){
		    		$paciente = RepositorioPaciente::getInstance()->buscarPacientePorId($_GET['id']);
		    		$obraSocial = RepositorioPaciente::getInstance()->devolverObraSocialPorId($paciente->getIdObraSocial());
		    		$tipoDeDocumento = RepositorioPaciente::getInstance()->devolverTipoDeDocumentoPorId($paciente->getIdTipoDocumento());
		    		mostrarPaciente($paciente,$obraSocial,$tipoDeDocumento);
		        } else {
	        		header("Location: /../");
    			}
		        break;
		    case 'listarPacientes': //Ok
		    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
					$paginado = datosDePaginado();
		        	listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes($paginado['limit'],$paginado['cantidadPorPagina']));
		        } else {
	        		header("Location: /../");
    			}
		        break;
		     case 'busquedaNomYAp':
		     	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
					$paginado = datosDePaginado();
		     		listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes($paginado['limit'],$paginado['cantidadPorPagina'],$_POST['busquedaNombre'],$_POST['busquedaApellido']));
		     	} else {
	        		header("Location: /../");
    			}
    			break;
			case 'busquedaDocumento':
		     	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'paciente_index')){
					$paginado = datosDePaginado();
		     		listarPacientes(RepositorioPaciente::getInstance()->devolverPacientes($paginado['limit'],$paginado['cantidadPorPagina'],'','',$_POST['busquedaTipoDoc'],$_POST['busquedaNumeroDoc']));
		     	} else {
	        		header("Location: /../");
    			}
    			break;
		}
	}	

