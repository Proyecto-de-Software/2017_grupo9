<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/Controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/ControllerUsuario.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/ControllerPaciente.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/ControllerConfiguracion.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/ControllerDatosDemograficos.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/ControllerSeguridad.php');

	//echo '<pre>'; var_dump($_SERVER); echo '</pre>'; die();
	if(isset($_SERVER['PATH_INFO'])){
		$path = $_SERVER['PATH_INFO'];
	}
	else{
		$path = '/';
	}
	$url = explode('/',$path);
	switch ($url[1]) {
		#Inicio rutas de usuario
		case 'usuario':
		if (isset($url[2]) && is_numeric($url[2])) {
			$idUsuario = $url[2];
			if(isset($url[3])){
				switch ($url[3]) {
					case 'editar':
						ControllerUsuario::getInstance()->editar($idUsuario);
						break;
					case 'edicion':
						ControllerUsuario::getInstance()->formularioUsuario($idUsuario);
						break;
					case 'eliminar':
						ControllerUsuario::getInstance()->eliminar($idUsuario);
						break;
					case 'activar':
						ControllerUsuario::getInstance()->activar($idUsuario);
						break;
					case 'bloquear':
						ControllerUsuario::getInstance()->bloquear($idUsuario);
						break;
					default:
						header("Location: /index.php/usuario/$idUsuario");
						break;
				}
			}
			else{
				ControllerUsuario::getInstance()->mostrarUsuario($idUsuario);
			}
		}
		else header("Location: /index.php");
			break;
		case 'usuarios':
			if(isset($url[2])){
				switch ($url[2]) {
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
						header("Location: /index.php/usuarios");
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
			ControllerUsuario::getInstance()->loginUsuario($_POST['email'],$_POST['password']);
			break;
		case 'login':
			ControllerUsuario::getInstance()->formularioLogin();
			break;
		case 'cerrarSesion':
			ControllerUsuario::getInstance()->cerrarSesion();
			break;
		#Fin de rutas del login

		#Inicio rutas de paciente
		case 'paciente':
			if (isset($url[2]) && is_numeric($url[2])) {
				$idPaciente = $url[2];
				if(isset($url[3])){
					switch ($url[3]) {
						case 'editar': //Editar paciente
							ControllerPaciente::getInstance()->modificar($idPaciente);
							break;
						case 'edicion':
							ControllerPaciente::getInstance()->formulario($idPaciente);
							break;
						case 'eliminar':
							ControllerPaciente::getInstance()->eliminar($idPaciente);
							break;
						case 'datosDemograficos':
							if(isset($url[4])){
								switch ($url[4]){
									case 'editar': //Editar datos demograficos
										ControllerDatosDemograficos::getInstance()->modificar($idPaciente);
										break;
									case 'edicion':
									case 'nuevo':
										ControllerDatosDemograficos::getInstance()->formulario($idPaciente);
										break;
									case 'eliminar':
										ControllerDatosDemograficos::getInstance()->eliminar($idPaciente);
										break;
									case 'agregar':
										ControllerDatosDemograficos::getInstance()->agregar($idPaciente);
										break;
									default:
										header("Location: /index.php/paciente/$idPaciente/datosDemograficos");
										break;
								}
									
							}
							else{
								ControllerDatosDemograficos::getInstance()->mostrar($idPaciente);
							}
							break;
						default:
							header("Location: /index.php/paciente/$idPaciente");
							break;
					}
				}
				else {
					ControllerPaciente::getInstance()->mostrar($idPaciente);
				}

			}
			else{
				header("Location: /index.php/pacientes");
			}
		
			break;
		case 'pacientes':
			if(isset($url[2])){
				switch ($url[2]) {
					case 'nuevo':
						ControllerPaciente::getInstance()->formulario();
						break;
					case 'agregar':
						ControllerPaciente::getInstance()->agregar();
						break;
					case 'busquedaDocumento':
						ControllerPaciente::getInstance()->busqueda($_POST['busquedaTipoDoc'],$_POST['busquedaNumeroDoc']);
						break;
					case 'busquedaNombre':
						ControllerPaciente::getInstance()->busqueda($_POST['busquedaNombre'],$_POST['busquedaApellido']);
						break;
					default:
						header("Location: /index.php/pacientes");
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
			if(isset($_POST['edit'])){
				$edit = $_POST['edit'];
				if($edit =='editar'){
					$edit = true;
				}
				elseif($edit=='agregar'){
					$edit = false;
				}
			}
			if(isset($_POST['button']))
				ControllerConfiguracion::getInstance()->modificarConfiguracion($edit);
			break;
		default:
			//HOME
			Controller::getInstance()->render('base.twig.html');
		#Fin de rutas de configuracion
	}

?>