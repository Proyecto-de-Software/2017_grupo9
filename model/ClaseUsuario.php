<?php
	class Usuario{
		private $nombreUsuario;
		private $email;
		private $password;
		private $activo;
		private $actualizadoEn;
		private $creadoEn;
		private $nombre;
		private $apellido;
		private $rol;

		private function __construct($nombreUsuario,$email,$password,$nombre,$apellido,$rol) {
        	$this->$nombreUsuario = $nombreUsuario;
        	$this->$email = $email; 
        	$this->$password = $password;
        	$this->$nombre = $nombre;
        	$this->$apellido = $apellido;
        	$this->$activo = true;
        	$this->$creadoEn = getDate();
        	$this->$actualizadoEn = getDate();
        	$this->$rol = $rol;
    	}
    	
    	public getNombreUsuario(){
    		return $this->$nombreUsuario;
    	}
    	public setNombreUsuario($nombreUsuario){
    		$this->$nombreUsuario = $nombreUsuario;
    	}
        public getPassword(){
            return $this->$password;
        }
        public setPassword($password){
            $this->$password = $password;
        }
    	public getEmail(){
    		return $this->$email;
    	}
    	public setEmail($email){
    		$this->$email = $email;
    	}
    	public getActivo(){
    		return $this->$activo;
    	}
    	public setActivo($boolean){
    		$this->$activo = $boolean;
    	}
    	public getFechaCreacion(){
    		return $this->$creadoEn;
    	}
    	public setFechaActualizacion($fecha){
    		$this->$actualizadoEn = $fecha;
    	}
    	public getFechaActualizacion(){
    		return $this->$actualizadoEn;
    	}
    	public getRol(){
    		return $this->$rol;
    	}
    	public setRol($rol){
    		$this->$rol = $rol;
    	}
	}
?>