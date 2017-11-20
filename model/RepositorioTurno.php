<?php

	require_once("PDORepository.php");
	require_once("ClaseTurno.php");

	class RepositorioTurno extends PDORepository{

		    private static $instance;

      	public static function getInstance() {
          	if (!isset(self::$instance)) {
              	self::$instance = new RepositorioTurno();
          	}

          	return self::$instance;
      	}


        public function turnosReservadosParaFecha($fecha) {
          $conexion = $this->getConnection();
          $query = $conexion->prepare("SELECT * FROM turno WHERE fecha=:fecha");
          $query->bindParam(':fecha', $fecha);
          return $query->execute() == 1;
        }

        public function turnoDisponibleParaFechaYHora($fecha, $hora) {
          $conexion = $this->getConnection();
          $query = $conexion->prepare("SELECT * FROM turno WHERE fecha=:fecha AND hora=:hora");
          $query->bindParam(':fecha', $fecha);
          $query->bindParam(':hora', $hora);
          $query->execute();
          $existe_turno = $query->fetchColumn();
          if($existe_turno){
            return false;
          } else {
            return true;
          }
        }

        public function reservarTurno($dni, $fecha, $hora) {
          $conexion = $this->getConnection();
          $query = $conexion->prepare("INSERT INTO turno(dni, fecha, hora) VALUES(:dni, :fecha, :hora)");
          $query->bindParam(':dni', $dni);
          $query->bindParam(':fecha', $fecha);
          $query->bindParam(':hora', $hora);
          return $query->execute() == 1;
        }

	}


  RepositorioTurno::getInstance()->reservarTurno(34623543, '2017-11-15', '10:00');