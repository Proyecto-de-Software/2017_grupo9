<?php

	require_once("PDORepository.php");
	require_once("ClaseDatosDemograficos.php");

	class RepositorioDatosDemograficos extends PDORepository{
    private static $instance;

      public static function getInstance() {
          if (!isset(self::$instance)) {
              self::$instance = new RepositorioDatosDemograficos();
          }

          return self::$instance;
      }  

		public function agregarDatosDemograficos($datosDemograficos){
  			$conexion = $this->getConnection();

  			$query = $conexion->prepare("INSERT INTO datos_demograficos(id, heladera, electricidad, mascota, tipo_vivienda_id, tipo_calefaccion_id, tipo_agua_id) VALUES(null, :heladera, :electricidad, :mascota, :tipoVivienda, :tipoCalefaccion, :tipoAgua)");
  			$query->bindParam(':heladera', $_POST['heladera']);
  			$query->bindParam(':electricidad', $_POST['electricidad']);
  			$query->bindParam(':mascota', $_POST['mascota']);
  			$query->bindParam(':tipoVivienda', $_POST['tipoVivienda']);
  			$query->bindParam(':tipoCalefaccion', $_POST['tipoCalefaccion']);
  			$query->bindParam(':tipoAgua', $_POST['tipoAgua']);

        	return $query->execute() == 1;
  		}

  		public function modificarDatosDemograficos($datosDemograficos){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare("UPDATE datos_demograficos SET heladera=:heladera, electricidad=:electricidad, mascota=:mascota, tipo_vivienda_id=:tipoVivienda, tipo_calefaccion_id=:tipoCalefaccion, tipo_agua_id=:tipoAgua WHERE id=:id");
        	$query->bindParam(':heladera', $_POST['heladera']);
  			$query->bindParam(':electricidad', $_POST['electricidad']);
  			$query->bindParam(':mascota', $_POST['mascota']);
  			$query->bindParam(':tipoVivienda', $_POST['tipoVivienda']);
  			$query->bindParam(':tipoCalefaccion', $_POST['tipoCalefaccion']);
  			$query->bindParam(':tipoAgua', $_POST['tipoAgua']);

        	return $query->execute() == 1;
  		}

      public function buscarDatosDemograficosPorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM datos_demograficos WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $datosDemograficos = $query->fetchAll();
        if (sizeof($datosDemograficos) > 0){
          return new DatosDemograficos($datosDemograficos[0]['id'],$datosDemograficos[0]['heladera'],$datosDemograficos[0]['electricidad'],$datosDemograficos[0]['mascota'], $datosDemograficos[0]['tipo_vivienda_id'],$datosDemograficos[0]['tipo_calefaccion_id'],$datosDemograficos[0]['tipo_agua_id']);
        }

        return false;
      }

      public function devolverTiposDeVivienda(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_vivienda");
        $query->execute();
        $tiposDeVivienda = $query->fetchAll();
        return $tiposDeVivienda;
      }

      public function devolverTiposDeCalefaccion(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_calefaccion");
        $query->execute();
        $tiposDeCalefaccion = $query->fetchAll();
        return $tiposDeCalefaccion;
      }

      public function devolverTiposDeAgua(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_agua");
        $query->execute();
        $tiposDeAgua = $query->fetchAll();
        return $tiposDeAgua;
      }


    }

?>