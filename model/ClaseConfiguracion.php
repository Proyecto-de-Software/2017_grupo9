<?php
	class Configuracion{

		//private $id;
		private $titulo;
		private $descripcion;
		private $contacto;
		private $cantElem;
		private $habilitado;

		public function __construct($titulo, $descripcion, $contacto, $cantElem, $habilitado){
            $this->titulo = $titulo;
        	$this->descripcion = $descripcion;
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

        public function getDescripcion(){
        	return $this->descripcion;
        }

        public function setDescripcion($descripcion){
        	$this->descripcion = $descripcion;
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
    }