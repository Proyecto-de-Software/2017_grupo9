<?php

	function datosAPI($url, $id = ''){
		$ch = curl_init();
		// Configurar URL y otras opciones apropiadas
		$parametro = "https://api-referencias.proyecto2017.linti.unlp.edu.ar/$url"."$id";
		curl_setopt($ch, CURLOPT_URL, $parametro);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		// Capturar la URL y pasarla al navegador
		$response = curl_exec($ch);

		// Cerrar el recurso cURL y liberar recursos del sistema
		curl_close($ch);

		return json_decode($response);
	}

	$r2 = datosAPI("tipo-vivienda");

		var_dump($r2[0]->nombre);


?>