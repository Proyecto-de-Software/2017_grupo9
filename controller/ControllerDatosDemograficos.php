<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/Controller/Controller.php');
class ControllerDatosDemograficos extends Controller{
	protected static $instance;
    public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerDatosDemograficos();
      	}
      	return self::$instance;
    }   

    public function crear(){
    	//Instancia un objeto de la clase DatosDemograficos, con los datos recibidos por POST desde el formulario de alta o edicion de datos demograficos.
    	$datosDemograficos = new DatosDemograficos($_POST['heladera'], $_POST['electricidad'], $_POST['mascota'], $_POST['tipoVivienda'], $_POST['tipoCalefaccion'], $_POST['tipoAgua'], $_POST['idPaciente']);
		return $datosDemograficos;
    }

	public function agregar(){
		if (RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_new')){
			$datosDemograficos = $this->crear();
			if(RepositorioDatosDemograficos::getInstance()->agregar($datosDemograficos)){
	 	  		$idPaciente = $datosDemograficos->getPaciente();
	 	  		header("Location: /index.php/paciente/$idPaciente/datosDemograficos");
			} else{
				header("Location: /index.php/paciente/$idPaciente/datosDemograficos/nuevo");
			}
		} else{
			header("Location: /index.php");
		}
	}

    public function mostrar($idPaciente){
    	if (RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_show')){
	    	$template = 'administracionMostrarDatosDemograficos.twig';
			if(!($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarPorIdPaciente($idPaciente))){
				$datosDemograficos = null;
			} else{
				$parametrosTemplate = $this->tiposDeUnDatoDemografico($datosDemograficos);
			}
	    	$parametrosTemplate['idPaciente'] = $idPaciente; 
			$parametrosTemplate['datosDemograficos'] = $datosDemograficos;
			$this->render($template,$parametrosTemplate);
		} else {
			header("Location: /index.php");
		}

    }	

    public function modificar($idPaciente){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_update')){
			if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarPorIdPaciente($idPaciente)){
					var_dump("12");
				if(RepositorioDatosDemograficos::getInstance()->modificar($datosDemograficos)){
					header("Location: /index.php/paciente/$idPaciente/datosDemograficos");
				} else{
					header("Location: /index.php/paciente/$idPaciente/datosDemograficos/editar");
				}
        	} else {
        		header("Location: /index.php/paciente/$idPaciente");
        	}
		} else{
			header("Location: /index.php");
		}
    }

    public function eliminar($idPaciente){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_destroy')){
			if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarPorIdPaciente($idPaciente)){
				RepositorioDatosDemograficos::getInstance()->eliminar($datosDemograficos);
        	}
        	header("Location: /index.php/paciente/$idPaciente");
        } else {
    		header("Location: /index.php");
		}
    }

    public function formulario($idPaciente){
    	if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_update')){
	    	$template = 'administracionFormularioDatosDemograficos.twig';
			$parametrosTemplate = $this->tiposDeDatos();
	    	$parametrosTemplate['idPaciente'] = $idPaciente;
	    	if($datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarPorIdPaciente($idPaciente)){
				$parametrosTemplate['datosDemograficos'] = $datosDemograficos;
				//var_dump($parametrosTemplate['datosDemograficos']);die();
			}
			$this->render($template,$parametrosTemplate);
		} else {
			header("Location: /index.php");
		}
    }
    
 	public function tiposDeDatos(){
		$datos['tiposDeVivienda'] = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
		$datos['tiposDeCalefaccion'] = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
		$datos['tiposDeAgua'] = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
		return $datos;
	}
	
	public function tiposDeUnDatoDemografico($datosDemograficos){
		$datos['tipoDeVivienda'] = RepositorioDatosDemograficos::getInstance()->devolverTipoDeViviendaPorId($datosDemograficos->getTipoVivienda());
		$datos['tipoDeCalefaccion'] = RepositorioDatosDemograficos::getInstance()->devolverTipoDeCalefaccionPorId($datosDemograficos->getTipoCalefaccion());
		$datos['tipoDeAgua'] = RepositorioDatosDemograficos::getInstance()->devolverTipoDeAguaPorId($datosDemograficos->getTipoAgua());
		return $datos;
	}

}

?>