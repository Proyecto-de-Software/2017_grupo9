<?php

	#Nos ubicamos en el document_root para evitar problemas al usar twig, ya que twig usa paths relativos y si no estamos en la raiz no funciona.
	chdir($_SERVER['DOCUMENT_ROOT']);
	
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioRol.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioPermiso.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');


	if(!isset($_SESSION))
		session_start();


	function crearUsuario($modif){
		//si $modif == true, quiere decir que el usuario ya existe en la bd, si es false, es la primera vez
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
		$user =  new Usuario($_POST['usuario'], $_POST['email'], $_POST['password'], true, $creadoEn, $actualizadoEn, $_POST['nombre'], $_POST['apellido'], $rolesCompletos);
		if($modif) $user->setId($_POST['id']);
		return $user;
		
	}
	function listarUsuarios($usuarios){
		if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('usuario_index')){
	        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarUsuarios.php");
	        $view = new ListarUsuarios();
	        $view->show($usuarios);
    	} else {
	        header("Location: /../");
    	}
    }
    function agregarUsuario($mensaje,$roles){
    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('usuario_new')){
		    require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarUsuario.php");
		    $view = new AgregarUsuario();
		    $view->show($mensaje,$roles);
		} else {
			header("Location: /../");
		}
    }
    function modificacionDeUsuario($usuario,$mensaje,$roles){
    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('usuario_update')){
	    	require_once($_SERVER['DOCUMENT_ROOT']."/view/FormularioModificarUsuario.php");
	    	$view = new ModificarUsuario();
	    	$view ->show($usuario,$mensaje,$roles);
	    } else {
	    	header("Location: /../");
	    }
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
    	if(!isset($_SESSION)) {
			session_start();
		} else {
			session_destroy();
			session_start();
		}
    	$_SESSION['usuario'] = serialize($usuario);
    	$_SESSION['logueado'] = true;
        $_SESSION['administrador']=0;
        $_SESSION['recepcionista']=0;
        $_SESSION['pediatra']=0;
       	$user = unserialize($_SESSION['usuario']);
            foreach($user->getRoles() as $rol){
                switch ($rol['nombre']) {
                    case 'administrador':
                        $_SESSION['administrador']=1;
                        break;
                    case 'recepcionista':
                        $_SESSION['recepcionista']=1;
                        break;
                    case 'pediatra':
                        $_SESSION['pediatra']=1;
                        break;
                }
            }      
        

    	require_once($_SERVER['DOCUMENT_ROOT']."/view/Home.php");
	    $view = new Home();
	    $view->show();

    }
    function mostrarUsuario($usuario){
    	if(RepositorioPermiso::getInstance()->UsuarioTienePermiso('usuario_show')){
		    require_once($_SERVER['DOCUMENT_ROOT']."/view/MostrarUsuario.php");
		    $view = new MostrarUsuario();
		    $view->show($usuario);
		} else {
			header("Location: /../");
		}
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
			case "agregarUsuario":
				if(validarCampos()){
					RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario(false));
					header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
				} 
				else{
					header("Location: /../controller/ControllerUsuario.php?action=agregarUsuarioNoValidado");
				}	
				break;
			case 'agregarUsuarioNoValidado':
				agregarUsuario("Debe llenar todos los campos. Tenga en cuenta: *Debe elegir al menos un rol. *Las contraseñas deben coincidir. *	El email debe tener un formato valido.",RepositorioRol::getInstance()->devolverRoles());
				break;
			case "agregarUsuarioView":
				agregarUsuario("", RepositorioRol::getInstance()->devolverRoles());
				break;
			case 'modificarUsuario':
				if(validarCampos()){
					$resultado = RepositorioUsuario::getInstance()->modificarUsuario(crearUsuario(true));
					
					if($resultado){
						$id = $resultado->getId();
						header("Location: /../controller/ControllerUsuario.php?action=mostrarUsuario&id=$id");
					}
					else{
						modificacionDeUsuario(crearUsuario(true),"No se pudieron modificar los datos",RepositorioRol::getInstance()->devolverRoles());
					}
				}
				else{
					modificacionDeUsuario(crearUsuario(true),"Debe llenar todos los campos. Tenga en cuenta: *Debe elegir al menos un rol. *Las contraseñas deben coincidir. *	El email debe tener un formato valido.",RepositorioRol::getInstance()->devolverRoles());
				}
				break;
			case 'modificacionDeUsuario':
				$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_GET['id']);
		    	modificacionDeUsuario($usuario,"",RepositorioRol::getInstance()->devolverRoles());
				break;
			case 'eliminarUsuario':
				RepositorioUsuario::getInstance()->eliminarUsuario($_GET['id']);
				header("Location: /../controller/ControllerUsuario.php?action=listarUsuarios");
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
				mostrarUsuario(RepositorioUsuario::getInstance()->buscarUsuarioPorId($_GET['id']));
				break;
			case 'listarUsuarios':
				listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios());
				break;
			case 'loginUsuarioView':
				loginUsuario("");
				break;
			case 'cerrarSesion':
				session_destroy();
				header("Location: /../");
					session_start();
					$_SESSION = array();
					session_destroy();

					header("Location: /../");
				break;
		}
	}


?>