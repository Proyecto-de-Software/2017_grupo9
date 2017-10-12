<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseConfiguracion.php");

	function crearConfiguracion(){

		return new Configuracion($_POST['titulo'], $_POST['descripcion'], $_POST['email'], $_POST['elementos'], $_POST['habilitado']);
	}

	RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital(crearConfiguracion());

?>