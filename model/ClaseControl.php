<?php
	class Control{
		private $id;
		private $fecha;
		private $peso;
		private $edad;
		private $vacunasCompletas; //boolean
		private $observacionesVacunas;
		private $maduracionAcorde; //boolean
		private $observacionesMaduracion; 
		private $examenFisicoNormal; //boolean
		private $observacionesExamen; 
		private $pc; //percentilo cefalico
		private $ppc; //percentilo perimetro cefalico
		private $talla;
		private $descripcionAlimentacion;
		private $observacionesGenerales;
		private $idMedico;
		private $idPaciente;

		public function esValido(){
			//$fecha = $this->fecha !=
			//$peso = 
		}
		public function __construct($args){
			if(isset($args['fecha']))
				$this->setFecha($args['fecha']);
			if(isset($args['id']))
				$this->setId($args['id']);
			if(isset($args['peso']))
				$this->setPeso($args['peso']);
			if(isset($args['vacunas_completas']))
				$this->setVacunasCompletas($args['vacunas_completas']);
			if(isset($args['vacunas_completas_observaciones']))	
				$this->setObservacionesVacunas($args['vacunas_completas_observaciones']);
			if(isset($args['maduracion_acorde']))	
				$this->setMaduracionAcorde($args['maduracion_acorde']);
			if(isset($args['maduracion_acorde_observaciones']))	
				$this->setObservacionesMaduracion($args['maduracion_acorde_observaciones']);
			if(isset($args['ex_fisico_normal']))	
				$this->setExamenFisicoNormal($args['ex_fisico_normal']);
			if(isset($args['ex_fisico_observaciones']))
				$this->setObservacionesExamen($args['ex_fisico_observaciones']);
			if(isset($args['pc']))
				$this->setPc($args['pc']);
			if(isset($args['ppc']))
				$this->setPpc($args['ppc']);
			if(isset($args['talla']))
				$this->setTalla($args['talla']);
			if(isset($args['alimentacion']))
				$this->setDescripcionAlimentacion($args['alimentacion']);
			if(isset($args['observaciones_generales']))
				$this->setObservacionesGenerales($args['observaciones_generales']);
			if(isset($args['user_id']))
				$this->setIdMedico($args['user_id']);
			if(isset($args['paciente_id']))	
				$this->setIdPaciente($args['paciente_id']);
		}

		public function getFecha(){
			return $this->fecha;
		}
		public function setFecha($fecha){
			$this->fecha = $fecha;
		}
		public function getId(){
			return $this->id;
		}
		public function setId($id){
			$this->id = $id;
		}
		public function getPeso(){
			return $this->peso;
		}
		public function setPeso($peso){
			$this->peso = $peso;
		}

		public function getVacunasCompletas(){
			return $this->vacunasCompletas;
		}
		public function setVacunasCompletas($vacunasCompletas){
			$this->vacunasCompletas = $vacunasCompletas;
		}

		public function getObservacionesVacunas(){
			return $this->observacionesVacunas;
		}
		public function setObservacionesVacunas($observacionesVacunas){
			$this->observacionesVacunas = $observacionesVacunas;
		}

		public function getMaduracionAcorde(){
			return $this->maduracionAcorde;
		}
		public function setMaduracionAcorde($maduracionAcorde){
			$this->maduracionAcorde = $maduracionAcorde;
		}

		public function getObservacionesMaduracion(){
			return $this->observacionesMaduracion;
		}
		public function setObservacionesMaduracion($observacionesMaduracion){
			$this->observacionesMaduracion = $observacionesMaduracion;
		}

		public function getExamenFisicoNormal(){
			return $this->examenFisicoNormal;
		}
		public function setExamenFisicoNormal($examenFisicoNormal){
			$this->examenFisicoNormal = $examenFisicoNormal;
		}
		public function getObservacionesExamen(){
			return $this->observacionesExamen;
		}
		public function setObservacionesExamen($observacionesExamen){
			$this->observacionesExamen = $observacionesExamen;
		}
		public function getPc(){
			return $this->pc;
		}
		public function setPc($pc){
			$this->pc = $pc;
		}

		public function getPpc(){
			return $this->pc;
		}
		public function setPpc($ppc){
			$this->ppc = $ppc;
		}

		public function getTalla(){
			return $this->talla;
		}
		public function setTalla($talla){
			$this->talla = $talla;
		}

		public function getDescripcionAlimentacion(){
			return $this->descripcionAlimentacion;
		}
		public function setDescripcionAlimentacion($descripcionAlimentacion){
			$this->descripcionAlimentacion = $descripcionAlimentacion;
		}

		public function getObservacionesGenerales(){
			return $this->observacionesGenerales;
		}
		public function setObservacionesGenerales($observacionesGenerales){
			$this->observacionesGenerales = $observacionesGenerales;
		}
		public function getIdMedico(){
			return $this->idMedico;
		}
		public function setIdMedico($idMedico){
			$this->idMedico = $idMedico;
		}
		public function getIdPaciente(){
			return $this->idPaciente;
		}
		public function setIdPaciente($idPaciente){
			$this->idPaciente = $idPaciente;
		}
		public function getEdad(){

		}

	}



?>