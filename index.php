<?php
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerUsuario.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerPaciente.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerConfiguracion.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerDatosDemograficos.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerSeguridad.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerSesion.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/controller/ControllerHistoriaClinica.php');

	$config = ControllerConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
	if(!$config->getHabilitado()){
		Controller::getInstance()->render('mantenimiento.twig');
	}
	else{
		
		if(isset($_SERVER['PATH_INFO'])){
			$path = $_SERVER['PATH_INFO'];
		}
		else{
			$path = '/';
		}

		#Se separa la ruta por '/'' y se guarda en un arreglo
		$url = explode('/',$path); 
		#En la posicion 1 del array esta el nombre del recurso. (En la 0 no hay nada.) 
		#En la posicion 0 esta lo que hay a la izquierda de '/', que es ''
		#Si el path es '/usuario/2/edicion' el arreglo queda  ['','usuario',2,'edicion']
		
		switch ($url[1]) {
			#Inicio rutas de usuario
			case 'usuario':
			if (isset($url[2]) && is_numeric($url[2])) {
				$idUsuario = $url[2];
				if(isset($url[3])){
					switch ($url[3]) {
						case 'editar':
							if($_SESSION['usuarioAModificar'] == $idUsuario){
								ControllerUsuario::getInstance()->editar($idUsuario);
							}
							else{
								$idUsuario = $_SESSION['usuarioAModificar'];
								header("Location: /index.php/usuario/$idUsuario/edicion");
							}
							break;
						case 'edicion':
							$_SESSION['usuarioAModificar'] = $idUsuario;
							ControllerUsuario::getInstance()->formulario($idUsuario);
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
					ControllerUsuario::getInstance()->mostrar($idUsuario);
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
							ControllerUsuario::getInstance()->formulario();
							break;
						case 'filtrado':
							$filtrado = ControllerUsuario::getInstance()->obtenerDatosFiltrado();
							if(isset($_GET['page'])){
								$page = $_GET['page'];
							}
							else{
								$page = 1;
							}
							ControllerUsuario::getInstance()->listar($filtrado,$page,'/filtrado');
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
					ControllerUsuario::getInstance()->listar(null,$page);
				}
				break;
			#Fin de rutas de usuario

			#Inicio rutas login
			case 'entrar':	
				ControllerSesion::getInstance()->login($_POST['email'],$_POST['password']);
				break;
			case 'login':
				ControllerSesion::getInstance()->formulario();
				break;
			case 'cerrarSesion':
				ControllerSesion::getInstance()->logout();
				break;
			#Fin de rutas del login

			#Inicio rutas de paciente
			case 'paciente':
				if (isset($url[2]) && is_numeric($url[2])) {
					$idPaciente = $url[2];
					if(isset($url[3])){
						switch ($url[3]) {
							case 'editar': //Editar paciente
								if($_SESSION['pacienteAModificar'] == $idPaciente){
									ControllerPaciente::getInstance()->modificar($idPaciente);
								}
								else{
									$idPaciente = $_SESSION['pacienteAModificar'];
									header("Location: /index.php/paciente/$idPaciente/edicion");
								}
								break;
							case 'edicion':
								$_SESSION['pacienteAModificar'] = $idPaciente;
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
							case 'historiaClinica':
								ControllerHistoriaClinica::getInstance()->listado($idPaciente);
								break;
							case 'graficos':
								ControllerHistoriaClinica::getInstance()->mostrarReportes($idPaciente);
								break;
							case 'control':
								if(isset($url[4]) && !is_numeric($url[4])){
									switch ($url[4]){
										case 'nuevo':
											ControllerHistoriaClinica::getInstance()->formulario($idPaciente);
											break;
										case 'agregar':
											ControllerHistoriaClinica::getInstance()->agregar();
											break;
										case 'editar':
											if( is_numeric($url[5]) ){
												$idControl = $url[5];
												ControllerHistoriaClinica::getInstance()->editar($idControl);
											}
											else{
												header("Location: /index.php/paciente/$idPaciente/historiaClinica");
											}
											break;
										case 'eliminar':
											if( is_numeric($url[5]) ){
												$idControl = $url[5];
												ControllerHistoriaClinica::getInstance()->eliminar($idPaciente,$idControl);
											}
											else{
												header("Location: /index.php/paciente/$idPaciente/historiaClinica");
											}
											break;
										case 'edicion':
											if( is_numeric($url[5]) ){
												$idControl = $url[5];
												ControllerHistoriaClinica::getInstance()->formulario($idPaciente,[],$idControl);
											}
											else{
												header("Location: /index.php/paciente/$idPaciente/historiaClinica");
											}
											
											break;
									}
								}
								else{
									if(is_numeric($url[4]))
										ControllerHistoriaClinica::getInstance()->mostrarControl($url[4]);
									else
										header("Location: /index.php/paciente/$idPaciente/historiaClinica");
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
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					else{
						$page = 1;
					}
					ControllerPaciente::getInstance()->listarTodos(null,$page);
				}
				break;

			#Fin de rutas de paciente

			#Inicio de rutas de configuracion
			case 'datosDemograficos':
				ControllerDatosDemograficos::getInstance()->reportesDatosDemograficos();
				break;

			case 'configuracion':
				ControllerConfiguracion::getInstance()->formulario();
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
					ControllerConfiguracion::getInstance()->editar($edit);
				break;
			default:
				//HOME
				Controller::getInstance()->render('base.twig.html');
			#Fin de rutas de configuracion
		}
	}
/*
<?php

class Person {
	function hola() {
		echo "hola";
	}
}

$person = "Person";

$p = new $person;
$m = "hola";

call_user_func(array($p, $m));

/usuarios/1/edit
*/

?>