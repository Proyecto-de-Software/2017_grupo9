<?php
	class Usuario{
        private $id;
		private $nombreUsuario;
		private $email;
		private $password;
		private $activo;
		private $actualizadoEn;
		private $creadoEn;
		private $nombre;
		private $apellido;
		private $idRoles;

		public function __construct($nombreUsuario,$email,$password,$activo, $creadoEn, $actualizadoEn, $nombre,$apellido, $idRoles) {
        	$this->nombreUsuario = $nombreUsuario;
        	$this->email = $email; 
        	$this->password = $password;
        	$this->nombre = $nombre;
        	$this->apellido = $apellido;
        	$this->activo = $activo;
        	$this->creadoEn = $creadoEn;
        	$this->actualizadoEn = $actualizadoEn;
        	$this->idRoles = $idRoles;

    	}
        public function esAdministrador(){
            foreach($idRoles as $idRol){
                if($idRol == 1) return true;
            }
            return false;
        }
        public function esRecepcionista(){
           foreach($idRoles as $idRol){
                if($idRol == 2) return true;
            }
            return false;
        }
        
        public function esPediatra(){
           foreach($idRoles as $idRol){
                if($idRol == 3) return true;
            }
            return false;
        }
        
    	public function getId(){
            return $this->id;
        }
        public function setId($id){
           $this->id = $id;
        }
    	public function getNombreUsuario(){
    		return $this->nombreUsuario;
    	}
    	public function setNombreUsuario($nombreUsuario){
    		$this->$nombreUsuario = $nombreUsuario;
    	}
        public function getPassword(){
            return $this->password;
        }
        public function setPassword($password){
            $this->password = $password;
        }
    	public function getEmail(){
    		return $this->email;
    	}
    	public function setEmail($email){
    		$this->email = $email;
    	}
    	public function getActivo(){
    		return $this->activo;
    	}
    	public function setActivo($boolean){
    		$this->activo = $boolean;
    	}
    	public function getFechaCreacion(){
    		return $this->creadoEn;
    	}
        public function setFechaCreacion($fecha){
            $this->creadoEn = $fecha;
        }
    	public function setFechaActualizacion($fecha){
    		$this->actualizadoEn = $fecha;
    	}
    	public function getFechaActualizacion(){
    		return $this->actualizadoEn;
    	}
    	public function getIdRoles(){
    		return $this->idRoles;
    	}
    	public function setIdRoles($idRoles){
    		$this->idRoles = $idRoles;
    	}
        public function getNombre(){
            return $this->nombre;
        }
        public function setNombre($nombre){
            $this->nombre = $nombre;
        }
        public function getApellido(){
            return $this->apellido;
        }
        public function setApellido($apellido){
            $this->apellido = $apellido;
        }
	}
?>