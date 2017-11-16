<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerUsuario.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerPaciente.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerConfiguracion.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerDatosDemograficos.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerSeguridad.php');
	$config = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
	if(!$config->getHabilitado()){
		Controller::getInstance()->render('mantenimiento.twig');
	}
	else{
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
							$filtrado = ControllerUsuario::getInstance()->obtenerDatosFiltrado();
							if(isset($_GET['page'])){
								$page = $_GET['page'];
							}
							else{
								$page = 1;
							}
							ControllerUsuario::getInstance()->listarusuarios($filtrado,$page,'/filtrado');
							break;
						default:
							header("Location: /index.php/usuarios");
							break;
					}
				}
				else{
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					else{
						$page = 1;
					}
					ControllerUsuario::getInstance()->listarUsuarios(null,$page);
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
							$busqueda = ControllerPaciente::getInstance()->obtenerDatosBusquedaDocumento();
							if(isset($_GET['page'])){
								$page = $_GET['page'];
							}
							else{
								$page = 1;
							}
							ControllerPaciente::getInstance()->listarTodos($busqueda,$page,'/busquedaDocumento');
							break;
						case 'busquedaNombre':
							$busqueda = ControllerPaciente::getInstance()->obtenerDatosBusquedaNombre();
							if(isset($_GET['page'])){
								$page = $_GET['page'];
							}
							else{
								$page = 1;
							}
							ControllerPaciente::getInstance()->listarTodos($busqueda,$page,'/busquedaNombre');
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
	}

?>