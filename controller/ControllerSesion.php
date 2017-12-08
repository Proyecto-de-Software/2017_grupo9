<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioUsuario.php');

	class ControllerSesion extends Controller{
		public static function getInstance() {
	      	if (!isset(self::$instance)) {
	          self::$instance = new ControllerSesion();
	      	}
	      	return self::$instance;
	    }


		public function formulario($mensaje = ''){
	    	$template = 'loginUsuario.twig';
	    	$parametrosTemplate['mensaje'] = $mensaje;
	    	$this->render($template,$parametrosTemplate);
   		}

	    public function login($email,$password){
	    	if(RepositorioUsuario::getInstance()->existeUsuario($email,$password)){
	    		if(RepositorioUsuario::getInstance()->usuarioActivo($email)){
	    			$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorEmail($email);
	    			if(!isset($_SESSION)) {
						ControllerSeguridad::getInstance()->sec_session_start();
					} 
					else {
						session_destroy();
						ControllerSeguridad::getInstance()->sec_session_start();
					}
					$_SESSION['token'] = md5(uniqid(mt_rand(), true));
			    	$_SESSION['idUsuario'] = $usuario->getId();
			    	$this->redireccion("/index.php");
	    		}
	    		else{
					$this->formulario("El usuario con el que quiere ingresar esta bloqueado");
				}
	    	}
	    	else{
	    		$this->formulario("Es posible que no exista el usuario o este ingresando mal la contraseña");
	    	}

	    }

	    public function logout(){
	    	ControllerSeguridad::getInstance()->sec_session_start();
			$_SESSION = array();
			session_destroy();
			$this->redireccion("/index.php");
	    }


	}
?>