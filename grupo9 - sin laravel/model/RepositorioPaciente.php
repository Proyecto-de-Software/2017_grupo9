<?php

	require_once("PDORepository.php");
  require_once("ClasePaciente.php");
  require_once("ClaseObraSocial.php");
  require_once("ClaseTipoDocumento.php");


	class RepositorioPaciente extends PDORepository{
      private static $instance;

      public static function getInstance() {
          if (!isset(self::$instance)) {
              self::$instance = new RepositorioPaciente();
          }

          return self::$instance;
      }   


  		public function agregar($paciente){
  			$conexion = $this->getConnection();
  			$query = $conexion->prepare("INSERT INTO paciente(id, apellido, nombre, domicilio, telefono, fecha_nacimiento, genero, obra_social_id, tipo_doc_id, numero_doc) VALUES(null, :apellido, :nombre, :domicilio, :telefono, :fechaNacimiento, :genero, :idObraSocial, :idTipoDocumento, :numeroDoc)");
  			$query->bindParam(':apellido', $paciente->getApellido());
  			$query->bindParam(':nombre', $paciente->getNombre());
  			$query->bindParam(':domicilio', $paciente->getDomicilio());
  			$query->bindParam(':fechaNacimiento', $paciente->getFechaNacimiento());
  			$query->bindParam(':genero', $paciente->getGenero());
        $nulo = null;
        if($paciente->getTelefono() == ''){
          $query->bindParam(':telefono', $nulo);
        }
        else {
          $query->bindParam(':telefono', $paciente->getTelefono());
        }
        if($paciente->getIdObraSocial() == 0){
          $query->bindParam(':idObraSocial', $nulo);
        }
        else {
          $query->bindParam(':idObraSocial', $paciente->getIdObraSocial());
        }
        $query->bindParam(':idTipoDocumento', $paciente->getIdTipoDocumento());
        $query->bindParam(':numeroDoc', $paciente->getNumeroDoc());

        if($query->execute() == 1){
          $paciente->setId($conexion->lastInsertId());
          return true;
        }
        return false;
      }

      public function modificar($paciente){
        $conexion = $this->getConnection();
        if($paciente->getIdObraSocial() == 'NULL'){
          $query = $conexion->prepare("UPDATE paciente SET obra_social_id=NULL WHERE id=:id");
          $query->bindParam(':id', $paciente->getId());
          $query->execute();
        }
        $query = $conexion->prepare("UPDATE paciente SET apellido=:apellido, nombre=:nombre, domicilio=:domicilio, telefono=:telefono, fecha_nacimiento=:fechaNacimiento, genero=:genero, obra_social_id=:idObraSocial, tipo_doc_id=:idTipoDocumento, numero_doc=:numeroDoc WHERE id=:id");
        $query->bindParam(':apellido', $paciente->getApellido());
        $query->bindParam(':nombre', $paciente->getNombre());
        $query->bindParam(':domicilio', $paciente->getDomicilio());
        $nulo = null;
        if($paciente->getTelefono() == ''){
          $query->bindParam(':telefono', $nulo);
        }
        else {
          $query->bindParam(':telefono', $paciente->getTelefono());
        }
        if($paciente->getIdObraSocial() == 0){
          $query->bindParam(':idObraSocial', $nulo);
        }
        else {
          $query->bindParam(':idObraSocial', $paciente->getIdObraSocial());
        }
        $query->bindParam(':fechaNacimiento', $paciente->getFechaNacimiento());
        $query->bindParam(':genero', $paciente->getGenero());        
        $query->bindParam(':idTipoDocumento', $paciente->getIdTipoDocumento());
        $query->bindParam(':numeroDoc', $paciente->getNumeroDoc());
        $query->bindParam(':id', $paciente->getId());

        return $query->execute() == 1;
      }

      public function eliminar($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("DELETE FROM paciente WHERE id=:id");
        $query->bindParam(':id', $id);
        return $query->execute();
      }


      public function buscarPorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM paciente WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $paciente = $query->fetchAll();
        if (sizeof($paciente) > 0){
          $nuevoPaciente = new Paciente($paciente[0]['apellido'],$paciente[0]['nombre'],$paciente[0]['domicilio'], $paciente[0]['telefono'],$paciente[0]['fecha_nacimiento'],$paciente[0]['genero'], $paciente[0]['obra_social_id'], $paciente[0]['tipo_doc_id'], $paciente[0]['numero_doc']);

          $nuevoPaciente->setId($id);
          return $nuevoPaciente;
        }

        return false;
      }

      public function devolverTodos($busqueda=null,$index=-1,$cantidad=-1){
        $conexion = $this->getConnection();
        $queryString = "SELECT * FROM paciente WHERE 1";

        if($busqueda != null){
          if (isset($busqueda['nombre']) && trim($busqueda['nombre'] != '')) {
            $queryString .= " AND nombre LIKE :nombre";
          }

          if(isset($busqueda['apellido']) && trim($busqueda['apellido'] != '')){
            $queryString .= " AND apellido LIKE :apellido";
          }

          if(isset($busqueda['nroDoc']) && trim($busqueda['nroDoc'] != '')){
            $queryString .= " AND tipo_doc_id=:tipoDoc";
            $queryString .= "  AND numero_doc LIKE :nroDoc";
          }

        }

        if( $index != -1 && $cantidad!= -1){
            $queryString.=" LIMIT :limit OFFSET :offset ";
        }

        $query = $conexion->prepare($queryString);

        if($busqueda != null){
          if (isset($busqueda['nombre']) && trim($busqueda['nombre'] != '')) {
            $nombre = $busqueda['nombre'].'%';
            $query->bindParam(':nombre', $nombre);

          }

          if(isset($busqueda['apellido']) && trim($busqueda['apellido'] != '')){
            $apellido = $busqueda['apellido'].'%';
            $query->bindParam(':apellido', $apellido);
          }

          if(isset($busqueda['nroDoc']) && trim($busqueda['nroDoc'] != '')){
            $query->bindParam(':tipoDoc', $busqueda['tipoDoc']);
            $nroDoc = $busqueda['nroDoc'].'%';
            $query->bindParam(':nroDoc', $nroDoc);
          }

        }

        if( $index != -1 && $cantidad!= -1){
          $query->bindParam(':limit', $cantidad,PDO::PARAM_INT);
          $query->bindParam(':offset', $index,PDO::PARAM_INT);
        }



        $query->execute();
        $resultado = $query->fetchAll();
        $pacientes = [];
        if(sizeof($resultado) > 0){
          foreach($resultado as $paciente){
            array_push($pacientes, $this->buscarPorId($paciente['id']));
          }
          return $pacientes;
        }
        return false;
      }

      public function cantidadDePacientes(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT id FROM paciente");
        $query->execute();
        $resultado = $query->fetchAll();
        return sizeof($resultado);
      }


      public function devolverFechas($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT fecha FROM paciente WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $resultado = $query->fetchAll();
        return sizeof($resultado);
      }   	

	}