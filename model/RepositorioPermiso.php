<?php

	require_once("PDORepository.php");
	require_once("ClasePaciente.php");
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/RepositorioUsuario.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseUsuario.php');

	session_start();

	class RepositorioPermiso extends PDORepository{
	    
	    private static $instance;

	    public static function getInstance() {
	      if (!isset(self::$instance)) {
	          self::$instance = new RepositorioPermiso();
	      }
	      return self::$instance;
	    } 


		public function UsuarioTienePermiso($usuario, $permiso){
			$conexion = $this->getConnection();
			$query = $conexion->prepare("SELECT * FROM permiso INNER JOIN rol_tiene_permiso ON permiso.id=rol_tiene_permiso.permiso_id WHERE permiso.nombre= :permiso AND rol_tiene_permiso.rol_id = :rol_id");
			$query->bindParam(':permiso', $permiso);
			foreach($usuario->getRoles() as $rol){
	  			$query->bindParam(':rol_id', $rol['id']);
	  			if($query->execute()){
	  				if(sizeOf($query->fetchAll()) > 0) {
	  					return true;
	  				}	
	  			} else
	  				echo "La consulta de permisos no se realizó correctamente";
	        }
	        return false;
		}
	}


?>