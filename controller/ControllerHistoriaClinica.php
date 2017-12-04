<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/controller/Controller.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioHistoriaClinica.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioPaciente.php');
	class ControllerHistoriaClinica extends Controller{
		public static function getInstance() {
			if (!isset(self::$instance)) {
         		self::$instance = new ControllerHistoriaClinica();
      		}
      		return self::$instance;
      	}

		public function listarControles($idPaciente){
			$listado = RepositorioHistoriaClinica::getInstance()->obtenerControles($idPaciente);
			$lista = [];
			foreach ($listado as $control) {
				array_push($lista, array('fecha' => $control->getFecha(), 'medico' => RepositorioUsuario::getInstance()->buscarUsuarioPorId($control->getIdMedico())->getNombre(),'id' => $control->getId()));
			}
			$parametrosTemplate['lista'] = $lista;
			$parametrosTemplate['idPaciente'] = $idPaciente;
			$this->render('administracionControles.twig',$parametrosTemplate);
		}

		public function formulario($idPaciente){
			$edad = $this->calcularEdad(RepositorioPaciente::getInstance()->buscarPorId($idPaciente)->getFechaNacimiento());
			$parametrosTemplate['edad'] = $edad;
			$this->render('administracionFormularioControlGeneral.twig',$parametrosTemplate);
		}

		public function mostrarControl($idControl){
			$control = RepositorioHistoriaClinica::getInstance()->buscarControlPorId($idControl);
			$parametrosTemplate['control'] = $control;
			$this->render('administracionMostrarControl.twig',$parametrosTemplate);

		}
		public function agregar(){
			$control = new Contrl($_POST);
			$validacion = $control->esValido();
			if($validacion['ok']){
				RepositorioHistoriaClinica::getInstance()->agregarControl($control);
				header("Location: index.php/paciente/$idPaciente/historiaClinica");
			}
			else{
				$parametrosTemplate['validacion'] = $validacion;
				$this->render('administracionFormularioControlGeneral.twig',$parametrosTemplate);
			}
		}
	}

?>