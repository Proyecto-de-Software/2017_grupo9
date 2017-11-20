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
          $query = $conexion->prepare("SELECT * FROM turno WHERE DATE_FORMAT(fecha, '%d-%m-%Y')=:fecha");
          $query->bindParam(':fecha', $fecha);
          $query->execute();
          $resultado = $query->fetchAll();

          //if(sizeof($resultado) > 0){
          foreach($resultado as $turno){
            echo $turno['hora'];
          }
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
            #echo "El turno no esta disponible";
          } else {
            return true;
            #echo "El turno esta disponible";
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


  #RepositorioTurno::getInstance()->reservarTurno(34623543, '2017-11-15', '10:00');   #agrega el turno
  #RepositorioTurno::getInstance()->turnoDisponibleParaFechaYHora('2017-11-15', '10:00');   #el turno no esta disponible
  #RepositorioTurno::getInstance()->turnoDisponibleParaFechaYHora('2017-11-15', '12:00');    #el turno esta disponible
  #RepositorioTurno::getInstance()->turnosReservadosParaFecha('2017-11-15');    #09:30:00.00000010:00:00.000000
  RepositorioTurno::getInstance()->turnosReservadosParaFecha('15-11-2017');    #09:30:00.00000010:00:00.000000