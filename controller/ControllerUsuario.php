<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/model/RepositorioUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/model/ClaseUsuario.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');

	function crearUsuario(){
		if(isset($_POST['rol'])){
			for($i=0; $i < count($_POST['rol']); $i++) {
				$roles[$i] = $_POST['rol'][$i];
			}
	
			return new Usuario($_POST['user'], $_POST['email'], $_POST['password'], true, date("Y-m-d"), date("Y-m-d"), $_POST['name'], $_POST['apellido'], $roles);
		}
	}
	function listarUsuarios($usuarios){
        require_once($_SERVER['DOCUMENT_ROOT']."/view/ListarUsuarios.php");
        $view = new ListarUsuarios();
        $view->show($usuarios);
    }
    function agregarUsuario(){
	    require_once($_SERVER['DOCUMENT_ROOT']."/view/AgregarUsuario.php");
	    $view = new AgregarUsuario();
	    $view->show();
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

	if(isset($_GET['action'])){
		switch($_GET['action']){
			case "agregarUsuario":
				if(isset($_POST['password']) && isset($_POST['password2']) && $_POST['password'] == $_POST['password2']){
					RepositorioUsuario::getInstance()->agregarUsuario(crearUsuario());
					listarUsuarios(RepositorioUsuario::getInstance()->devolverUsuarios());
				} else {
					echo("Las contraseñas no coinciden");
					agregarUsuario();
				}				
				break;
			case "agregarUsuarioView":
				agregarUsuario();
				break;
			case 'modificarUsuario':
				RepositorioUsuario::getInstance()->actualizarUsuario(crearUsuario());
				break;
			case 'eliminarUsuario':
				RepositorioUsuario::getInstance()->eliminarUsuario($_POST['idUsuario']);
				break;
			case 'loginUsuario': 
				try {
					if(RepositorioUsuario::getInstance()->loguearUsuario($_POST['email'],$_POST['password'])){
						usuarioLogueado();
					}
					else{
						throw new Exception();
						
					}

				} catch (Exception $e) {
					loginUsuario("Es posible que no exista el usuario o este ingresando mal la contraseña");
				}
				 
				break;
			case 'mostrarUsuario':
				RepositorioUsuario::getInstance()->eliminarUsuario($_POST['idUsuario']);
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