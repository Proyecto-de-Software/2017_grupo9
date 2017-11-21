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


$app->get('/turnos/{fecha}', function ($request, $response, $args) {
	RepositorioTurno::getInstance()->turnosReservadosParaFecha($args['fecha']);
	$turnos = array('8:00', '8:30', '9:00', '9:30', '10:00', '10:30', '11:00', '11:30', '12:00', '12:30', '13:00', '13:30', '14:00', '14:30', '15:00', '15:30', '16:00', '16:30', '17:00', '17:30', '18:00', '18:30', '19:00', '19:30');
    foreach($turnos as $turno) {
    	echo $turno.'<br>';
    }
});

// Run application
$app->run();