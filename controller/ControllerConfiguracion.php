<?php

	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseConfiguracion.php");
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
	function usuarioActual(){
    	if(isset($_SESSION['idUsuario'])){
    		$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_SESSION['idUsuario']);
    		return array(	'logueado'=>true, 
    						'username'=>$usuario->getNombreUsuario(),
    						'roles'=>RepositorioRol::getInstance()->buscarRolesDeUsuario($_SESSION['idUsuario']),
    						'idUsuario'=>$_SESSION['idUsuario']
    					);
    	}
    	else return false;
    }
	function obtenerConfiguracion(){
    	return RepositorioConfiguracion::getInstance()->datosParaLaVista();
    }
    $config = obtenerConfiguracion();
	if(!$config['habilitado']){
	    header("Location: /../");
	}

	function crearConfiguracion(){
		if( $_POST['estado'] == 'habilitado'){
			$habilitado = 1;
		}
		else{
			$habilitado = 0;
		}
		$configuracion = new Configuracion($_POST['titulo'], $_POST['descripcionHospital'],$_POST['descripcionGuardia'],$_POST['descripcionEspecialidades'], $_POST['email'], $_POST['elementos'],$habilitado);
		if($_POST['edit'] == 'editar') $configuracion->setId($_POST['id']);
		return $configuracion;
	}


	function mostrarFormularioConfiguracion($configuracionActual=null,$mensaje=null){
        echo TwigView::getTwig()->render('administracionConfiguracion.twig', array('usuarioActual'=>usuarioActual(),'configuracionActual'=> $configuracionActual,'mensaje'=>$mensaje, 'configuracion'=>obtenerConfiguracion()));
    }
    function validarCampos(){
    	$titulo = isset($_POST['titulo']) && trim($_POST['titulo']) !='';
    	$descripcionHospital = isset($_POST['descripcionHospital']) && trim($_POST['descripcionHospital']) !='';
    	$descripcionGuardia = isset($_POST['descripcionGuardia']) && trim($_POST['descripcionGuardia']) !='';
    	$descripcionEspecialidades = isset($_POST['descripcionEspecialidades']) && trim($_POST['descripcionEspecialidades']) !='';
    	$email = isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    	$elementos = isset($_POST['elementos']);
    	return $titulo &&	$descripcionHospital && $descripcionGuardia && $descripcionEspecialidades && $email && $elementos;

    }

    if(isset($_GET['action'])){
    	switch ($_GET['action']) {
	    	case 'modificacionConfiguracion':
	    			if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'configuracion_update')) {
	    				mostrarFormularioConfiguracion(RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion());
	    			} else {
						header("Location: /../");
					}
	    		break;
	    	case 'modificacionConfiguracionNoValidado':
	    		mostrarFormularioConfiguracion(RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion(),'Debe llenar todos los campos. Tenga en cuenta que el email debe tener un formato válido');
	    		break;

	    	case 'modificarConfiguracion':
	    		if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'configuracion_update')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {
		    		if(validarCampos()){
			    		if($_POST['edit']=='editar'){ 
			    			RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital(crearConfiguracion());

			    		}
			    		else{
			    		RepositorioConfiguracion::getInstance()->crearConfiguracionHospital(crearConfiguracion());

			    		}
			    		header("Location: /../controller/ControllerConfiguracion.php?action=modificacionConfiguracion");
			    	}
			    	else{
			    		header("Location: /../controller/ControllerConfiguracion.php?action=modificacionConfiguracionNoValidado");
			    	}
			    } else {
			    	header("Location: /../");
			    }
	    		break;
	    }
	}

?>