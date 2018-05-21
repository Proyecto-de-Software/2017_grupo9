<?php

use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/user/{id}/block',['as' => 'user.block', 'uses' => 'UserController@block']);
Route::post('/user/{id}/unblock',['as' => 'user.unblock', 'uses' => 'UserController@unblock']);

Route::resource('user', 'UserController');
Route::resource('patient', 'PatientController');
Route::resource('configuration', 'ConfigurationController');
Route::resource('turn', 'TurnController');
Route::resource('user', 'UserController');
Route::resource('medicalCheckup', 'MedicalCheckupController');
Route::resource('demographicData', 'DemographicDataController');

Route::post('/user/{id}/block',['as' => 'user.block', 'uses' => 'UserController@block']);
Route::post('/user/{id}/unblock',['as' => 'user.unblock', 'uses' => 'UserController@unblock']);


Route::get('/', function () {
    return view('base');
});

Route::get('/api', function($url, $id=''){
	$client = new Client([
	    'base_uri' => 'https://api-referencias.proyecto2017.linti.unlp.edu.ar',
	    'timeout'  => 2.0,
	]);

	$response = $client->request('GET','/$url'.'/$id');
	
	return json_decode($resp->getBody()->getContents());
});

