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

		public function __construct($nombreUsuario,$email,$password,$activo, $nombre,$apellido, $roles) {
        	$this->nombreUsuario = $nombreUsuario;
        	$this->email = $email; 
        	$this->password = $password;
        	$this->nombre = $nombre;
        	$this->apellido = $apellido;
        	$this->activo = $activo;
        	$this->roles = $roles;
           
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
        public function esValido($edicion=false){
            $retorno['ok'] = true;
            if( !($this->getNombre() != null && trim($this->getNombre()) !='') ){
                array_push($retorno, 'El nombre no debe estar vacio');
                $retorno['ok'] = false;
            }
            if(!($this->getApellido() != null && trim($this->getApellido()) !='')){
                array_push($retorno, 'El apellido no debe estar vacio');
                 $retorno['ok'] = false;
            }

           
            $existeUsuario = RepositorioUsuario::getInstance()->existeNombreUsuario($this->getNombreUsuario());
            if($edicion && $existeUsuario){
              $usuarioEnModificacion = RepositorioUsuario::getInstance()->buscarUsuarioPorId($this->getId());
              $existeUsuario = $usuarioEnModificacion->getNombreUsuario() != $this->getNombreUsuario();
            }
            if(!($this->getNombreUsuario() != null && trim($this->getNombreUsuario()) !='') ){
                array_push($retorno, 'El nombre de usuario no debe estar vacio');
                $retorno['ok'] = false;
            }
            elseif($existeUsuario){
              array_push($retorno, 'El nombre de usuario ya existe');
              $retorno['ok'] = false;
            }

            $email = $this->getEmail() != null && filter_var($this->getEmail(),FILTER_VALIDATE_EMAIL);
            $existeEmail = $email && RepositorioUsuario::getInstance()->existeEmail($this->getEmail());
            if($edicion && $existeEmail){
              $usuarioEnModificacion = RepositorioUsuario::getInstance()->buscarUsuarioPorId($this->getId());
              $existeEmail = $usuarioEnModificacion->getEmail() != $this->getEmail();
            }
            if(!$email){
              array_push($retorno, 'El email no debe estar vacio y debe cumplir con el formato');
              $retorno['ok'] = false;
            }
            elseif($existeEmail){
              array_push($retorno, 'El email  ya existe');
              $retorno['ok'] = false;
            }

            $password = $this->getPassword() != null && trim($this->getPassword()) !='';
            $password2 = $this->getPassword2() != null && trim($this->getPassword2()) !='';
            $coincidenPasswords = $this->getPassword() == $this->getPassword2();

            if( !$coincidenPasswords){
              array_push($retorno, 'Las contraseñas deben coincidir');
              $retorno['ok'] = false;
            }
            $roles = $this->getRoles()!=null;
            if(!$roles){
              array_push($retorno, 'Debe seleccionar al menos un rol');
              $retorno['ok'] = false;
            }
            return $retorno;
            }
	}
?>