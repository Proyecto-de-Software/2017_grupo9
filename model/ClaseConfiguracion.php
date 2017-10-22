<?php
	class Configuracion{
        private $id;
		private $titulo;
		private $descripcionHospital;
        private $descripcionGuardia;
        private $descripcionEspecialidades;
		private $contacto;
		private $cantElem;
		private $habilitado;

		public function __construct($titulo, $descripcionHospital,$descripcionGuardia,$descripcionEspecialidades, $contacto, $cantElem, $habilitado){
            $this->titulo = $titulo;
        	$this->descripcionHospital = $descripcionHospital;
            $this->descripcionGuardia = $descripcionGuardia;
            $this->descripcionEspecialidades = $descripcionEspecialidades;
        	$this->contacto = $contacto;
        	$this->cantElem = $cantElem;
        	$this->habilitado = $habilitado;
		}

        public function getTitulo(){
        	return $this->titulo;
        }

        public function setTitulo($titulo){
        	$this->titulo = $titulo;
        }

        public function getDescripcionHospital(){
        	return $this->descripcionHospital;
        }

        public function setDescripcionHospital($descripcionHospital){
            $this->descripcionHospital = $descripcionHospital;
        }

        public function setDescripcionGuardia($descripcionGuardia){
            $this->descripcionGuardia = $descripcionGuardia;
        }
        public function getDescripcionGuardia(){
            return $this->descripcionGuardia;
        }
        public function setDescripcionEspecialidades($descripcionEspecialidades){
            $this->descripcionEspecialidades = $descripcionEspecialidades;
        }
        public function getDescripcionEspecialidades(){
            return $this->descripcionEspecialidades;
        }

        public function getContacto(){
        	return $this->contacto;
        }

        public function setContacto($contacto){
        	$this->contacto = $contacto;
        }

        public function getCantElem(){
        	return $this->cantElem;
        }

        public function setCantElem($cantElem){
        	$this->cantElem = $cantElem;
        }

        public function getHabilitado(){
        	return $this->habilitado;
        }

        public function setHabilitado($habilitado){
        	$this->habilitado = $habilitado;
        }
        public function setId($id){
            $this->id = $id;
        }
        public function getId(){
            return $this->id;
        }
    }