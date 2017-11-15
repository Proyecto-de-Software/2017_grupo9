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
			if (isset($url[1]) && is_numeric($url[1])) {
				$idPaciente = $url[1];
				if(isset($url[2])){
					switch ($url[2])) {
						case 'editar': //Editar paciente
							//ControllerPaciente::getInstance()->
							break;
						case 'eliminar':
							//ControllerPaciente::getInstance()
							break;
						case 'datosDemograficos':
							if(isset($url[3])){
								switch ($url[3])){
									case 'editar': //Editar datos demograficos
										//ControllerDatosDemograficos::getInstance()->
										break;
									case 'eliminar':
										//ControllerDatosDemograficos::getInstance()
										break;
									case 'agregar':
										//ControllerDatosDemograficos::getInstance()
										break;
									default:
										header("Location: ./index.php/paciente/$idPaciente/datosDemograficos");
										break;
								}
									
							}
							else{
								ControllerDatosDemograficos::getInstance()mostrarDatosDemograficos($idPaciente);
							}
							break;
						default:
							header("Location: ./index.php/paciente/$idPaciente");
							break;
					}
				}
				else {
					ControllerPaciente::getInstance()->mostrarPaciente($idPaciente);
				}

			}
			else{
				header("Location: ./index.php/pacientes");
			}
		
			break;
		case 'pacientes':
			if(isset($url[1])){
				switch ($url[1]) {
					case 'nuevo':
						//ControllerPaciente::getInstance()->agregar();
						break;
					case 'busquedaDocumento':
						//ControllerPaciente::getInstance()->
						break;
					case 'busquedaNombre':
						//ControllerPaciente::getInstance()->
						break;
					default:
						header("Location: ./index.php/pacientes");
						break;
				}
			}
			else{
				ControllerPaciente::getInstance()->listarPacientes();
			}
			break;



?>