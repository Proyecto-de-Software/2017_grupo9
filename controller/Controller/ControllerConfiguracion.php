<?php
require_once('Controller.php');

class ControllerConfiguracion extends Controller{

    public static function getInstance() {
    	if (!isset(self::$instance)) {
          self::$instance = new ControllerConfiguracion();
      	}
      	return self::$instance;
    }  

	public function crearConfiguracion(){
	//Instancia un objeto de la clase Configuracion, con los datos recibidos por POST desde el formulario de edicion de configuracion.
		if( $_POST['estado'] == 'habilitado'){
			$habilitado = 1;
		}
		else{
			$habilitado = 0;
		}
		$configuracion = new Configuracion($_POST['titulo'], $_POST['descripcionHospital'],$_POST['descripcionGuardia'],$_POST['descripcionEspecialidades'], $_POST['email'], $_POST['elementos'],$habilitado);
		if($_POST['edit'] == 'editar') $configuracion->setId($_POST['id']);
		return $configuracion;	
	}

	public function formularioConfiguracion($mensaje=null){
		//if RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'configuracion_update')
		$template = 'administracionConfiguracion.twig';
		$parametrosTemplate['configuracionActual'] = $this->obtenerDatosDeConfiguracion();
		$parametrosTemplate['mensaje'] = $mensaje;
		$this->render($template,$parametrosTemplate);
	}

	public function modificarConfiguracion($edicion=false){
		//RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'configuracion_update')) && (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']))
		//if campos validos (hacer en el repo config)
		if($edicion){
			RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital(crearConfiguracion());
		}
		else{
			RepositorioConfiguracion::getInstance()->crearConfiguracionHospital(crearConfiguracion());
		}
		//header a modificacion de configuracion
		//si campos invalidos volver a modificacion con mensaje
		//si no tiene permiso volver a index
	}

}


?>