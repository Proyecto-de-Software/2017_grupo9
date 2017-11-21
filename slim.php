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
	$todosLosTurnos = array('08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30');
	$turnosReservados = RepositorioTurno::getInstance()->turnosReservadosParaFecha($args['fecha']);
    $turnosDisponibles = array_diff($todosLosTurnos, $turnosReservados);
    //return $turnosDisponibles;
    
    foreach($turnosDisponibles as $turno) {
    	echo $turno.', ';
    }
    
});

#http://localhost/slim.php/turnos/39234234/fecha/15-11-2017/hora/10:00
$app->get('/turnos/{dni}/fecha/{fecha}/hora/{hora}', function ($request, $response, $args) {
	$hora = $args['hora'];
	$hora = explode(':',$hora);

	if ($hora[1] != '00' && $hora[1] != '30') {
		echo "El turno a reservar tiene que ser: xx:00 o xx:30";
		exit;
	}

	$estaDisponible = RepositorioTurno::getInstance()->turnoDisponibleParaFechaYHora($args['fecha'], $args['hora']);
	if ($estaDisponible) {
		echo "El turno está disponible";
		RepositorioTurno::getInstance()->reservarTurno($args['dni'], $args['fecha'], $args['hora']);
	} else {
		echo "El turno NO esta disponible";
	}

});

// Run application
$app->run();