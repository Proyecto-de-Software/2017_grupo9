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

	if(!isset($_SESSION))
		session_start();

	function crearConfiguracion(){
		return new Configuracion($_POST['titulo'], $_POST['descripcion'], $_POST['email'], $_POST['elementos'], $_POST['habilitado']);
	}

	function config(){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/Config.php");
        $view = new Config();
        $view->show();
    }

    if(isset($_GET['action'])){
    	switch ($_GET['action']) {
	    	case 'panel':
	    		config();
	    		break;
	    	case 'modificarConfiguracion':
	    		RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital(crearConfiguracion());
	    		header("Location: /../");
	    		break;
	    }
	}

?>