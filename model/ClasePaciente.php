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
        public function esValido($edicion=false){
            $retorno['ok'] = false;
            $nombre = $this->getNombre() != null && trim($this->getNombre()) !='';
            if(!$nombre){
              array_push($retorno, 'El nombre no debe estar vacio');
              $retorno['ok'] = false;
            }
            $apellido = $this->getApellido() != null && trim($this->getApellido()) !='';
            if(!$apellido){
              array_push($retorno, 'El apellido no debe estar vacio');
              $retorno['ok'] = false;
            }
            $domicilio = $this->getDomicilio() != null && trim($this->getDomicilio()) !='';
            if(!$domicilio){
              array_push($retorno, 'El domicilio no debe estar vacio');
              $retorno['ok'] = false;
            }
            $fechaNacimiento = $this->getFechaNacimiento() != null && trim($this->getFechaNacimiento()) !='';
            if(!$fechaNacimiento){
              array_push($retorno, 'La fecha de nacimiento no debe estar vacia');
              $retorno['ok'] = false;
            }
            $genero = $this->getGenero() != null && trim($this->getGenero()) !='';
            if(!$genero){
              array_push($retorno, 'El genero no debe estar vacio');
              $retorno['ok'] = false;
            }
            $idTipoDocumento = $this->getIdTipoDocumento() != null && trim($this->getIdTipoDocumento()) !='';
            if(!$idTipoDocumento){
              array_push($retorno, 'El tipo de documento no debe estar vacio');
              $retorno['ok'] = false;
            }
            $numeroDoc = $this->getNumeroDoc() != null && trim($this->getNumeroDoc()) !='';
            if(!$numeroDoc){
              array_push($retorno, 'El numero de documento no debe estar vacio');
              $retorno['ok'] = false;
            }
            return $retorno;
        }   
	}
