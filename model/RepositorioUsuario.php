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

		private function __construct($nombreUsuario,$email,$password,$nombre,$apellido) {
        	this=>$nombreUsuario = $nombreUsuario;
        	this=>$email = $email; 
        	this=>$password = $password;
        	this=>$nombre = $nombre;
        	this=>$apellido = $apellido;
        	this=>$activo = true;
        	this=>$creadoEn = getDate();
        	this=>$actualizadoEn = getDate();
        	this=>$rol = //
    	}

	}
?>