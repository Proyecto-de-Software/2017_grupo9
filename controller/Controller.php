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
    protected function hayPermiso($permiso){
      	return RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], $permiso);
    }
    protected function tokenValido($token){
    	return $token == $_SESSION['token'];
    }
    protected function redireccion($url){
    	
    	header("Location: $url");
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


	public function paginar($listado,$pagina){
		$paginado['cantidadPorPagina'] = (int)RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion()->getCantElem();
		$paginado['actual'] = $pagina;
		if($paginado['actual'] <= 1){
    		$paginado['offset'] =  0;
    	}
    	else{
    		$paginado['offset'] = $paginado['cantidadPorPagina'] * ($paginado['actual'] - 1);
    	}
		$paginado['cantidadElementos'] = sizeof($listado);
		$paginado['cantidadPaginas'] = ceil($paginado['cantidadElementos']/$paginado['cantidadPorPagina']);
		return $paginado;
	}

	public function datosAPI($url, $id = ''){
		$ch = curl_init();
		
		// Configurar URL y otras opciones apropiadas
		$parametro = "https://api-referencias.proyecto2017.linti.unlp.edu.ar/$url"."$id";
		curl_setopt($ch, CURLOPT_URL, $parametro);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Capturar la URL y pasarla al navegador
		$response = curl_exec($ch);

		// Cerrar el recurso cURL y liberar recursos del sistema
		curl_close($ch);

		return json_decode($response);
	}

	public function calcularEdad($fecha){
		$actualDay = date('d');
		$actualMonth = date('m');
		$actualYear = date('Y');
		$fecha = explode('-', $fecha);
		$day = $fecha[2];
		$month = $fecha[1];
		$year = $fecha[0];

		if( (($actualMonth == $month)&&($day > $actualDay)) || $month > $actualMonth){
			$year = $year - 1;
		}
		return $actualYear - $year;
	}
}

?>