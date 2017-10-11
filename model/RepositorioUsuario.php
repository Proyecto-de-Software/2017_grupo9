<?php

	require_once("PDORepository.php");
	require_once("ClaseUsuario.php");

	class RepositorioUsuario extends PDORepository{
      private static $instance;

      public static function getInstance() {
          if (!isset(self::$instance)) {
              self::$instance = new RepositorioUsuario();
          }

          return self::$instance;
      }       

  		public function agregarUsuario($usuario){
  			$conexion = $this->getConnection();

  			$query = $conexion->prepare("INSERT INTO usuario(id,email, username, password, activo, updated_at, created_at, first_name, last_name) VALUES(null,:email, :username, :password, :activo, :updated_at, :created_at, :first_name, :last_name)");
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':username', $usuario->getNombreUsuario());
  			$query->bindParam(':password', $usuario->getPassword());
  			$query->bindParam(':activo', $usuario->getActivo());
  			$query->bindParam(':updated_at', $usuario->getFechaActualizacion());
  			$query->bindParam(':created_at', $usuario->getFechaCreacion());
  			$query->bindParam(':first_name', $usuario->getNombre());
  			$query->bindParam(':last_name', $usuario->getApellido());
			  if($query->execute() == 1){
  				$newId = $conexion->lastInsertId();
  				$query2 = $conexion->prepare("INSERT INTO usuario_tiene_rol(usuario_id, rol_id) VALUES(:usuario_id, :rol_id)");
  				$query2->bindParam(':usuario_id', $newId);
  				foreach($usuario->getIdRoles() as $idRol){
  					$query2->bindParam(':rol_id', $idRol);
  					$query2->execute();
          }
          echo("se agrego");
        }
			  else
				return false;

  		}

  		public function actualizarUsuario($usuario){
  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET email=:email, username=:username, password=:password, activo=:activo, updated_at=:updated_at, created_at=:created_at, first_name=:first_name, last_name=:last_name WHERE id=:id");
  			$query->bindParam(':id',$usuario->getId());
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':username', $usuario->getNombreUsuario());
  			$query->bindParam(':password', $usuario->getPassword());
  			$query->bindParam(':activo', $usuario->getActivo());
  			$query->bindParam(':updated_at', $usuario->getFechaActualizacion());
  			$query->bindParam(':created_at', $usuario->getFechaCreacion());
  			$query->bindParam(':first_name', $usuario->getNombre());
  			$query->bindParam(':last_name', $usuario->getApellido());
			return $query->execute() == 1;		
  		}

  		public function eliminarUsuario($idUsuario){
  			$conexion = $this->getConnection();
  			$query = "DELETE FROM usuario WHERE id = :id";
  			$query->bindParam(':id',$idUsuario);
  			return $query->execute() == 1;	
  		}
  		//buscar usuario por ID
  		public function buscarUsuarioPorId($idUsuario){
	       	$conexion = $this->getConnection();
        	$query = $conexion->prepare("SELECT * FROM usuario WHERE id=:idUsuario");
        	$query->bindParam(':idUsuario', $idUsuario);
        	$queryRoles = $conexion->prepare("SELECT rol_id FROM usuario_tiene_rol WHERE id=$idUsuario");
        	$queryRoles->bindParam(':idUsuario', $idUsuario);
        	$resultado = $query->execute();
        	$resultadoRoles = $queryRoles->execute();
        	$usuario = $query->fetchAll();
        	$roles = array_values($queryRoles->fetchAll());
	        if(sizeof($usuario)>0){
	          $usuario = new Usuario($resultado[0]['username'],$resultado[0]['email'],$resultado[0]['password'],$resultado[0]['activo'], $resultado[0]['created_at'], $resultado[0]['updated_at'], $resultado[0]['first_name'],$resultado[0]['last_name'],$roles);
            $usuario->setId($resultado[0]['id']);
            return $usuario;
	        }
	        else
	        	return false;
      }

  		public function activarUsuario($idUsuario){
  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET activo=:activo");
  			$query->bindParam(':activo', true);
  			return $query->execute()==1;
  		}
  		public function bloquearUsuario($idUsuario){
 			$conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET activo=:activo");
  			$query->bindParam(':activo', false);
  			return $query->execute()==1;	
  		}

    
        
	}