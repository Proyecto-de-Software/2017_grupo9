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

$app->get('/prueba', function ($request, $response, $args) {
return $response->withStatus(200)->write('Prueba2');
});

$app->get('/turnos/{fecha}', function ($request, $response, $args) {
	RepositorioTurno::getInstance()->turnosReservadosParaFecha($args['fecha']);
});

// Run application
$app->run();