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
    	if($this->hayPermiso('usuario_new') && $this->tokenValido($_POST['token'])){
    		$usuario = $this->crearUsuarioNuevo();
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario);
			
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->agregarUsuario($usuario);
				$this->redireccion("/index.php/usuarios");
			}
			else{
				$this->formularioUsuario(null,$validacion,$usuario);
			}

    	}
    	else{
    		$this->redireccion("/index.php");
    	}
    }

    public function formulario($idUsuario = null,$validacion = null,$usuarioInvalido=null){
    	if($this->hayPermiso('usuario_new') || $this->hayPermiso('usuario_update')){
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
     	if($this->hayPermiso('usuario_update') && $this->tokenValido($_POST['token'])){
    		$usuario = $this->crearUsuarioExistente($idUsuario);
			$validacion = RepositorioUsuario::getInstance()->usuarioValido($usuario,true);
			if($validacion['ok']){
				RepositorioUsuario::getInstance()->modificarUsuario($usuario,$idUsuario); 
				header("Location: /index.php/usuario/$idUsuario");
			}
			else{
				$this->formularioUsuario($idUsuario,$validacion,$usuario);
			}

    	}
    	else{
    		$this->redireccion("/index.php");
    		
    	}
    }

    public function eliminar($idUsuario){
    	if($this->hayPermiso('usuario_destroy')){
    		RepositorioUsuario::getInstance()->eliminarUsuario($idUsuario);
    		$this->redireccion("/index.php/usuarios");
    	}
    	else{
    		$this->redireccion("/index.php");
    	}
    }

    public function listar($filtrado = null,$pagina = 1,$accion = ''){
    	if($this->hayPermiso('usuario_index')){
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
			$this->redireccion("/index.php");
		}    
    }

    public function mostrar($idUsuario){
    	if($this->hayPermiso('usuario_show')){
			$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($idUsuario);
			$template = 'administracionMostrarUsuario.twig';
			$parametrosTemplate['usuario'] = $usuario;
			$this->render($template,$parametrosTemplate);
		}
		else{
			$this->redireccion("/index.php");
		}
    }

    public function activar($idUsuario){
    	if($this->hayPermiso('usuario_update')){
			RepositorioUsuario::getInstance()->activarUsuario($idUsuario);
			$this->redireccion("/index.php/usuarios");
		}
		else{
			$this->redireccion("/index.php");
		}
    }

    public function bloquear($idUsuario){
    	if($this->hayPermiso('usuario_update')){
			RepositorioUsuario::getInstance()->bloquearUsuario($idUsuario);
			$this->redireccion("/index.php/usuarios");
		}
		else{
			$this->redireccion("/index.php");
		}

	}
    
    /* // CREO QUE YA NO SE USA SI HAY ALGUN ERROR DESCOMENTAR
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
*/


}

?>