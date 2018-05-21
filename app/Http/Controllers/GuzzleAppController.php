<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class GuzzleAppController extends Controller
{
    public static function get($url='', $id=''){
		$client = new Client([
		    'base_uri' => 'https://api-referencias.proyecto2017.linti.unlp.edu.ar',
		]);

		$response = $client->request('GET','/'.$url.$id);
		
		return json_decode($response->getBody()->getContents());
	}

}
