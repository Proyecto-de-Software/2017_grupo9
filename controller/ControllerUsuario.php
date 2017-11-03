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
		if(isset($_POST['password2'])) $user->setPassword2($_POST['password2']);
	
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

	function listarUsuarios($usuarios,$filtrado=null,$filtradoPaginado=false){
		$paginado = datosDePaginado();
		if($filtradoPaginado){
			$paginado['cantPaginas'] = ceil(sizeof(RepositorioUsuario::getInstance()->devolverUsuarios(0,999,$filtrado))/$paginado['cantidadPorPagina']);
		}
		echo TwigView::getTwig()->render('administracionUsuarios.twig', array('usuarioActual'=>usuarioActual(),'lista'=>$usuarios,'filtrado'=>$filtrado,'configuracion'=>obtenerConfiguracion(), 'paginado' =>$paginado,'filtradoPaginado'=>$filtradoPaginado));
    }
    function agregarUsuario($validacion=[],$roles){
		echo TwigView::getTwig()->render('administracionAgregarUsuario.twig', array('usuarioActual'=>usuarioActual(),'validacion'=>$validacion,'roles'=>$roles,'configuracion'=>obtenerConfiguracion()));
		
    }
    function modificacionDeUsuario($usuario,$validacion=[],$roles){
		echo TwigView::getTwig()->render('administracionModificarUsuario.twig', array('usuarioActual'=>usuarioActual(),'usuario'=>$usuario, 'validacion'=>$validacion,'roles'=>$roles,'configuracion'=>obtenerConfiguracion()));
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

    function datosDePaginado(){

    	$cantidadUsuarios = (int)RepositorioUsuario::getInstance()->cantidadDeUsuarios();
    	$cantidadPorPagina = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
    	$cantidadDePaginas = ceil($cantidadUsuarios/$cantidadPorPagina);
    	$actual = 1;
    	if(isset($_GET['page'])){
    		$actual = $_GET['page'];
    	}
    	if($actual <= 1){
    		$limit = 0;
    	}
    	else{
    		$limit = $cantidadPorPagina * ($actual - 1);
    	}
    	
    	$retorno = array(
    		'cantidadPorPagina' => $cantidadPorPagina,
    		'cantPaginas' =>  $cantidadDePaginas,
    		'actual' => $actual,
    		'limit' => $limit
    			);

    	return $retorno;
    }


	if(isset($_GET['action'])){	
		switch($_GET['action']){
			case 'agregarUsuario':
				if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])) {
					$u = crearUsuario();
					$validacion = RepositorioUsuario::getInstance()->usuarioValido($u);
					if($validacion['ok']){
						RepositorioUsuario::getInstance()->agregarUsuario($u);
						header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
					}
					else{
						agregarUsuario($validacion,RepositorioRol::getInstance()->devolverRoles());
					}
				}
				else{//QUE ES ESTO
					echo "Post:     ".$_POST['token'];
					echo "\nSesion: ".$_SESSION['token'];
					//header("Location: /../");
				}
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
					$u = crearUsuario(true);
					$validacion = $validacion = RepositorioUsuario::getInstance()->usuarioValido($u,true);
					if($validacion['ok']){
						$resultado = RepositorioUsuario::getInstance()->modificarUsuario($u);
						if($resultado){
							$id = $resultado->getId();
							header("Location: /../controller/ControllerUsuario.php?action=mostrarUsuario&id=$id");
						}
					}
					else{
							modificacionDeUsuario($u,$validacion,RepositorioRol::getInstance()->devolverRoles());
						}
				} 
				else {
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
					$paginado = datosDePaginado();
					listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios($paginado['limit'],$paginado['cantidadPorPagina']));

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
				$paginado = datosDePaginado();
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

				listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios($paginado['limit'],$paginado['cantidadPorPagina'],$filtrado),$filtrado,true);
			
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