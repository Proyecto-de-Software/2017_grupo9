<?php

	require_once("PDORepository.php");
    require_once($_SERVER['DOCUMENT_ROOT'].'/model/ClaseControl.php');
 


	class RepositorioHistoriaClinica extends PDORepository{
		private static $instance;

      	public static function getInstance() {
	    	if (!isset(self::$instance)) {
	    		self::$instance = new RepositorioHistoriaClinica();
	    	}

        	return self::$instance;
        }
        public  function obtenerControles($idPaciente){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare('SELECT * FROM control_salud WHERE paciente_id=:paciente_id');
        	$query->bindParam(':paciente_id', $idPaciente);
        	$query->execute();
        	$controles = [];
       		$resultado = $query->fetchAll();
       		foreach ($resultado as $control) {
       			array_push($controles, new Control($control));
       		}
       		return $controles;
        }

        public function buscarControlPorId($idControl){
        	$conexion = $this->getConnection();
        	$query = $conexion->prepare('SELECT * FROM control_salud WHERE id=:idControl');
        	$query->bindParam(':idControl', $idControl);
        	$resultado = $query->execute();
        	if($resultado){
        		$control = $query->fetchAll()[0];
        		return new Control($control);
        	}
        	else{
        		return false;
        	}
        }
        public function editarControl($control){
            $conexion = $this->getConnection();
            $query = $conexion->prepare("UPDATE control_salud SET edad=:edad, fecha=:fecha, peso=:peso, vacunas_completas=:vacunas_completas,vacunas_completas_observaciones=:vacunas_completas_observaciones, maduracion_acorde=:maduracion_acorde, maduracion_acorde_observaciones=:maduracion_acorde_observaciones, ex_fisico_normal=:ex_fisico_normal, ex_fisico_observaciones=:ex_fisico_observaciones, pc=:pc, ppc=:ppc, talla=:talla, alimentacion=:alimentacion, observaciones_generales=:observaciones_generales, paciente_id=:paciente_id, user_id=:user_id WHERE id=:id");
            var_dump($control);
            $query->bindParam(':edad',$control->getEdad());
            $query->bindParam(':fecha',$control->getFecha());
            $query->bindParam(':peso',$control->getPeso());
            $query->bindParam(':vacunas_completas',$control->getVacunasCompletas());
            $query->bindParam(':vacunas_completas_observaciones',$control->getObservacionesVacunas());
            $query->bindParam(':maduracion_acorde',$control->getMaduracionAcorde());
            $query->bindParam(':maduracion_acorde_observaciones',$control->getObservacionesMaduracion());
            $query->bindParam(':ex_fisico_normal',$control->getExamenFisicoNormal());
            $query->bindParam(':ex_fisico_normal_observaciones',$control->getObservacionesExamen());
            $query->bindParam(':pc',$control->getPc());
            $query->bindParam(':ppc',$control->getPpc());
            $query->bindParam(':talla',$control->getTalla());
            $query->bindParam(':alimentacion',$control->getDescripcionAlimentacion());
            $query->bindParam(':observaciones_generales',$control->getObservacionesGenerales());
            $query->bindParam(':paciente_id',$control->getIdPaciente());
            $query->bindParam(':user_id',$control->getIdMedico());
            $query->bindParam(':id',$control->getId());

            if($query->execute()){
                $control->setId($conexion->lastInsertId());
                return $control;
            }
            else{
                return false;
            }

        }
        public function agregarControl($control){
           
        	$conexion = $this->getConnection();
            $query = $conexion->prepare('INSERT INTO control_salud(id,edad,fecha,peso,vacunas_completas,vacunas_completas_observaciones, maduracion_acorde, maduracion_acorde_observaciones, ex_fisico_normal, ex_fisico_observaciones, pc, ppc, talla, alimentacion, observaciones_generales, paciente_id, user_id) VALUES(null,:edad,:fecha,:peso,:vacunas_completas,:vacunas_completas_observaciones, :maduracion_acorde, :maduracion_acorde_observaciones, :ex_fisico_normal, :ex_fisico_normal_observaciones, :pc, :ppc, :talla, :alimentacion, :observaciones_generales, :paciente_id, :user_id)');
            $query->bindParam(':edad',$control->getEdad());
            $query->bindParam(':fecha',$control->getFecha());
            $query->bindParam(':peso',$control->getPeso());
            $query->bindParam(':vacunas_completas',$control->getVacunasCompletas());
            $query->bindParam(':vacunas_completas_observaciones',$control->getObservacionesVacunas());
            $query->bindParam(':maduracion_acorde',$control->getMaduracionAcorde());
            $query->bindParam(':maduracion_acorde_observaciones',$control->getObservacionesMaduracion());
            $query->bindParam(':ex_fisico_normal',$control->getExamenFisicoNormal());
            $query->bindParam(':ex_fisico_normal_observaciones',$control->getObservacionesExamen());
            $query->bindParam(':pc',$control->getPc());
            $query->bindParam(':ppc',$control->getPpc());
            $query->bindParam(':talla',$control->getTalla());
            $query->bindParam(':alimentacion',$control->getDescripcionAlimentacion());
            $query->bindParam(':observaciones_generales',$control->getObservacionesGenerales());
            $query->bindParam(':paciente_id',$control->getIdPaciente());
            $query->bindParam(':user_id',$control->getIdMedico());
var_dump($control); die();
            if($query->execute()){
                $control->setId($conexion->lastInsertId());
                return $control;
            }
            else{
                return false;
            }
        }
	}

?>