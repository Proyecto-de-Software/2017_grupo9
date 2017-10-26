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
  			$query = $conexion->prepare("INSERT INTO usuario(email, username, password, activo, updated_at, created_at, first_name, last_name) VALUES(:email, :username, :password, :activo, :updated_at, :created_at, :first_name, :last_name)");
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
  				foreach($usuario->getRoles() as $rol){
  					$query2->bindParam(':rol_id', $rol['id']);
  					$query2->execute();
          }
        }
			  else
				  return false;

  		}

  		public function modificarUsuario($usuario){

  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET email=:email, username=:username, password=:password, activo=:activo, updated_at=:updated_at, created_at=:created_at, first_name=:first_name, last_name=:last_name WHERE id=:id");
        $now = date('Y-m-d');
  			$query->bindParam(':email', $usuario->getEmail());
  			$query->bindParam(':username', $usuario->getNombreUsuario());
  			$query->bindParam(':password', $usuario->getPassword());
  			$query->bindParam(':activo', $usuario->getActivo());
  			$query->bindParam(':updated_at', $now);
  			$query->bindParam(':created_at', $usuario->getFechaCreacion());
  			$query->bindParam(':first_name', $usuario->getNombre());
  			$query->bindParam(':last_name', $usuario->getApellido());
        $query->bindParam(':id',$usuario->getId());
        $rolesQuery = $conexion->prepare("DELETE FROM usuario_tiene_rol WHERE usuario_id=:idUsuario");
        $rolesQuery->bindParam(':idUsuario',$usuario->getId());
        $rolesQuery->execute(); //Elimino los roles anteriores que tenga, y le pongo los actuales.
        $ok = $query->execute();
        if($ok){
          $nuevosRoles = $conexion->prepare("INSERT INTO usuario_tiene_rol(usuario_id,rol_id) VALUES(:idUsuario, :idRol) ");
          foreach($usuario->getRoles() as $rol){          
            $nuevosRoles->bindParam(':idUsuario',$usuario->getId());
            $nuevosRoles->bindParam(':idRol', $rol['id']);
            $ok = $ok && $nuevosRoles->execute();
          }
          return $usuario;
        }
        else return false;
     }

  		public function eliminarUsuario($idUsuario){
  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("DELETE FROM usuario WHERE id=:id");
  			$query->bindParam(':id', $idUsuario);
  			return $query->execute();	
  		}
  		//buscar usuario por ID
  		public function buscarUsuarioPorId($idUsuario){
	       	$conexion = $this->getConnection();
        	$query = $conexion->prepare("SELECT * FROM usuario WHERE id=:idUsuario");
        	$query->bindParam(':idUsuario', $idUsuario);
        	$query->execute();
          $usuario = $query->fetchAll();
          $queryRoles = $conexion->prepare("SELECT r.id, r.nombre FROM rol as r INNER JOIN usuario_tiene_rol as ur ON r.id=ur.rol_id  WHERE ur.usuario_id=:idUsuario");
          $queryRoles->bindParam(':idUsuario', $idUsuario);
        	$queryRoles->execute();     
          $roles = $queryRoles->fetchAll();
	        if(sizeof($usuario)>0){
	          $user = new Usuario($usuario[0]['username'],$usuario[0]['email'],$usuario[0]['password'],$usuario[0]['activo'], $usuario[0]['created_at'], $usuario[0]['updated_at'], $usuario[0]['first_name'],$usuario[0]['last_name'],$roles);
            $user->setId($usuario[0]['id']);
            
            return $user;
	        }
	        else
	        	return false;
      }
      public function devolverUsuarios($username = ""){
        $conexion = $this->getConnection();
        $queryString = "SELECT id FROM usuario";
        if ($username) $queryString.=" WHERE username=:username";
        $query = $conexion->prepare($queryString);
        if ($username)  $query->bindParam(':username', $username);
        $query->execute();
        $resultado = $query->fetchAll();
        $usuarios = [];
        if(sizeof($resultado) > 0){
          foreach($resultado as $usuario){
            array_push($usuarios, $this->buscarUsuarioPorId($usuario['id']));
          }

          return $usuarios;
        }
        else
          return false;

      }
      public function existeNombreUsuario($nombreUsuario){
        //devuelv true si el nombre de usuario ya existe
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM usuario WHERE username=:username");
        $query->bindParam(':username', $nombreUsuario);
        $query->execute();
        return (sizeof($query->fetchAll()) > 0);
      }
      public function existeEmail($email){
        //devuelv true si el nombre de usuario ya existe
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM usuario WHERE email=:email");
        $query->bindParam(':email', $email);
        $query->execute();
        return (sizeof($query->fetchAll()) > 0);
      }
  		public function activarUsuario($idUsuario){
  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET activo=:activo WHERE id=:id");
        $activo = 1;
  			$query->bindParam(':activo', $activo);
        $query->bindParam(':id', $idUsuario);
  			return $query->execute()==1;
  		}
  		public function bloquearUsuario($idUsuario){
 			  $conexion = $this->getConnection();
  			$query = $conexion->prepare("UPDATE  usuario SET activo=:activo WHERE id=:id");
        $activo = 0;
  			$query->bindParam(':activo', $activo);
        $query->bindParam(':id', $idUsuario);
  			return $query->execute()==1;	
  		}
      public function listarUsuariosActivos($porNombreUsuario = false,$nombreUsuario =""){
        $conexion = $this->getConnection();
        $queryString = "SELECT id FROM usuario WHERE activo=:activo";
        if($porNombreUsuario) $queryString.=" and username=:username";
        $query = $conexion->prepare($queryString);
        if($porNombreUsuario) $query->bindParam(':username',$nombreUsuario);
        $activo = 1;
        $query->bindParam(':activo',$activo);
        $query->execute();
        $resultado = $query->fetchAll();
        $usuarios = [];
        if(sizeof($resultado) > 0){
          foreach($resultado as $usuario){
            array_push($usuarios, $this->buscarUsuarioPorId($usuario['id']));
          }

          return $usuarios;
        }
        else
          return false;

      }
      public function listarUsuariosBloqueados($porNombreUsuario = false, $nombreUsuario =""){
        $conexion = $this->getConnection();
        $conexion = $this->getConnection();
        $queryString = "SELECT id FROM usuario WHERE activo=:activo";
        if($porNombreUsuario) $queryString.=" and username=:username";
        $query = $conexion->prepare($queryString);
        if($porNombreUsuario) $query->bindParam(':username',$nombreUsuario);
        $activo = 0;
        $query->bindParam(':activo',$activo);
        $query->execute();
        $resultado = $query->fetchAll();
        $usuarios = [];
        if(sizeof($resultado) > 0){
          foreach($resultado as $usuario){
            array_push($usuarios, $this->buscarUsuarioPorId($usuario['id']));
          }

          return $usuarios;
        }
        else
          return false;

      }
      public function listarUsuariosPorNombreUsuario($nombreUsuario){

      }
      public function existeUsuario($email,$password){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT id FROM usuario WHERE email=:email and password=:password");
        $query->bindParam(':email',$email);
        $query->bindParam(':password',$password);
        $query->execute();
       
        $resultado = $query->fetchAll();
        return sizeof($resultado) == 1;
      }
      public function buscarUsuarioPorEmail($email){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM usuario WHERE email=:email");  
        $query->bindParam(':email',$email);
        $query->execute();
        $resultado = $query->fetchAll();
        if(sizeof($resultado) > 0){
          return $this->buscarUsuarioPorId($resultado[0]['id']);
        }
        else return false;
      }
      public function buscarPorNombreDeUsuario($nombreUsuario){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM usuario WHERE username=:username");  
        $query->bindParam(':username',$username);
        $query->execute();
        $resultado = $query->fetchAll();
        if(sizeof($resultado) > 0){
          return $this->buscarUsuarioPorId($resultado[0]['id']);
        }
        else return false;
      }
      public function usuarioActivo($email){
         $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM usuario WHERE email=:email");  
        $query->bindParam(':email',$email);
        $query->execute();
        $result = $query->fetchAll();
        return $result[0]['activo'];

      }
	}