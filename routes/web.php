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

Route::post('/user/{user}/block',['as' => 'user.block', 'uses' => 'UserController@block']);
Route::post('/user/{user}/unblock',['as' => 'user.unblock', 'uses' => 'UserController@unblock']);

Route::get('/demographicData/create/{id}', 'DemographicDataController@create');
Route::get('/medicalCheckup/create/{id}', 'MedicalCheckupController@create');
Route::get('/medicalCheckup/patient/{id}', 'MedicalCheckupController@index');

Route::resource('user', 'UserController');
Route::resource('patient', 'PatientController');
Route::resource('configuration', 'ConfigurationController');
Route::resource('turn', 'TurnController');
Route::resource('user', 'UserController');
Route::resource('medicalCheckup', 'MedicalCheckupController');
Route::resource('demographicData', 'DemographicDataController');




Route::get('/', function () {
    return view('base');
});



Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
