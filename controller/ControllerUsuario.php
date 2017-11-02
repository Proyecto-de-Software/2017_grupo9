<?php

	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);
	
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseConfiguracion.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');
	require_once($_SERVER['DOCUMENT_ROOT']."/controller/ControllerSeguridad.php");

	if(!isset($_SESSION)) {
		sec_session_start();
	} else {
		session_regenerate_id();
	}

	function obtenerConfiguracion(){
    	return RepositorioConfiguracion::getInstance()->datosParaLaVista();
    }
    $config = obtenerConfiguracion();

	if(!$config['habilitado']){
	    header("Location: /../");
	}


	function crearUsuario($modif=false){
		//si $modif == true, quiere decir que el usuario ya existe en la bd, si es false, es la primera vez
		if(isset($_POST['rol'])){
			$roles = [];
			for($i=0; $i < count($_POST['rol']); $i++) {
				array_push($roles,$_POST['rol'][$i]);	
			}
			
			$rolesCompletos = RepositorioRol::getInstance()->buscarRolesPorNombre($roles);
		}
		else{
			$rolesCompletos = null;
		}
		if($modif){
			$creadoEn = $_POST['fechaCreacion'];
			$actualizadoEn = $_POST['fechaActualizacion'];
		}
		else{
			$now = date("Y-m-d");
			$creadoEn = $now;
			$actualizadoEn = $now;
		}
		$user =  new Usuario($_POST['usuario'], $_POST['email'], $_POST['password'], true, $creadoEn, $actualizadoEn, $_POST['nombre'], $_POST['apellido'], $rolesCompletos);
		if($modif) $user->setId($_POST['id']);
		var_dump($user);
		return $user;
		
	}
	function usuarioActual(){
    	if(isset($_SESSION['idUsuario'])){
    		$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_SESSION['idUsuario']);
    		return array(	'logueado'=>true, 
    						'username'=>$usuario->getNombreUsuario(),
    						'roles'=>RepositorioRol::getInstance()->buscarRolesDeUsuario($_SESSION['idUsuario']),
    						'idUsuario'=>$_SESSION['idUsuario'],
    						'token'=>$_SESSION['token']
    					);
    	}
    	else return false;
    }

	function listarUsuarios($usuarios,$filtrado=null){
		echo TwigView::getTwig()->render('administracionUsuarios.twig', array('usuarioActual'=>usuarioActual(),'lista'=>$usuarios,'filtrado'=>$filtrado,'configuracion'=>obtenerConfiguracion()));
    }
    function agregarUsuario($mensaje='',$roles){
		echo TwigView::getTwig()->render('administracionAgregarUsuario.twig', array('usuarioActual'=>usuarioActual(),'mensaje'=>$mensaje,'roles'=>$roles,'configuracion'=>obtenerConfiguracion()));
		
    }
    function modificacionDeUsuario($usuario,$mensaje='',$roles){
		echo TwigView::getTwig()->render('administracionModificarUsuario.twig', array('usuarioActual'=>usuarioActual(),'usuario'=>$usuario, 'mensaje'=>$mensaje,'roles'=>$roles,'configuracion'=>obtenerConfiguracion()));
    }
    function loginUsuario($msj=''){
		echo TwigView::getTwig()->render('loginUsuario.twig', array('usuarioActual'=>usuarioActual(),'mensaje'=>$msj, 'configuracion'=>obtenerConfiguracion()));
    }
    /*
    function usuarioLogueado(){
	    echo TwigView::getTwig()->render('home.twig', array('configuracion'=>obtenerConfiguracion()));
    }
    */
    function loguearUsuario($usuario){
    	if(!isset($_SESSION)) {
			sec_session_start();
		} else {
			session_destroy();
			sec_session_start();
		}
		$_SESSION['token'] = md5(uniqid(mt_rand(), true));
    	$_SESSION['idUsuario'] = $usuario->getId();
        echo TwigView::getTwig()->render('base.twig.html', array('usuarioActual'=>usuarioActual(),'configuracion'=>obtenerConfiguracion()));

    }
    function mostrarUsuario($usuario){
		 echo TwigView::getTwig()->render('administracionMostrarUsuario.twig', array('usuarioActual'=>usuarioActual(),'usuario'=>$usuario, 'configuracion'=>obtenerConfiguracion()));
    }
    function validarCampos(){
    	$nombre = isset($_POST['nombre']) && trim($_POST['nombre']) !='';
    	$apellido = isset($_POST['apellido']) && trim($_POST['apellido']) !='';
    	$usuario = isset($_POST['usuario']) && trim($_POST['usuario']) !='';
    	$email = isset($_POST['email']) && filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
    	$passwords = isset($_POST['password']) && isset($_POST['password2']) && ($_POST['password'] == $_POST['password2']);
    	$roles = isset($_POST['rol']);
    	return ($nombre && $apellido && $usuario && $email && $passwords && $roles);
    	
    }

	if(isset($_GET['action'])){	
		switch($_GET['action']){
			case 'agregarUsuario':
				if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {

					if(validarCampos()){
						if(!RepositorioUsuario::getInstance()->existeNombreUsuario($_POST['usuario'])){
							if(!RepositorioUsuario::getInstance()->existeEmail($_POST['email'])){
								RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario(false));
								header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
							}
							else{
								header("Location: /../controller/ControllerUsuario.php?action=agregarUsuarioEmailNoValido");
							}
						}
						else{
							header("Location: /../controller/ControllerUsuario.php?action=agregarUsuarioNickNoValidado");	
						}
					} 
					else{
						header("Location: /../controller/ControllerUsuario.php?action=agregarUsuarioNoValidado");
							
					}
				}
				else{
					echo "Post:     ".$_POST['token'];
					echo "\nSesion: ".$_SESSION['token'];
					//header("Location: /../");
				}
				break;
			case 'agregarUsuarioNoValidado':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')){
					agregarUsuario("Debe llenar todos los campos. Tenga en cuenta: *Debe elegir al menos un rol. *Las contraseñas deben coincidir. *	El email debe tener un formato valido.",RepositorioRol::getInstance()->devolverRoles());
				}
				else header("Location: /../");
				break;
			case 'agregarUsuarioEmailNoValido':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')){
					agregarUsuario("El email que ha ingresado ya esta registrado, elija otro.",RepositorioRol::getInstance()->devolverRoles());
				}
				else header("Location: /../");
				break;
			case 'agregarUsuarioNickNoValidado':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')){
				 	agregarUsuario("El nombre de usuario que ha ingresado ya esta registrado, elija otro.",RepositorioRol::getInstance()->devolverRoles());
			 	}
			 	else header("Location: /../");
			 	break;			 
			case "agregarUsuarioView":
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'usuario_new')){
					agregarUsuario("", RepositorioRol::getInstance()->devolverRoles());
				} else {
					header("Location: /../");
				}
				break;
			case 'modificarUsuario':
				if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {

					if(validarCampos()){
						$resultado = RepositorioUsuario::getInstance()->modificarUsuario(crearUsuario(true));
						if($resultado){
							$id = $resultado->getId();
							header("Location: /../controller/ControllerUsuario.php?action=mostrarUsuario&id=$id");
						} else{
							modificacionDeUsuario(crearUsuario(true),"No se pudieron modificar los datos",RepositorioRol::getInstance()->devolverRoles());
						}
					} else{
						modificacionDeUsuario(crearUsuario(true),"Debe llenar todos los campos. Tenga en cuenta: *Debe elegir al menos un rol. *Las contraseñas deben coincidir. *	El email debe tener un formato valido.",RepositorioRol::getInstance()->devolverRoles());
					}
				} else {
					header("Location: /../");
				}
				break;
			case 'modificacionDeUsuario':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
					$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_GET['id']);
			    	modificacionDeUsuario($usuario,"",RepositorioRol::getInstance()->devolverRoles());
			    } else {
					header("Location: /../");
				}
				break;
			case 'eliminarUsuario':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_destroy')){
					RepositorioUsuario::getInstance()->eliminarUsuario($_GET['id']);
					header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
				} else {
					header("Location: /../");
				}
				break;
			case 'loginUsuario': 
				if(isset($_POST['email']) && isset($_POST['password'])){
					if(RepositorioUsuario::getInstance()->existeUsuario($_POST['email'],$_POST['password'])){
						if(RepositorioUsuario::getInstance()->usuarioActivo($_POST['email'])){
							loguearUsuario(RepositorioUsuario::getInstance()->buscarUsuarioPorEmail($_POST['email']));
						}
						else{
							loginUsuario("El usuario con el que quiere ingresar esta bloqueado");
						}
					}
					else{
						loginUsuario("Es posible que no exista el usuario o este ingresando mal la contraseña");
					}
				}
				else{
					header("Location: /../controller/ControllerUsuario.php?action=loginUsuarioView");
				}
				break;
			case 'mostrarUsuario':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_show')){
					mostrarUsuario(RepositorioUsuario::getInstance()->buscarUsuarioPorId($_GET['id']));
				} else {
					header("Location: /../");
				}
				break;
			case 'listarUsuarios':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_index')){
					if(isset($_GET['page'])){
						$page = $_GET['page'];
					}
					else{
						$page = 0;
					}
					$cantidadPorPagina = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
					listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios($page,$cantidadPorPagina));

				} else {
	        		header("Location: /../");
    			}
				break;
			case 'loginUsuarioView':
				loginUsuario();
				break;
			case 'activarUsuario':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
					RepositorioUsuario::getInstance()->activarUsuario($_GET['id']);
					header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
				} else {
	        		header("Location: /../");
    			}
				break;
			case 'desactivarUsuario':
				if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
					RepositorioUsuario::getInstance()->bloquearUsuario($_GET['id']);
					header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
				} else {
	        		header("Location: /../");
    			}
				break;
			case 'filtradoUsuario':
				if(isset($_GET['page'])){
					$page = $_GET['page'];
				}
				else{
					$page = 0;
				}
				$cantidadPorPagina = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
				$listado = [];
				$activoChecked = isset($_POST['activo']);
				$bloqueadoChecked = isset($_POST['bloqueado']);
				$filtrado['activo'] = $activoChecked;
				$filtrado['bloqueado'] = $bloqueadoChecked;
				$filtrado['campoBuscar'] = "";
				if(isset($_POST['buscar']) && trim($_POST['buscar']) !=''){
					$nombreUsuario = $_POST['buscar'];			
					$filtrado['campoBuscar'] =$nombreUsuario;
				}
				listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios($page,$cantidadPorPagina,$filtrado),$filtrado);
			
				break;
			case 'cerrarSesion':
				//if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']) {
				sec_session_start();
				$_SESSION = array();
				session_destroy();
				header("Location: /../");
				//} else {
				//	header("Location: /../");
				//}
				break;
		}
	}


?>