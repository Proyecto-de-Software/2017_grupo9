<?php

require 'vendor/autoload.php';

require_once 'model/RepositorioTurno.php';
require_once 'model/ClaseTurno.php';



// instantiate the App object
$app = new \Slim\App();
// Add route callbacks
$app->get('/', function ($request, $response, $args) {
return $response->withStatus(200)->write('Hello World!');
});

#http://localhost/slim.php/turnos/15-11-2017
$app->get('/turnos/{fecha}', function ($request, $response, $args) {
	$fecha = $args['fecha'];
	$fecha = explode('-',$fecha);
	if(preg_match('/^([0-2][0-9]|3[0-1])-(0[1-9]|1[012])-[0-9]{4}$/', $args['fecha']) && checkdate($fecha[1], $fecha[0], $fecha[2])) {
	//if(preg_match('/^(?:(?:31-(?:0?[13578]|1[02]))\1|(?:(?:29|30)-(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29-0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])-(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$/', $args['fecha'])) {
		$todosLosTurnos = array('08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30');
		$turnosReservados = RepositorioTurno::getInstance()->turnosReservadosParaFecha($args['fecha']);
	    $turnosDisponibles = array_diff_assoc($todosLosTurnos, $turnosReservados);
	    $res = json_encode(array("code" => 200, "turnos" => $turnosDisponibles), JSON_UNESCAPED_UNICODE);
	    return $response->withStatus(200)->write($res);
	} else {
		$res = json_encode(array("code" => 400, "mensaje" => "La fecha ingresada no es válida"), JSON_UNESCAPED_UNICODE);
		return $response->withStatus(400)->write($res);
	}
});

#http://localhost/slim.php/turnos/39234234/fecha/15-11-2017/hora/10:00
$app->get('/turnos/{dni}/fecha/{fecha}/hora/{hora}', function ($request, $response, $args) {
	if (!preg_match('/^\d{1,8}$/', $args['dni'])) {
		echo "El dni ingresado es inválido";
	}

	$hora = $args['hora'];
	$hora = explode(':',$hora);

	if ($hora[1] != '00' && $hora[1] != '30') {
		echo "La hora del turno a reservar debe ser: xx:00 o xx:30";
		exit;
	}

	$estaDisponible = RepositorioTurno::getInstance()->turnoDisponibleParaFechaYHora($args['fecha'], $args['hora']);
	if ($estaDisponible) {
		echo "El turno está disponible. Reservación exitosa.";
		RepositorioTurno::getInstance()->reservarTurno($args['dni'], $args['fecha'], $args['hora']);
	} else {
		echo "Lo sentimos, el turno ya está reservado";
	}

});

// Run application
$app->run();