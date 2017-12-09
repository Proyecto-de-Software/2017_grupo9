<?php

$rawData = file_get_contents("https://api-referencias.proyecto2017.linti.unlp.edu.ar/tipo-vivienda");
$response = json_decode($rawData, true);
echo $response['id']['nombre'];

?>