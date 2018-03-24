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
Route::resource('rol', 'RolController');
Route::resource('permission', 'PermissionController');


Route::get('/', function () {
    return view('welcome');
});
