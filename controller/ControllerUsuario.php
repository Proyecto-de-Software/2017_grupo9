<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');


class ControllerUsuario extends Controller{
	protected static $instance;
	public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerUsuario();
      	}
      	return self::$instance;
      }
	public function crearUsuarioNuevo(){
		//CREA EL USUARIO CON LOS DATOS RECIBIDOS POR POST
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
		$user->setPassword2($_POST['password2']);
		return $user;
	}
	public function crearUsuarioExistente($idUsuario){
		$usuario = $this->crearUsuarioNuevo();
		$usuario->setId($idUsuario);
		$usuario->setPassword2($_POST['password2']);
		return $usuario;
	}

    public function agregar(){
    	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_new')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
    		$usuario = $this->crearUsuarioNuevo();
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario);
			
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->agregarUsuario($usuario);
				header("Location: /index.php/usuarios");
			}
			else{
				$this->formularioUsuario(null,$validacion,$usuario);
			}

    	}
    	else{
    		header("Location: /index.php");
    	}
    }

    public function formularioUsuario($idUsuario = null,$validacion = null,$usuarioInvalido=null){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'usuario_new') || RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'],'usuario_update')){
			$template = 'administracionFormularioUsuario.twig';
			$parametrosTemplate['validacion'] = $validacion;
			$parametrosTemplate['idUsuario'] = $idUsuario;
			if($idUsuario != null){
				$parametrosTemplate['usuario'] = RepositorioUsuario::getInstance()->buscarUsuarioPorId($idUsuario);
			}
			if($usuarioInvalido != null){
				$parametrosTemplate['usuarioInvalido'] = $usuarioInvalido;
			}
			$parametrosTemplate['roles'] = RepositorioRol::getInstance()->devolverRoles();
			$this->render($template,$parametrosTemplate);
		}
		else{
			header("Location: ./");
		}
    }

     public function editar($idUsuario){
     	if((RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token'])){
    		$usuario = $this->crearUsuarioExistente($idUsuario);
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario,true);
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->modificarUsuario($usuario,$idUsuario); 
				//cambiar function modelo que reciba user y id
				header("Location: /index.php/usuario/$idUsuario");
			}
			else{
				$this->formularioUsuario($idUsuario,$validacion,$usuario);
			}

    	}
    	else{
    		header("Location: /index.php");
    	}
    }

    public function eliminar($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_destroy')){
    		RepositorioUsuario::getInstance()->eliminarUsuario($idUsuario);
    		header("Location: /index.php/usuarios");
    	}
    	else{
    		header("Location: ./index.php");
    	}
    }

    public function listarusuarios($filtrado = null,$pagina = 1,$accion = ''){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_index')){
    		#hacer anterior ysiguiente sin paginas. 
    		#cambiar metodo paginar
    		#NO HACER DOS CONSULTAS
    		$listado = RepositorioUsuario::getInstance()->devolverUsuarios($filtrado); # aca mandar pagina.
    		$paginado = $this->paginar($listado,$pagina);
    		$listadoFinal = RepositorioUsuario::getInstance()->devolverUsuarios($filtrado,$paginado['offset'],$paginado['cantidadPorPagina']);

    		$template = 'administracionUsuarios.twig';
			$parametrosTemplate['lista'] = $listadoFinal;
			$parametrosTemplate['filtrado'] = $filtrado;
			$parametrosTemplate['action'] = $accion;
			$parametrosTemplate['tipo'] = 'usuarios';
			$parametrosTemplate['paginado'] = $paginado;
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

    public function activar($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
			RepositorioUsuario::getInstance()->activarUsuario($idUsuario);
			header("Location: /index.php/usuarios");
		}
		else{
			header("Location: /");
		}
    }

    public function bloquear($idUsuario){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'usuario_update')){
			RepositorioUsuario::getInstance()->bloquearUsuario($idUsuario);
			header("Location: /index.php/usuarios");
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
					ControllerSeguridad::getInstance()->sec_session_start();
				} 
				else {
					session_destroy();
					ControllerSeguridad::getInstance()->sec_session_start();
				}
				$_SESSION['token'] = md5(uniqid(mt_rand(), true));
		    	$_SESSION['idUsuario'] = $usuario->getId();
		    	header("Location: /../");
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
    	ControllerSeguridad::getInstance()->sec_session_start();
		$_SESSION = array();
		session_destroy();
		header("Location: /../");
    }
    public function obtenerDatosFiltrado(){
    	$filtrado['activo'] = isset($_POST['activo']);
		$filtrado['bloqueado'] = isset($_POST['bloqueado']);
		$filtrado['campoBuscar'] = "";
		if(isset($_POST['buscar']) && trim($_POST['buscar']) !=''){
			$filtrado['campoBuscar'] = $_POST['buscar'];	;
		}
		if(isset($_POST['filtrado'])){
			$_SESSION['filtrado']['activo'] = $filtrado['activo'];
			$_SESSION['filtrado']['bloqueado'] = $filtrado['bloqueado'];
			$_SESSION['filtrado']['campoBuscar'] = $filtrado['campoBuscar'];
		}
		else{
			$filtrado['activo'] = $_SESSION['filtrado']['activo'];
			$filtrado['bloqueado'] = $_SESSION['filtrado']['bloqueado'];
			$filtrado['campoBuscar'] = $_SESSION['filtrado']['campoBuscar'];
		}
		return $filtrado;
    }



}

?>