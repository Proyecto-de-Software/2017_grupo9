<?php

class ControllerDatosDemograficos extends Controller{
	
    public static function getInstance() {
      	if (!isset(self::$instance)) {
          self::$instance = new ControllerDatosDemograficos();
      	}
      	return self::$instance;
    }   

    public function crearDatosDemograficos(){
    	//Instancia un objeto de la clase DatosDemograficos, con los datos recibidos por POST desde el formulario de alta o edicion de datos demograficos.
    	$datosDemograficos = new DatosDemograficos($_POST['heladera'], $_POST['electricidad'], $_POST['mascota'], $_POST['tipoVivienda'], $_POST['tipoCalefaccion'], $_POST['tipoAgua'], $_POST['idPaciente']);
		return $datosDemograficos;
    }

    public function mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda=null,$tipoDeCalefaccion=null,$tipoDeAgua=null){
    	$template = 'administracionMostrarDatosDemograficos.twig';
    	$parametrosTemplate['idPaciente'] = $_GET['id']; //ver si se manejara asi o no 
		$parametrosTemplate['datosDemograficos'] = $datosDemograficos; // esto no se estaria repitiendo?
		$parametrosTemplate['tipoDeVivienda'] = $tipoDeVivienda;
		$parametrosTemplate['tipoDeCalefaccion'] = $tipoDeCalefaccion;
		$parametrosTemplate['tipoDeAgua'] = $tipoDeAgua;
		$this->render($template,$parametrosTemplate);

    }	

    public function agregarDatosDemograficos($tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
    	$template = 'administracionAgregarDatosDemograficos.twig';
    	$parametrosTemplate['idPaciente'] = $_GET['id']; //ver si se manejara asi o no 
		$parametrosTemplate['tipoDeVivienda'] = $tipoDeVivienda;
		$parametrosTemplate['tipoDeCalefaccion'] = $tipoDeCalefaccion;
		$parametrosTemplate['tipoDeAgua'] = $tipoDeAgua;
		$this->render($template,$parametrosTemplate);

    }

    public function modificarDatosDemograficos($datosDemograficos,$tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua){
    	$template = 'administracionModificarDatosDemograficos.twig';
		$parametrosTemplate['tipoDeVivienda'] = $tipoDeVivienda;
		$parametrosTemplate['tipoDeCalefaccion'] = $tipoDeCalefaccion;
		$parametrosTemplate['tipoDeAgua'] = $tipoDeAgua;
		$this->render($template,$parametrosTemplate);
    }
    //ver si no seria mejor devolver un arreglo y listo.
    //ej: $tipos['agua'] = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
    //$tipos['calefaccion'] = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
    //$tipos['vivienda'] = $tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
    //return $tipos
 	public function tiposDatosDemograficos(&$tiposDeVivienda,&$tiposDeCalefaccion,&$tiposDeAgua){
		$tiposDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTiposDeVivienda();
		$tiposDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTiposDeCalefaccion();
		$tiposDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTiposDeAgua();
	}
	//Lo mismo que la funcion anterior, es mejor y mas comodo manejar el resultado de la funcion como un arrray, que como variables sueltas que primero tenes que instanciarlas para mandarselas y que te seteen el dato, (muy pascal) jaja
	public function tiposDeUnDatoDemograficos($datosDemograficos,&$tipoDeVivienda,&$tipoDeCalefaccion,&$tipoDeAgua){
		$tipoDeVivienda = RepositorioDatosDemograficos::getInstance()->devolverTipoDeViviendaPorId($datosDemograficos->getTipoVivienda());
		$tipoDeCalefaccion = RepositorioDatosDemograficos::getInstance()->devolverTipoDeCalefaccionPorId($datosDemograficos->getTipoCalefaccion());
		$tipoDeAgua = RepositorioDatosDemograficos::getInstance()->devolverTipoDeAguaPorId($datosDemograficos->getTipoAgua());
	}

	public function formularioDatosDemograficos($idPaciente){	
		$datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorIdPaciente($idPaciente);
    	$this->tiposDatosDemograficos($tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
		$this->agregarDatosDemograficos($tiposDeVivienda,$tiposDeCalefaccion,$tiposDeAgua);
	}

	public function agregarDatosDemograficos(){
		//if RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_new')
		$datosDemograficos = crearDatosDemograficos();
		if(RepositorioDatosDemograficos::getInstance()->agregarDatosDemograficos($datosDemograficos)){
		   $idPaciente = $datosDemograficos->getPaciente();
		   //header a mostarDatos demograficos del paciente con $idPaciente
		}
		else{
			//volver a alta de datos demograficos
		}
		//si no hay permiso vuelve al /
	}

	public function mostarDatosDemograficos($idPaciente){
		//PEDIR A NACHO QUE ME EXPLIQUE QUE ONDA EL IF ELSE
		//if(RepositorioPermiso::getInstance()->usuarioTienePermiso($_SESSION['idUsuario'], 'datosdemograficos_show')){
		$datosDemograficos = RepositorioDatosDemograficos::getInstance()->buscarDatosDemograficosPorIdPaciente($idPaciente);
		if($datosDemograficos){
			$this->tiposDeUnDatoDemograficos($datosDemograficos,$tipoDeVivienda,$tipoDeCalefaccion,$tipoDeAgua);
		    $this->mostrarDatosDemograficos($datosDemograficos,$tipoDeVivienda,$tipoDeCalefaccion,$tipoDeAgua);
		}
		else{
			 $this->mostrarDatosDemograficos($datosDemograficos);
		}
		// si no hay permiso vuelve al home
	}



}

?>