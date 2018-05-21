<?php


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

Route::post('/user/{id}/block',['as' => 'user.block', 'uses' => 'UserController@block']);
Route::post('/user/{id}/unblock',['as' => 'user.unblock', 'uses' => 'UserController@unblock']);


Route::get('/', function () {
    return view('welcome');
});


