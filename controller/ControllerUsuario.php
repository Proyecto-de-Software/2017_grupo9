<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");

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
				if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
					RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario());
				} else {
					echo("Las contraseñas no coinciden");
				}				
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