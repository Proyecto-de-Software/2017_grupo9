<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');

class ControllerConfiguracion extends Controller{
	protected static $instance;
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

	public function formulario($validacion=[],$configuracionInvalida=null){
		if ($this->hayPermiso('configuracion_update')){
			$template = 'administracionConfiguracion.twig';
			$parametrosTemplate['configuracionActual'] = RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
			$parametrosTemplate['validacion'] = $validacion; //modificar template para que sepa que recibe el array
			$parametrosTemplate['configuracionInvalida'] = $configuracionInvalida; 
			$this->render($template,$parametrosTemplate);
		}
		else{
			$this->redireccion("/index.php");
		}
	}
	
	public function editar($edicion = false){
		if($this->hayPermiso('configuracion_update') && $this->tokenValido($_POST['token'])){
			$configuracion = $this->crearConfiguracion();
			$validacion = RepositorioConfiguracion::getInstance()->configuracionValida($configuracion);
			if($validacion['ok']){
				if($edicion){
					RepositorioConfiguracion::getInstance()->modificarConfiguracionHospital($configuracion);
					$this->redireccion("/index.php/configuracion");
				}
				else{
					RepositorioConfiguracion::getInstance()->crearConfiguracionHospital($configuracion);
					$this->redireccion("/index.php/configuracion");
				}
			}
			else{
				$this->formularioConfiguracion($validacion,$configuracion);
			}
		}
		else{
			$this->redireccion("/index.php");
		}

		//header a modificacion de configuracion
		//si campos invalidos volver a modificacion con mensaje
		//si no tiene permiso volver a index
	}

	public function obtenerDatosDeConfiguracion(){
		return RepositorioConfiguracion::getInstance()->obtenerDatosDeConfiguracion();
	}
}


?>