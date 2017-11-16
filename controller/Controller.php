<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioPaciente.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioDatosDemograficos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioConfiguracion.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioRol.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioPermiso.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseUsuario.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClasePaciente.php'); 
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseConfiguracion.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseDatosDemograficos.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/view/TwigView.php');   

//requerir todos los modelos aca
class Controller{
	protected static $instance;
   	public static function getInstance() {
  		if (!isset(self::$instance)) {
      		self::$instance = new Controller();
  		}
  		return self::$instance;
    }   

	public function usuarioActual(){
		if(isset($_SESSION['idUsuario'])){
			$usuario = RepositorioUsuario::getInstance()->buscarUsuarioPorId($_SESSION['idUsuario']);
    		return array(	'logueado'=>true, 
    						'username'=>$usuario->getNombreUsuario(),
    						'roles'=>RepositorioRol::getInstance()->buscarRolesDeUsuario($_SESSION['idUsuario']),
    						'idUsuario'=>$_SESSION['idUsuario'],
    						'token'=>$_SESSION['token']
    					);
		}
		else{
			return false;
		}
	}

	public function render($template,$parametrosTemplate = []){
		$parametrosTemplate['configuracion'] = $this->obtenerConfiguracion();
		$parametrosTemplate['usuarioActual'] = $this->usuarioActual();
		echo TwigView::getTwig()->render($template,$parametrosTemplate);
	}

	public function obtenerConfiguracion(){
		return RepositorioConfiguracion::getInstance()->datosParaLaVista();
	}
	
	public function datosDepaginado(){
		$paginado['cantidadPorPagina'] = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
		$paginado['actual'] = 1;
		if(isset($_GET['page'])){
    		$paginado['actual'] = $_GET['page'];
    	}

    	if($paginado['actual'] <= 1){
    		$paginado['limit'] =  0;
    	}
    	else{
    		$paginado['limit'] = $paginado['cantidadPorPagina'] * ($paginado['actual'] - 1);
    	}
    	return $paginado;

	}

	public function paginar($listado){
		$paginado = $this->datosDepaginado();
		$paginado['cantidadElementos'] = sizeof($listado);
		$paginado['cantidadPaginas'] = ceil($paginado['cantidadElementos']/$paginado['cantidadPorPagina']);
		return $paginado;
	} 
}

?>