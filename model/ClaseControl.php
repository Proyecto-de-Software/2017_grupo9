<?php
	class Control{
		private $fecha;
		private $peso;
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

		public function __construct($arrayPost){

		}

		public function getFecha(){
			return $this->fecha;
		}
		public function setFecha($fecha){
			$this->fecha = $fecha;
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
		public function esValido(){
			
		}
	}



?>