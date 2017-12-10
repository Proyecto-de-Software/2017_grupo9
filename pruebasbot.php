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

//Armando la respuesta

$msg = array();
$msg['chat_id'] = $response['message']['chat']['id'];
$msg['text'] = null;
$msg['disable_web_page_preview'] = true;
$msg['reply_to_message_id'] = $response['message']['message_id'];
$msg['reply_markup'] = null;


//Necesario para mostrar el cuerpo de la respuesta al hacer file_get_content() cuando el status es distinto de 200
$context0 = stream_context_create(array('http' => array('ignore_errors' => true),));


switch ($cmd) {
case '/start':
	$msg['text'] = 'Hola ' . $response['message']['from']['first_name'] .
	" Usuario: " . $response['message']['from']['username'] . '!' . PHP_EOL;
	$msg['text'] .= '¿Como puedo ayudarte? /help';
	$msg['reply_to_message_id'] = null;
	break;
case '/help':
	$msg['text'] = 'Los comandos disponibles son estos:' . PHP_EOL;
	$msg['text'] .= '/start Inicializa el bot' . PHP_EOL;
	$msg['text'] .= '/turnos dd-mm-aaaa Muestra los turnos disponibles del día' . PHP_EOL;
	$msg['text'] .= '/reservar dni dd-mm-aaaa hh:mm Realiza la reserva del turno' . PHP_EOL;
	$msg['text'] .= '/help Muestra los comandos disponibles';
	$msg['reply_to_message_id'] = null;
	break;
case '/reservar':
	//$msg['text'] = 'Te confirmamos el turno para:' . PHP_EOL;
	//$msg['text'] .= '10:30'; #. PHP_EOL;
	//$msg['text'] .= 'Parametros: '.$cmd_params;
	$params = explode(' ', $cmd_params);

	if(strlen($params) == 3) {
		//$msg['text'] .= file_get_contents('https://grupo9.proyecto2017.linti.unlp.edu.ar/slim.php/turnos/'.$params[0].'/fecha/'.$params[1].'/hora/'.$params[2], false, $context0);
		$raw = file_get_contents('https://grupo9.proyecto2017.linti.unlp.edu.ar/slim.php/turnos/'.$params[0].'/fecha/'.$params[1].'/hora/'.$params[2], false, $context0);
		$res = json_decode($raw, true);

		$msg['text'] = $res['mensaje'];

		$msg['reply_to_message_id'] = null;
	} else {
		$msg['text'] = 'Cantidad incorrecta de parámetros.'. PHP_EOL;
		$msg['text'] .= '/reservar dni dd-mm-aaaa hh:mm Realiza la reserva del turno';
	}
	break;
case '/turnos':
	$params = explode(' ', $cmd_params);

	if(strlen($params) == 1) {

		$raw = file_get_contents('https://grupo9.proyecto2017.linti.unlp.edu.ar/slim.php/turnos/'.$cmd_params, false, $context0);
		$res = json_decode($raw, true);

		if($res['code'] == 200) {
			$msg['text'] = 'Los turnos disponibles son: ';
			foreach($res['turnos'] as $turno) {
				$msg['text'] .= $turno.' ';
			}
		} else {
			$msg['text'] = $res['mensaje'];
		}
	} else {
		$msg['text'] = 'Cantidad incorrecta de parámetros.'. PHP_EOL;
		$msg['text'] .= '/turnos dd-mm-aaaa Muestra los turnos disponibles del día';		
	}
	break;
default:
	$msg['text'] = 'Lo siento, no es un comando válido.' . PHP_EOL;
	$msg['text'] .= 'Prueba /help para ver la lista de comandos disponibles';
	break;
}



//Enviando la respuesta

$url = 'https://api.telegram.org/bot506822439:AAGJDup7thzjHgF5yrO46TxBWrPXqJ2h8Xk/sendmessage';


$options = array(
	'http' => array(
	'header' => "Content-type: application/x-www-form-urlencoded\r\n",
	'method' => 'POST',
	'content' => http_build_query($msg)
	)
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);


exit(0);