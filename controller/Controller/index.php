<?php
	
	$url = explode('/',$_SERVER['PATH_INFO']);
	switch ($url[0]) {
		//Rutas de usuario
		case 'usuario':
			$idUsuario = $url[1];
			if(is_numeric($idUsuario)){
				ControllerUsuario::getInstance()->mostrarUsuario($idUsuario);
			}
			else{
				header("Location: ./usuarios");
			}
			break;
		case 'usuarios':
			ControllerUsuario::getInstance()->listarUsuarios();
			break;
		case 'paciente':
			$idPaciente = $url[1];
			if(is_numeric($idPaciente)){
				ControllerPaciente::getInstance()->mostrarPaciente($idPaciente);
			}
			else{
				header("Location:/usuarios");
			}
			break;
		case 'pacientes':
			ControllerPaciente::getInstance()->listarPacientes();
			break;


?>