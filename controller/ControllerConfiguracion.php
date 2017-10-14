<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseConfiguracion.php");

	function crearConfiguracion(){
		echo "Titulo: ".$_POST['titulo'];
		echo "\nDescripcion: ".$_POST['descripcion'];
		echo "\nEmail: ".$_POST['email'];
		echo "\nElementos: ".$_POST['elementos'];
		echo "\nHabilitado: ".$_POST['habilitado'];


		return new Configuracion($_POST['titulo'], $_POST['descripcion'], $_POST['email'], $_POST['elementos'], $_POST['habilitado']);
	}

	RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital(crearConfiguracion());

?>