<?php

	require_once("PDORepository.php");
  require_once("ClasePaciente.php");

	class RepositorioPaciente extends PDORepository{
      private static $instance;

      public static function getInstance() {
          if (!isset(self::$instance)) {
              self::$instance = new RepositorioPaciente();
          }

          return self::$instance;
      }   


  		public function agregarPaciente($paciente){
  			$conexion = $this->getConnection();

  			$query = $conexion->prepare("INSERT INTO paciente(id, apellido, nombre, domicilio, telefono, fecha_nacimiento, genero, id_datos_demograficos, id_obra_social, id_tipo_documento, numero_doc) VALUES(null, :apellido, :nombre, :domicilio, :telefono, :fechaNacimiento, :genero, :idDatosDemograficos, :idObraSocial, :idTipoDocumento, :numeroDoc)");
  			$query->bindParam(':apellido', $paciente->getApellido());
  			$query->bindParam(':nombre', $paciente->getNombre());
  			$query->bindParam(':domicilio', $paciente->getDomicilio());
  			$query->bindParam(':telefono', $paciente->getTelefono());
  			$query->bindParam(':fechaNacimiento', $paciente->getFechaNacimiento());
  			$query->bindParam(':genero', $paciente->getGenero());
        $query->bindParam(':idDatosDemograficos', $paciente->getIdDatosDemograficos());
        $query->bindParam(':idObraSocial', $paciente->getIdObraSocial());
        $query->bindParam(':idTipoDocumento', $paciente->getIdTipoDocumento());
        $query->bindParam(':numeroDoc', $paciente->getNumeroDoc());

        return $query->execute() == 1;
  		}

      public function modificarPaciente($paciente){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("UPDATE paciente SET apellido=:apellido, nombre=:nombre, domicilio=:domicilio, telefono=:telefono, fecha_nacimiento=:fechaNacimiento, genero=:genero, id_datos_demograficos=:idDatosDemograficos, id_obra_social=:idObraSocial, id_tipo_documento=:idTipoDocumento, numero_doc=:numeroDoc WHERE id=:id");
        $query->bindParam(':apellido', $paciente->getApellido());
        $query->bindParam(':nombre', $paciente->getNombreNombre());
        $query->bindParam(':domicilio', $paciente->getDomicilio());
        $query->bindParam(':telefono', $paciente->getTelefono());
        $query->bindParam(':fechaNacimiento', $paciente->getFechaNacimiento());
        $query->bindParam(':genero', $paciente->getGenero());
        $query->bindParam(':idDatosDemograficos', $paciente->getIdDatosDemograficos());
        $query->bindParam(':idObraSocial', $paciente->getIdObraSocial());
        $query->bindParam(':idTipoDocumento', $paciente->getIdTipoDocumento());
        $query->bindParam(':numeroDoc', $paciente->getNumeroDoc());

        return $query->execute() == 1;
      }

      public function eliminarPaciente($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("DELETE FROM paciente WHERE id=:id");
        $query->bindParam(':id', $id);

        return $query->execute() == 1;
      }

      public function buscarPacientePorId($id){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM paciente WHERE id=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $paciente = $query->fetchAll();
        if (sizeof($paciente) > 0){
          return new Paciente($paciente[0]['id'],$paciente[0]['apellido'],$paciente[0]['nombre'],$paciente[0]['domicilio'], $paciente[0]['telefono'],$paciente[0]['fecha_nacimiento'],$paciente[0]['genero'],$paciente[0]['id_datos_demograficos'], $paciente[0]['id_obra_social'], $paciente[0]['id_tipo_documento'], $paciente[0]['numero_doc']);
        }

        return false;
      }

      public function devolverPacientes(){
        $conexion = $this->getConnection();
        $query = $conexion->prepare("SELECT * FROM paciente");
        $query->execute();
        $resultado = $query->fetchAll();
        if(sizeof($resultado) > 0){
          return $pacientes;
        }
        return false;
      }


  		//CRUD
  		//buscar paciente por ID
      //devolverPacientes

	}