<?php

$returnArray = true;
$rawData = file_get_contents('php://input');
$response = json_decode($rawData, $returnArray);
$id_del_chat = $response['message']['chat']['id'];

// Obtener comando (y sus posibles parametros)
$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';

$tmp = preg_match($regExp, $response['message']['text'], $aResults);

if (isset($aResults[1])) {
	$cmd = trim($aResults[1]);
	$cmd_params = trim($aResults[2]);
} else {
	$cmd = trim($response['message']['text']);
	$cmd_params = '';
}