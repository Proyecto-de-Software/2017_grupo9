<?php

	require_once("PDORepository.php");
	require_once("ClaseUsuario.php");

	class RepositorioRol extends PDORepository{
    private static $instance;
    public static function getInstance() {
      if (!isset(self::$instance)) {
          self::$instance = new RepositorioRol();
      }

      return self::$instance;
    }     

  	public function devolverRoles(){
          $conexion = $this->getConnection();
          $query = $conexion->prepare("SELECT * FROM rol");
          $query->execute();
          $resultado = $query->fetchAll();
          if(sizeof($resultado) > 0){
            return $resultado;
          }
          return false;

      }
    public function buscarRolesPorId($idRoles){
      $stringQuery = "SELECT * FROM rol WHERE id=";
      foreach($idRoles as $idRol){
        $stringQuery = $stringQuery.$idRol;
        if(!$idRol === end($idRoles)){
          $stringQuery = $stringQuery.' or id=';
        }
      }
      $conexion = $this->getConnection();
      $query = $conexion->prepare($stringQuery);
      if($query->execute()){
        return $query->fetchAll();
      }
      else return false;
    }
    public function buscarRolesPorNombre($nombresRoles){
     
      $stringQuery = "SELECT * FROM rol WHERE nombre=";
      foreach ($nombresRoles as $key => $value) {
        $stringQuery = $stringQuery."'$value'";
        if(!($value === end($nombresRoles))){
          $stringQuery = $stringQuery.' or nombre=';
        }
      }
      $conexion = $this->getConnection();
      $query = $conexion->prepare($stringQuery);
      $query->execute();
      return $query->fetchAll();

    }
}
// if(!($nombreRol === end($nombresRoles))){
?>