<?php

	require_once("PDORepository.php");
	require_once("ClaseDatosDemograficos.php");
  require_once("ClaseTipoVivienda.php");
  require_once("ClaseTipoCalefaccion.php");
  require_once("ClaseTipoAgua.php");

	class RepositorioDatosDemograficos extends PDORepository{

    private static $instance;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new RepositorioDatosDemograficos();
        }

        return self::$instance;
    }

	 public function agregar($datosDemograficos){
			$conexion = $this->getConnection();

			$query = $conexion->prepare("INSERT INTO datos_demograficos(id, heladera, electricidad, mascota, tipo_vivienda_id, tipo_calefaccion_id, tipo_agua_id, paciente_id) VALUES(null, :heladera, :electricidad, :mascota, :tipoVivienda, :tipoCalefaccion, :tipoAgua, :idPaciente)");
			$query->bindParam(':heladera', $datosDemograficos->getHeladera());
			$query->bindParam(':electricidad', $datosDemograficos->getElectricidad());
			$query->bindParam(':mascota', $datosDemograficos->getMascota());
			$query->bindParam(':tipoVivienda', $datosDemograficos->getTipoVivienda());
			$query->bindParam(':tipoCalefaccion', $datosDemograficos->getTipoCalefaccion());
			$query->bindParam(':tipoAgua', $datosDemograficos->getTipoAgua());
      $query->bindParam(':idPaciente', $datosDemograficos->getPaciente());

      return $query->execute();
		}

		public function modificar($datosDemograficos){
      	$conexion = $this->getConnection();
      	$query = $conexion->prepare("UPDATE datos_demograficos SET heladera=:heladera, electricidad=:electricidad, mascota=:mascota, tipo_vivienda_id=:tipoVivienda, tipo_calefaccion_id=:tipoCalefaccion, tipo_agua_id=:tipoAgua, paciente_id=:paciente WHERE id=:id");
        //echo '<pre>'; var_dump($datosDemograficos);die();echo '</pre>';
      	$query->bindParam(':heladera', $datosDemograficos->getHeladera());
  			$query->bindParam(':electricidad', $datosDemograficos->getElectricidad());
  			$query->bindParam(':mascota', $datosDemograficos->getMascota());
  			$query->bindParam(':tipoVivienda', $datosDemograficos->getTipoVivienda());
  			$query->bindParam(':tipoCalefaccion', $datosDemograficos->getTipoCalefaccion());
  			$query->bindParam(':tipoAgua', $datosDemograficos->getTipoAgua());
        $query->bindParam(':paciente', $datosDemograficos->getPaciente());
        $query->bindParam(':id', $datosDemograficos->getId());

      	return $query->execute() == 1;
		}

    public function eliminar($datosDemograficos){
      $conexion = $this->getConnection();
      $query = $conexion->prepare("DELETE FROM datos_demograficos WHERE id = :id");
      $query->bindParam(':id', $datosDemograficos->getId()); 

      return $query->execute() == 1;        
      }

    public function buscarPorId($id){
      $conexion = $this->getConnection();
      $query = $conexion->prepare("SELECT * FROM datos_demograficos WHERE id = :id");
      $query->bindParam(':id', $id);
      if ($query->execute()) {
        $resultado = $query->fetchAll();
        if(sizeof($resultado) > 0){
          $datosDemograficos = new DatosDemograficos($resultado[0]['heladera'], $resultado[0]['electricidad'], $resultado[0]['mascota'], $resultado[0]['tipo_vivienda_id'], $resultado[0]['tipo_calefaccion_id'], $resultado[0]['tipo_agua_id'], $resultado[0]['paciente_id']);
          $datosDemograficos->setId($resultado[0]['id']);
          return $datosDemograficos;
        }
        return false;
      }
    }

    public function buscarPorIdPaciente($id){
      $conexion = $this->getConnection();
      $query = $conexion->prepare("SELECT * FROM datos_demograficos WHERE paciente_id = :id");
      $query->bindParam(':id', $id);
      if ($query->execute()) {
        $resultado = $query->fetchAll();
        if(sizeof($resultado) > 0){
          $datosDemograficos = new DatosDemograficos($resultado[0]['heladera'], $resultado[0]['electricidad'], $resultado[0]['mascota'], $resultado[0]['tipo_vivienda_id'], $resultado[0]['tipo_calefaccion_id'], $resultado[0]['tipo_agua_id'], $resultado[0]['paciente_id']);
          $datosDemograficos->setId($resultado[0]['id']);
          return $datosDemograficos;
        }
        return false;
      }
    }

    public function totalDatosDemograficos(){
      $conexion = $this->getConnection();
      $query = $conexion->prepare("SELECT COUNT(*) as total FROM datos_demograficos");
      $query->execute();
      $resultado = $query->fetchAll();
      return $resultado[0]['total'];
    }

    public function avgDatosDemograficos(){
      $resultado = array();
      $total = $this->totalDatosDemograficos();
      $conexion = $this->getConnection();
      $query = $conexion->prepare("SELECT id FROM datos_demograficos WHERE heladera = 1");
      $query->execute();
      $resultado['heladera'] = count($query->fetchAll());

      $query = $conexion->prepare("SELECT id FROM datos_demograficos WHERE electricidad = 1");
      $query->execute();
      $resultado['electricidad'] = count($query->fetchAll());

      $query = $conexion->prepare("SELECT id FROM datos_demograficos WHERE mascota = 1");
      $query->execute();
      $resultado['mascota'] = count($query->fetchAll());

      foreach ($resultado as &$value) {
        $value = ($value * 100) / $total;
      }

      return $resultado;
    }

    public function avgTipos($tipo, $tipos){
      $resultado = array();
      $total = $this->totalDatosDemograficos();
      $conexion = $this->getConnection();
      switch ($tipo) {
        case 'vivienda':
          $sql = "SELECT id FROM datos_demograficos WHERE tipo_vivienda_id = :id";
          break;
        case 'calefaccion':
          $sql = "SELECT id FROM datos_demograficos WHERE tipo_calefaccion_id = :id";
          break;
        case 'agua':
          $sql = "SELECT id FROM datos_demograficos WHERE tipo_agua_id = :id";
        break;
      }
        
      $i = 0;

      foreach ($tipos as $value) {
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $value->id);
        $query->execute();
        $resultado[$i] = count($query->fetchAll());
        $i++;
      }
      //echo '<pre>'; var_dump($resultado); echo '</pre>'; die();

      foreach ($resultado as &$value) {
          $value = ($value * 100) / $total;
      }
      return $resultado; 
    }

}