<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioHistoriaClinica.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioPaciente.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioPermiso.php');
	class ControllerHistoriaClinica extends Controller{

		public static function getInstance() {
			if (!isset(self::$instance)) {
         		self::$instance = new ControllerHistoriaClinica();
      		}
      		return self::$instance;
      	}

		public function listarControles($idPaciente){
			
			if($this->hayPermiso('control_index')){
				$listado = RepositorioHistoriaClinica::getInstance()->obtenerControles($idPaciente);
				$lista = [];
				foreach ($listado as $control) {
					array_push($lista, array('fecha' => $control->getFecha(), 'medico' => RepositorioUsuario::getInstance()->buscarUsuarioPorId($control->getIdMedico())->getNombre(),'id' => $control->getId()));
				}
				$parametrosTemplate['lista'] = $lista;
				$parametrosTemplate['idPaciente'] = $idPaciente;
				$this->render('administracionControles.twig',$parametrosTemplate);
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}
		}

		public function formulario($idPaciente,$argsTmp = [], $idControl = null){
			if($this->hayPermiso('control_new') || $this->hayPermiso('control_update')){
				$edad = $this->calcularEdad(RepositorioPaciente::getInstance()->buscarPorId($idPaciente)->getFechaNacimiento());
				$parametrosTemplate = $argsTmp;
				$parametrosTemplate['edad'] = $edad;
				$parametrosTemplate['idPaciente'] = $idPaciente;
				if(isset($idControl)){
					$control = RepositorioHistoriaClinica::getInstance()->buscarControlPorId($idControl);
					$parametrosTemplate['control'] = $control;
					$parametrosTemplate['edicion'] = true;
				}
				$this->render('administracionFormularioControlGeneral.twig',$parametrosTemplate);
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}
		}

		public function mostrarControl($idControl){
			if($this->hayPermiso('control_show')	){
				$parametrosTemplate['control'] = RepositorioHistoriaClinica::getInstance()->buscarControlPorId($idControl);	
				$this->render('administracionMostrarControl.twig',$parametrosTemplate);
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}

		}
		public function agregar(){
			if($this->hayPermiso('control_new') && $this->tokenValido($_POST['token'])){
				$control = new Control($_POST);
				$validacion = $control->esValido();
				if($validacion['ok']){
					RepositorioHistoriaClinica::getInstance()->agregarControl($control);
					$idControl = $control->getId();
					$this->redireccion("/index.php/paciente/$idPaciente/control/$idControl");
				}
				else{
					$parametrosTemplate['validacion'] = $validacion;
					$parametrosTemplate['control'] = $control;
					$this->formulario($control->getIdPaciente(),$parametrosTemplate);
				}
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}
		}
		public function editar(){
			if($this->hayPermiso('control_update') && $this->tokenValido($_POST['token'])){
				$control = new Control($_POST);
				$validacion = $control->esValido();
				if($validacion['ok']){
					
					RepositorioHistoriaClinica::getInstance()->editarControl($control);
					$idControl = $control->getId();
					$this->redireccion("/index.php/paciente/$idPaciente/control/$idControl");
				}
				else{
					$parametrosTemplate['validacion'] = $validacion;
					$parametrosTemplate['control'] = $control;
					$this->formulario($control->getIdPaciente(),$parametrosTemplate,$control->getId());
				}
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}
		}
	}

?>