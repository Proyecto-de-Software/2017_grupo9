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
        	return $this->heladera;
        }

        public function setHeladera($heladera){
        	$this->heladera = $heladera;
        }

        public function getElectricidad(){
        	return $this->electricidad;
        }

        public function setElectricidad($electricidad){
        	$this->electricidad = $electricidad;
        }

        public function getMascota(){
        	return $this->mascota;
        }

        public function setMascota($mascota){
        	$this->mascota = $mascota;
        }

        public function getTipoVivienda(){
        	return $this->tipoVivienda;
        }

        public function setTipoVivienda($tipoVivienda){
        	$this->tipoVivienda = $tipoVivienda;
        }

        public function getTipoCalefaccion(){
        	return $this->tipoCalefaccion;
        }

        public function setTipoCalefaccion($tipoCalefaccion){
        	$this->tipoCalefaccion = $tipoCalefaccion;
        }

        public function getTipoAgua(){
        	return $this->tipoAgua;
        }

        public function setTipoAgua($tipoAgua){
        	$this->tipoAgua = $tipoAgua;
        }

        public function getPaciente(){
            return $this->paciente;
        }

        public function setPaciente($paciente){
            $this->paciente = $paciente;
        }
    }