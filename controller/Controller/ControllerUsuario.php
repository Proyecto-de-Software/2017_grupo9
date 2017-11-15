<?php

class ControllerUsuario extends Controller{

	public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerUsuario();
      	}
      	return self::$instance;
      }
	public function crearUsuario(){
		//TODO MAL REFACTORIZAR FUNCIION 
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

		$user =  new Usuario($_POST['usuario'], $_POST['email'], $_POST['password'], true,$_POST['nombre'], $_POST['apellido'], $rolesCompletos);
		if(isset($_POST['password2'])) $user->setPassword2($_POST['password2']);
		return $user;


    public function agregarUsuario(){
    	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
    		$usuario = $this->crearUsuario();
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario);
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->agregarUsuario($usuario);
				header("Location: /usuarios");
			}
			else{
				$this->formularioUsuario($usuario,$validacion);
			}

    	}
    	else{
    		header("Location: ./index.php");
    	}
    }

    public function formularioUsuario($usuario = null, $validacion = null){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'usuario_new') || RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'usuario_update')){}

			$template = 'administracionAgregarUsuario.twig'; // modificar template pra hacerlo generico
			$parametrosTemplate['validacion'] = $validacion;
			$parametrosTemplate['usuario'] = $usuario;
			$parametrosTemplate['roles'] = RepositorioRol::getInstance()->devolverRoles();
			$this->render($template,$parametrosTemplate);
		}
		else{
			header("Location: ./");
		}
    }

     public function modifcarUsuario($idUsuario){
     	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
    		$usuario = $this->crearUsuario();
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario);
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->modificarUsuario($usuario,$idUsuario); //cambiar function modelo
				header("Location: /usuario/$idUsuario");
			}
			else{
				$this->formularioUsuario($usuario,$validacion);
			}

    	}
    	else{
    		header("Location: ./index.php");
    	}
    }

    public function eliminarUsuario($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_destroy')){
    		RepositorioUsuario::getInstance()->eliminarUsuario($idUsuario);
    		header("Location: /usuarios");
    	}
    	else{
    		header("Location: ./index.php");
    	}
    }

    public function listarusuarios($filtrado = null, $filtradoPaginado = false){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_index')){
    		$paginado = $this->datosDepaginado();
    		$listado = RepositorioUsuario::getInstance()->devolverUsuarios($paginado['limit'],$paginado['cantidadPorPagina'],$filtrado);
    		$paginadoFinal = $this->paginar($listado);
    		$template = 'administracionUsuarios.twig';
			$parametrosTemplate['lista'] = $listado;
			$parametrosTemplate['filtrado'] = $filtrado;
			$parametrosTemplate['filtradoPaginado'] = $filtradoPaginado;
    		$this->render($template,$parametrosTemplate);
		}
		else{
			header("Location: ./");
		}    
    }

    public function mostrarUsuario($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_show')){
			$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($idUsuario);
			$template = 'administracionMostrarUsuario.twig';
			$parametrosTemplate['usuario'] = $usuario;
			$this->render($template,$parametrosTemplate);
		}
		else{
			header("Location: /../");
		}
    }

    public function activarUsuario($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
			RepositorioUsuario::getInstance()->activarUsuario($idUsuario);
			header("Location: ./usuarios");
		}
		else{
			header("Location: ./");
		}
    }

    public function desactivarUsuario($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
			RepositorioUsuario::getInstance()->bloquearUsuario($idUsuario);
			header("Location: ./usuarios");
		}
		else{
			header("Location: ./");
		}

	}
    public function formularioLogin($mensaje = ''){
    	$template = 'loginUsuario.twig';
    	$parametrosTemplate['mensaje'] = $mensaje;
    	$this->render($template,$parametrosTemplate);
    }

    public function loginUsuario($email,$password){
    	if(RepositorioUsuario::getInstance()->existeUsuario($email,$password)){
    		if(RepositorioUsuario::getInstance()->usuarioActivo($email)){
    			$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorEmail($email);
    			if(!isset($_SESSION)) {
					sec_session_start();
				} 
				else {
					session_destroy();
					sec_session_start();
				}
				$_SESSION['token'] = md5(uniqid(mt_rand(), true));
		    	$_SESSION['idUsuario'] = $usuario->getId();
		    	$this->render('base.twig.html');
    		}
    		else{
				$this->formularioLogin("El usuario con el que quiere ingresar esta bloqueado");
			}
    	}
    	else{
    		$this->formularioLogin("Es posible que no exista el usuario o este ingresando mal la contraseña");
    	}

    }

    public function cerrarSesion(){
    	sec_session_start();
		$_SESSION = array();
		session_destroy();
		header("Location: /../");
    }



}

?>