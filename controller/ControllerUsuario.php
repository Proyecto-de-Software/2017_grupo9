<?php

	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);
	
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');


	function crearUsuario($modif){
		if(isset($_POST['rol'])){
			$roles = [];
			for($i=0; $i < count($_POST['rol']); $i++) {
				array_push($roles,$_POST['rol'][$i]);	
			}
			
			$rolesCompletos = RepositorioRol::getInstance()->buscarRolesPorNombre($roles);
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
		$user =  new Usuario($_POST['user'], $_POST['email'], $_POST['password'], true, $creadoEn, $actualizadoEn, $_POST['name'], $_POST['apellido'], $rolesCompletos);
		if($modif) $user->setId($_POST['id']);
		return $user;
		
	}
	function listarUsuarios($usuarios){
		// Asi quedarían las funciones con el control de permisos:
		//if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('usuario_index'){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarUsuarios.php");
	        $view = new ListarUsuarios();
	        $view->show($usuarios);
    	//} else {
	        //redirigir al index
    	//}
    }
    function agregarUsuario($mensaje,$roles){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarUsuario.php");
	    $view = new AgregarUsuario();
	    $view->show($mensaje,$roles);
    }
    function modificacionDeUsuario($usuario,$mensaje,$roles){
    	require_once($_SERVER['DOCUMENT_ROOT']."/view/FormularioModificarUsuario.php");
    	$view = new ModificarUsuario();
    	$view ->show($usuario,$mensaje,$roles);
    }
    function loginUsuario($msj){
    	require_once($_SERVER['DOCUMENT_ROOT']."/view/Login.php");
	    $view = new Login();
	    $view->show($msj);
    }
    function usuarioLogueado(){
    	 require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
	    $view = new Home();
	    $view->show();
    }
    function loguearUsuario($usuario){
    	session_start();
    	$_SESSION['usuario'] = $usuario;
    	$_SESSION['roles'] = $usuario->getIdRoles();
    	require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
	    $view = new Home();
	    $view->show();

    }
    function mostrarUsuario($usuario){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarUsuario.php");
	    $view = new MostrarUsuario();
	    $view->show($usuario);
    }

	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "agregarUsuario":
				if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
					RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario(false));
					listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios());
				} else {
					agregarUsuario("Las contraseñas no coinciden",RepositorioRol::getInstance()->devolverRoles());
				}				
				break;
			case "agregarUsuarioView":
				agregarUsuario("", RepositorioRol::getInstance()->devolverRoles());
				break;
			case 'modificarUsuario':
				if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
					$resultado = RepositorioUsuario::getInstance()->modificarUsuario(crearUsuario(true));
					
					if($resultado){
						mostrarUsuario($resultado);
					}
					else{
						modificacionDeUsuario(crearUsuario(true),"No se pudieron modificar los datos",RepositorioRol::getInstance()->devolverRoles());
					}
				}
				else{
					modificacionDeUsuario(crearUsuario(true),"Deben coincidir las contraseñas",RepositorioRol::getInstance()->devolverRoles());
				}
				break;
			case 'modificacionDeUsuario':
				$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_POST['id']);
		    	modificacionDeUsuario($usuario,"",RepositorioRol::getInstance()->devolverRoles());
				break;
			case 'eliminarUsuario':
				RepositorioUsuario::getInstance()->eliminarUsuario($_POST['id']);
				listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios());
				break;
			case 'loginUsuario': 
					if(RepositorioUsuario::getInstance()->existeUsuario($_POST['email'],$_POST['password'])){
						loguearUsuario(RepositorioUsuario::getInstance()->buscarUsuarioPorEmail($_POST['email']));
					}
					else{
						loginUsuario("Es posible que no exista el usuario o este ingresando mal la contraseña");
					}
				break;
			case 'mostrarUsuario':
				mostrarUsuario(RepositorioUsuario::getInstance()->buscarUsuarioPorId($_POST['id']));
				break;
			case 'listarUsuarios':
				listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios());
				break;
			case 'loginUsuarioView':
				loginUsuario("");
				break;
		}
	}


?>