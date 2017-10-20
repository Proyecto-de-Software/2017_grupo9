<?php
	
	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);

	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/view/TwigView.php");

	if(!isset($_SESSION)){
		session_start();	
	}

	function crearDatosDemograficos(){
		$datosDemograficos = new DatosDemograficos($_POST['heladera'], $_POST['electricidad'], $_POST['mascota'], $_POST['tipoVivienda'], $_POST['tipoCalefaccion'], $_POST['tipoAgua'], $_POST['paciente']);
		return $datosDemograficos;
	}

	DatosDemograficos($_GET['action'])){
		switch ($_GET['action']) {
			case 'altaDeDatosDemograficos':
				$obrasSociales = RepositorioPaciente::getInstance()->devolverObrasSociales();
	    		$tiposDeDocumento = RepositorioPaciente::getInstance()->devolverTiposDeDocumento();
	       		agregarPaciente($obrasSociales,$tiposDeDocumento);
	       		break;

	    	case 'agergarDatosDemograficos':

		}
	}
