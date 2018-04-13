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
Route::resource('user', 'UserController');
Route::resource('patient', 'PatientController');
Route::resource('configuration', 'ConfigurationController');
Route::resource('turn', 'TurnController');
Route::resource('user', 'UserController');
Route::resource('medicalCheckup', 'MedicalCheckupController');
Route::resource('demographicData', 'DemographicDataController');
Route::resource('rol', 'RolController');
Route::resource('permit', 'PermitController');

Route::post('/user/{id}/block',['as' => 'user.block', 'uses' => 'UserController@block']);
Route::post('/user/{id}/unblock',['as' => 'user.unblock', 'uses' => 'UserController@unblock']);

Route::get('/login',['as' => 'session.loginView', 'uses' => 'SessionController@loginView']);
Route::post('/login',['as' => 'session.login', 'uses' => 'SessionController@login']);

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api', function($url, $id=''){
	$client = new Client([
	    'base_uri' => 'https://api-referencias.proyecto2017.linti.unlp.edu.ar',
	    'timeout'  => 2.0,
	]);

	$response = $client->request('GET','/$url'.'/$id');
	
	return json_decode($resp->getBody()->getContents());
});
