<?php
	class Paciente{
        private $id;
		private $apellido;
		private $nombre;
		private $domicilio;
		private $telefono;
		private $fechaNacimiento;
		private $genero;
		private $idObraSocial;
		private $idTipoDocumento;
		private $numeroDoc;

        function __construct($apellido,$nombre,$domicilio,$telefono,$fechaNacimiento,$genero,$idObraSocial,$idTipoDocumento,$numeroDoc){
            $this->apellido = $apellido;
        	$this->nombre = $nombre;
        	$this->domicilio = $domicilio;
        	$this->telefono = $telefono;
        	$this->fechaNacimiento = $fechaNacimiento;
        	$this->genero = $genero;
        	$this->idObraSocial = $idObraSocial;
        	$this->idTipoDocumento = $idTipoDocumento;
        	$this->numeroDoc = $numeroDoc;
    	}

        public function getId(){
            return $this->id;
        }

        public function setId($id){
            $this->id = $id;
        }

    	public function getApellido(){
    		return $this->apellido;
    	}

    	public function setApellido($apellido){
    		$this->apellido = $apellido;
    	}

    	public function getNombre(){
    		return $this->nombre;
    	}

    	public function setNombre($nombre){
    		$this->nombre = $nombre;
    	}

    	public function getDomicilio(){
    		return $this->domicilio;
    	}

    	public function setDomicilio($domicilio){
    		$this->domicilio = $domicilio;
    	}

    	public function getTelefono(){
    		return $this->telefono;
    	}

    	public function setTelefono($telefono){
    		$this->telefono = $telefono;
    	}

    	public function getFechaNacimiento(){
    		return $this->fechaNacimiento;
    	}

    	public function setFechaNacimiento($fechaNacimiento){
    		$this->fechaNacimiento = $fechaNacimiento;
    	}

    	public function getGenero(){
    		return $this->genero;
    	}

    	public function setGenero($genero){
    		$this->genero = $genero;
    	}

    	public function getIdObraSocial(){
    		return $this->idObraSocial;
    	}

    	public function setIdObraSocial($idObraSocial){
    		$this->idObraSocial = $idObraSocial;
    	}

    	public function getIdTipoDocumento(){
			return $this->idTipoDocumento;
    	}

    	public function setIdTipoDocumento($idTipoDocumento){
			$this->idTipoDocumento = $idTipoDocumento;
    	}

    	public function getNumeroDoc(){
    		return $this->numeroDoc;
    	}

    	public function setNumeroDoc($numeroDoc){
    		$this->numeroDoc = $numeroDoc;
    	}
	}
