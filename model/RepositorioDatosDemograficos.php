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

		function agregarDatosDemograficos($datosDemograficos){
  			$conexion = $this->getConnection();

  			$query = $conexion->prepare("INSERT INTO datos_demograficos(id, heladera, electricidad, mascota, tipo_vivienda_id, tipo_calefaccion_id, tipo_agua_id, paciente_id) VALUES(null, :heladera, :electricidad, :mascota, :tipoVivienda, :tipoCalefaccion, :tipoAgua, :idPaciente)");
  			$query->bindParam(':heladera', $datosDemograficos->getHeladera());
  			$query->bindParam(':electricidad', $datosDemograficos->getElectricidad());
  			$query->bindParam(':mascota', $datosDemograficos->getMascota());
  			$query->bindParam(':tipoVivienda', $datosDemograficos->getTipoVivienda());
  			$query->bindParam(':tipoCalefaccion', $datosDemograficos->getTipoCalefaccion());
  			$query->bindParam(':tipoAgua', $datosDemograficos->getTipoAgua());
        $query->bindParam(':idPaciente', $datosDemograficos->getPaciente());

        if($query->execute() == 1){
          $datosDemograficos->setId($conexion->lastInsertId());
          return true;
        }
        return false;
  		}

  		function modificarDatosDemograficos($datosDemograficos){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare("UPDATE datos_demograficos SET heladera=:heladera, electricidad=:electricidad, mascota=:mascota, tipo_vivienda_id=:tipoVivienda, tipo_calefaccion_id=:tipoCalefaccion, tipo_agua_id=:tipoAgua WHERE id=:id");
        	$query->bindParam(':heladera', $datosDemograficos->getHeladera());
  			$query->bindParam(':electricidad', $datosDemograficos->getElectricidad());
  			$query->bindParam(':mascota', $datosDemograficos->getMascota());
  			$query->bindParam(':tipoVivienda', $datosDemograficos->getTipoVivienda());
  			$query->bindParam(':tipoCalefaccion', $datosDemograficos->getTipoCalefaccion());
  			$query->bindParam(':tipoAgua', $datosDemograficos->getTipoAgua());

        	return $query->execute() == 1;
  		}

      function buscarDatosDemograficosPorIdPaciente($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM datos_demograficos WHERE paciente_id = :id");
        $query->bindParam(':id', $id);
        if ($query->execute()) {
          $resultado = $query->fetchAll();
          if(sizeof($resultado) > 0){
            $datosDemograficos = new DatosDemograficos($resultado[0]['heladera'], $resultado[0]['electricidad'], $resultado[0]['mascota'], $resultado[0]['tipo_vivienda_id'], $resultado[0]['tipo_calefaccion_id'], $resultado[0]['tipo_agua_id'], $resultado[0]['paciente_id']);
            return $datosDemograficos;
          }
          return false;
        }
      }

      function devolverTiposDeVivienda(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_vivienda");
        $query->execute();
        $tiposDeVivenda = $query->fetchAll();
        return $tiposDeVivenda;
      }

      function devolverTiposDeCalefaccion(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_calefaccion");
        $query->execute();
        $tiposDeCalefaccion = $query->fetchAll();
        return $tiposDeCalefaccion;
      }

      function devolverTiposDeAgua(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_agua");
        $query->execute();
        $tiposDeAgua = $query->fetchAll();
        return $tiposDeAgua;
      }

      function devolverTipoDeViviendaPorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_vivienda WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $tipoVivienda = $query->fetchAll();
        if (sizeof($tipoVivienda) > 0){
          return new TipoVivienda($tipoVivienda[0]['id'],$tipoVivienda[0]['nombre']);
        }
        return false;
      }

      function devolverTipoDeCalefaccionPorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_calefaccion WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $tipoCalefaccion = $query->fetchAll();
        if (sizeof($tipoCalefaccion) > 0){
          return new TipoCalefaccion($tipoCalefaccion[0]['id'],$tipoCalefaccion[0]['nombre']);
        }
        return false;
      }

      function devolverTipoDeAguaPorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM tipo_agua WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $tipoAgua = $query->fetchAll();
        if (sizeof($tipoAgua) > 0){
          return new TipoAgua($tipoAgua[0]['id'],$tipoAgua[0]['nombre']);
        }
        return false;
      }
    }