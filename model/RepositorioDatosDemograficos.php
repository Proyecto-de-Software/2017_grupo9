<?php

	require_once("PDORepository.php");
	require_once("ClaseDatosDemograficos.php");

	class RepositorioDatosDemograficos extends PDORepository{

		public function agregarDatosDemograficos($datosDemograficos){
  			$conexion = $this->getConnection();

  			$query = $conexion->prepare("INSERT INTO datos_demograficos(id, heladera, electricidad, mascota, tipo_vivienda_id, tipo_calefaccion_id, tipo_agua_id) VALUES(null, :heladera, :electricidad, :mascota, :tipoVivienda, :tipoCalefaccion, :tipoAgua)");
  			$query->bindParam(':heladera', $datosDemograficos->getHeladera());
  			$query->bindParam(':electricidad', $datosDemograficos->getElectricidad());
  			$query->bindParam(':mascota', $datosDemograficos->getMascota());
  			$query->bindParam(':tipoVivienda', $datosDemograficos->getTipoVivienda());
  			$query->bindParam(':tipoCalefaccion', $datosDemograficos->getTipoCalefaccion());
  			$query->bindParam(':tipoAgua', $datosDemograficos->getTipoAgua());

        	return $query->execute() == 1;
  		}

  		public function modificarDatosDemograficos($datosDemograficos){
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