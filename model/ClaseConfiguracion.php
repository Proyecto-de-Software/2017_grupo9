<?php
	class Configuracion{

		private $id;
		private $titulo;
		private $descripcion;
		private $contacto;
		private $cantElem;
		private $habilitado;

		private function __construct($id, $titulo, $descripcion, $contacto, $cantElem, $habilitado){
			$this->id = $id;
            $this->titulo = $titulo;
        	$this->descripcion = $descripcion;
        	$this->contacto = $contacto;
        	$this->cantElem = $cantElem;
        	$this->habilitado = $habilitado;
		}

		public function getId(){
            return $this->id;
        }

        public function getTitulo(){
        	$this->titulo;
        }

        public function setTitulo($titulo){
        	$this->titulo = $titulo;
        }

        public function getDescripcion(){
        	$this->descripcion;
        }

        public function setDescripcion($descripcion){
        	$this->descripcion = $descripcion;
        }

        public function getContacto(){
        	$this->contacto;
        }

        public function setContacto($contacto){
        	$this->contacto = $contacto;
        }

        public function getCantElem(){
        	$this->catElem;
        }

        public function setCantElem($cantElem){
        	$this->cantElem = $cantElem;
        }

        public function getHabilitado(){
        	$this->habilitado;
        }

        public function setHabilitado($habilitado){
        	$this->habilitado = $habilitado;
        }