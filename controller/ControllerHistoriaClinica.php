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

		public function listado($idPaciente){ //index
			
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

		public function formulario($idPaciente,$argsTmp = [], $idControl = null){ //new
			if($this->hayPermiso('control_new') || $this->hayPermiso('control_update')){
				$_SESSION['controlAModificar'] == $idControl;
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

		public function mostrarControl($idControl){ //show
			if($this->hayPermiso('control_show')){
				$parametrosTemplate['control'] = RepositorioHistoriaClinica::getInstance()->buscarControlPorId($idControl);	
				$this->render('administracionMostrarControl.twig',$parametrosTemplate);
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}

		}
		public function agregar(){ //create
			if($this->hayPermiso('control_new') && $this->tokenValido($_POST['token'])){
				$control = new Control($_POST);
				$validacion = $control->esValido();
				if($validacion['ok']){
					RepositorioHistoriaClinica::getInstance()->agregarControl($control);
					$idPaciente = $control->getIdPaciente();
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
		public function editar($idControl){ //edit

			if($this->hayPermiso('control_update') && $this->tokenValido($_POST['token'])){
				if($_SESSION['controlAModificar'] == $idControl){
					$control = new Control($_POST);
					$control->setId($idControl);
					$validacion = $control->esValido();
					if($validacion['ok']){					
						RepositorioHistoriaClinica::getInstance()->editarControl($control);
						$idPaciente = $control->getIdPaciente();
						$this->redireccion("/index.php/paciente/$idPaciente/control/$idControl");
					}
					else{
						$parametrosTemplate['validacion'] = $validacion;
						$parametrosTemplate['control'] = $control;
						$this->formulario($control->getIdPaciente(),$parametrosTemplate,$control->getId());
					}
				}
				else {
					var_dump("permiso");die();
					$idControl = $_SESSION['controlAModificar'];
					$this->redireccion("/index.php/paciente/$idPaciente/control/edicion/$idControl");
				}
			}
			else{
				$this->redireccion("/index.php/pacientes");
			}
		}

		public function eliminar($idPaciente,$idControl){ //delete
			RepositorioHistoriaClinica::getInstance()->eliminar($idControl);
			$this->redireccion("/index.php/paciente/$idPaciente/historiaClinica");
		}

		public function mostrarReportes($id){
			$template = 'administracionReportesHistoriaClinica.twig';
			$paciente = RepositorioPaciente::getInstance()->buscarPorId($id);
            $controles = RepositorioHistoriaClinica::getInstance()->devolverControles($id);
            $pesos = []; $tallas = []; $ppc = [];
            foreach ($controles as $control) {
            	$semanas = (int)$this->calcularPeriodo(new DateTime($control['fecha']), new DateTime ($paciente->getFechaNacimiento()), 13, '%a', 7);
            	$meses = (int)$this->calcularPeriodo(new DateTime($control['fecha']), new DateTime ($paciente->getFechaNacimiento()), 2, '%m', 30);
            	
        		array_push($pesos, [$semanas, (float)$control['peso']* 1000]);
        		array_push($tallas, [$meses, (float)$control['talla']]);
        		array_push($ppc, [$semanas, (float)$control['ppc']]);
            }
            $parametrosTemplate['pesos'] = $pesos;
            $parametrosTemplate['tallas'] = $tallas;
            $parametrosTemplate['ppc'] = $ppc;
            $parametrosTemplate['genero'] = $paciente->getGenero();
            //var_dump($parametrosTemplate['tallas']);die();
            $this->render($template,$parametrosTemplate);
      	}

      	public function calcularPeriodo($fechaControl, $fechaNacimiento, $periodoAControlar, $periodo, $numero){
			$interval = $fechaNacimiento->diff($fechaControl);
			return floor($interval->days/$numero);
			
      	}
	}

?>