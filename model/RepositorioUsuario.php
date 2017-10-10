<?php
	require_once("PDORepository.php")
	class RepositorioUsuario extends PDORepository{


  		public agregarUsuario($usuario){
  			$conexion = this->getConnection();
  			$query = $conexion->prepare("INSERT INTO usuario(id, email, username, password, activo, updated_at, created_at, first_name, last_name) VALUES(null, :email, :username, :password, :activo, :updated_at, :created_at, :first_name, :last_name)");
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':username', $usuario->getNombreUsuario());
  			$query->bindParam(':password', $usuario->getEmail());
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':email', $usuario->getEmail());

  		}
  		//CRUD
  		//buscar usuario por ID
  		//activar / bloquear usuario
  		//asignar o desasignar roles

	}