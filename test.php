<?php

require 'vendor/autoload.php';

// instantiate the App object
$app = new \Slim\App();
// Add route callbacks
$app->get('/', function ($request, $response, $args) {
return $response->withStatus(200)->write('Hello World!');
});

$app->get('/prueba', function ($request, $response, $args) {
return $response->withStatus(200)->write('Prueba2');
});

// Run application
$app->run();