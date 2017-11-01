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

		public function usuarioTienePermiso($idUsuario, $permiso){
			$conexion = $this->getConnection();
			//Primero, busco que roles tiene el usuario.
			$queryRoles = $conexion->prepare("SELECT r.id FROM usuario_tiene_rol as utr INNER JOIN rol as r ON utr.rol_id=r.id WHERE utr.usuario_id=:idUsuario");
			$queryRoles->bindParam(':idUsuario',$idUsuario);
			$queryRoles->execute();
			$rolesDeUsuario = $queryRoles->fetchAll();
			//Segundo, armo la consulta para buscar el nombre de los permisos que tiene un determinado rol
			$queryPermisos = $conexion->prepare("SELECT p.nombre FROM permiso as p INNER JOIN rol_tiene_permiso as rtp ON p.id=rtp.permiso_id WHERE rtp.rol_id=:idRol");

			//Tercero, para cada rol del usuario, busco si tiene el permiso solicitado
			$ok = false; //Sera el resultado final, cuando se encuentre si el usuario tiene permiso o no 
			foreach ($rolesDeUsuario as $rol) {
				$idRol = $rol['id'];
				$queryPermisos->bindParam(':idRol',$idRol);
				$queryPermisos->execute();
				$permisosDeRol = $queryPermisos->fetchAll();	
					
				if(sizeof($permisosDeRol) > 0){
				//Me fijo si entre todos los permisos que tiene el rol, hay uno con el mismo nombre que viene en el parametro $permiso
					foreach ($permisosDeRol as $permisoDeRol){

						if($permisoDeRol['nombre'] == $permiso){
							$ok = true;
						}
					}
				}
			}
			return $ok;
		}
		
	
}

?>