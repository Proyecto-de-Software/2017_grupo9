<?php
	require_once("../model/RepositorioUsuario.php");
	require_once("../model/ClaseUsuario.php");

	function crearUsuario(){
		if(isset($_POST['rol'])){
			for($i=0; $i < count($_POST['rol']); $i++) {
				$roles[$i] = $_POST['rol'][$i];

			}
		return new Usuario($_POST['user'], $_POST['email'], $_POST['password'], true, date("Y-m-d"), date("Y-m-d"), $_POST['name'], $_POST['apellido'], $roles);
		}
		
	}


	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "agregarUsuario":
			
				RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario());
				break;
			case 'modificarUsuario':
				RepositorioUsuario::getInstance()->actualizarUsuario(crearUsuario());
				break;
			case 'eliminarUsuario':
				RepositorioUsuario::getInstance()->eliminarUsuario($_POST['idUsuario']);
				break;
			case 'loginUsuario':
				//RepositorioUsuario::getInstance()-> //hacer login usuario en el modelo
				break;
		}
	}

?>