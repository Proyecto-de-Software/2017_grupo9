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
		private $roles; // se guarda un array con id y nombre de rol. Ej: $roles[0] tiene ['id']['nombre']
        private $password2;

		public function __construct($nombreUsuario,$email,$password,$activo, $creadoEn, $actualizadoEn, $nombre,$apellido, $roles) {
        	$this->nombreUsuario = $nombreUsuario;
        	$this->email = $email; 
        	$this->password = $password;
        	$this->nombre = $nombre;
        	$this->apellido = $apellido;
        	$this->activo = $activo;
        	$this->creadoEn = $creadoEn;
        	$this->actualizadoEn = $actualizadoEn;
        	$this->roles = $roles;

    	}
        public function esAdministrador(){
            foreach($roles as $rol){
                if($rol['nombre'] == 'administrador') 
                    return true;
                else
                    return false;
            }
        }
        public function esRecepcionista(){
            foreach($roles as $rol){
                if($rol['nombre'] == 'recepcionista') 
                    return true;
                else
                    return false;
            }
        }
        
        public function esPediatra(){
            foreach($roles as $rol){
                if($rol['nombre'] == 'pediatra') 
                    return true;
                else
                    return false;
            }
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
        public function setPassword($password2){
            $this->password = $password;
        }
        public function getPassword2(){
            return $this->password2;
        }
        public function setPassword2($password2){
            $this->password2 = $password2;
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
    	public function getRoles(){
    		return $this->roles;
    	}
    	public function setRoles($roles){
    		$this->roles = $roles;
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