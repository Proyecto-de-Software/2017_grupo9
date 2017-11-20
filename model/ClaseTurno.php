<?php
	class Turno {
        private $id;
		private $dni;
        private $fecha;
        private $hora;

		public function __construct($dni, $fecha, $hora){
            $this->dni = $dni;
        	$this->fecha = $fecha;
            $this->hora = $hora;
		}

        public function getDni(){
        	return $this->dni;
        }

        public function setDni($dni){
        	$this->dni = $dni;
        }

        public function getFecha(){
        	return $this->fecha;
        }

        public function setFecha($fecha){
            $this->fecha = $fecha;
        }

        public function getHora(){
            return $this->hora;
        }
        public function setHora($hora){
            $this->hora = $hora
        }
    
        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }
    }