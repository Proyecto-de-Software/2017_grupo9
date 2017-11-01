<?php
	class DatosDemograficos{

		private $id;
		private $heladera;
		private $electricidad;
		private $mascota;
		private $tipoVivienda;
		private $tipoCalefaccion;
		private $tipoAgua;
        private $paciente;

		function __construct($heladera, $electricidad, $mascota, $tipoVivienda, $tipoCalefaccion, $tipoAgua, $paciente){
            $this->heladera = $heladera;
        	$this->electricidad = $electricidad;
        	$this->mascota = $mascota;
        	$this->tipoVivienda = $tipoVivienda;
        	$this->tipoCalefaccion = $tipoCalefaccion;
        	$this->tipoAgua = $tipoAgua;
            $this->paciente = $paciente;
		}

		public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

        public function getHeladera(){
        	$this->heladera;
        }

        public function setHeladera($heladera){
        	$this->heladera = $heladera;
        }

        public function getElectricidad(){
        	$this->electricidad;
        }

        public function setElectricidad($electricidad){
        	$this->electricidad = $electricidad;
        }

        public function getMascota(){
        	$this->mascota;
        }

        public function setMascota($mascota){
        	$this->mascota = $mascota;
        }

        public function getTipoVivienda(){
        	$this->tipoVivienda;
        }

        public function setTipoVivienda($tipoVivienda){
        	$this->tipoVivienda = $tipoVivienda;
        }

        public function getTipoCalefaccion(){
        	$this->tipoCalefaccion;
        }

        public function setTipoCalefaccion($tipoCalefaccion){
        	$this->tipoCalefaccion = $tipoCalefaccion;
        }

        public function getTipoAgua(){
        	$this->tipoAgua;
        }

        public function setTipoAgua($tipoAgua){
        	$this->tipoAgua = $tipoAgua;
        }

        public function getPaciente(){
            $this->paciente;
        }

        public function setPaciente($paciente){
            $this->paciente = $paciente;
        }
    }