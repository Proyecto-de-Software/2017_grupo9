<?php
	
	$url = explode('/',$_SERVER['PATH_INFO']);
	switch ($url[0]) {
		#Inicio rutas de usuario
		case 'usuario':
		if (isset($url[1]) && is_numeric($url[1])) {
			$idUsuario = $url[1];
			if(isset($url[2])){
				switch ($url[2])) {
					case 'editar':
						ControllerUsuario::getInstance()->editar($idUsuario);
						break;
					case 'edicion':
						$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($idUsuario);
						ControllerUsuario::getInstance()->formularioUsuario($usuario);
						break;
					case 'eliminar':
						ControllerPaciente::getInstance()->eliminar($idUsuario);
						break;
					default:
						header("Location: ./index.php/usuario/$idUsuario");
						break;
				}
			}
			else{
				ControllerUsuario::getInstance()->mostrarUsuario($idUsuario);
			}
			break;
		case 'usuarios':
			if(isset($url[1])){
				switch ($url[1]) {
					case 'agregar':
						ControllerUsuario::getInstance()->agregar();
						break;
					case 'nuevo':
						ControllerUsuario::getInstance()->formularioUsuario();
						break;
					case 'filtrado':
						//recupero filtrado por post
						//ControllerPaciente::getInstance()->listarPacientes($filtrado);
						break;
					default:
						header("Location: ./index.php/usuarios");
						break;
				}
			}
			else{
				ControllerUsuario::getInstance()->listarUsuarios();
			}
			break;
		#Fin de rutas de usuario

		#Inicio rutas login
		case 'entrar':	
			//ControllerUsuario::getIntance()->loginUsuario($_POST['email'],$_POST['password']);
			break;
		case 'login':
			//ControllerUsuario::getIntance()->formularioLogin();
			break;
		case 'cerrarSesion':
			ControllerUsuario::getIntance()->cerrarSesion();
			break;
		#Fin de rutas del login

		#Inicio rutas de paciente
		case 'paciente':
			if (isset($url[1]) && is_numeric($url[1])) {
				$idPaciente = $url[1];
				if(isset($url[2])){
					switch ($url[2])) {
						case 'editar': //Editar paciente
							ControllerPaciente::getInstance()->modificar($idPaciente);
							break;
						case 'eliminar':
							ControllerPaciente::getInstance()->eliminar($idPaciente);
							break;
						case 'datosDemograficos':
							if(isset($url[3])){
								switch ($url[3])){
									case 'editar': //Editar datos demograficos
										ControllerDatosDemograficos::getInstance()->modificar($idPaciente);
										break;
									case 'eliminar':
										ControllerDatosDemograficos::getInstance()->eliminar($idPaciente);
										break;
									case 'agregar':
										ControllerDatosDemograficos::getInstance()->agregar($idPaciente);
										break;
									default:
										header("Location: ./index.php/paciente/$idPaciente/datosDemograficos");
										break;
								}
									
							}
							else{
								ControllerDatosDemograficos::getInstance()mostrar($idPaciente);
							}
							break;
						default:
							header("Location: ./index.php/paciente/$idPaciente");
							break;
					}
				}
				else {
					ControllerPaciente::getInstance()->mostrar($idPaciente);
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
						ControllerPaciente::getInstance()->formularioPaciente();
						break;
					case 'busquedaDocumento':
						ControllerPaciente::getInstance()->busqueda($_POST['busquedaTipoDoc'],$_POST['busquedaNumeroDoc']);
						break;
					case 'busquedaNombre':
						ControllerPaciente::getInstance()->busqueda($_POST['busquedaNombre'],$_POST['busquedaApellido']);
						break;
					default:
						header("Location: ./index.php/pacientes");
						break;
				}
			}
			else{
				ControllerPaciente::getInstance()->listarTodos();
			}
			break;

		#Fin de rutas de paciente

		#Inicio de rutas de configuracion
		case 'configuracion':
			ControllerConfiguracion::getInstance()->formularioConfiguracion();
			break;
		case 'configurar':
				ControllerConfiguracion::getInstance()->modificarConfiguracion();
			}else{
				header("Location: ./index.php/configuracion");
			}
			break;
		default:
			//HOME
			Controller::getInstance()->render('base.twig.html');
		#Fin de rutas de configuracion

?>