<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('verify', 'AuthController@verifyUser');
    Route::post('reset', 'AuthController@resetPassword');
    
  
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function () {

Route::resource('/hipodromos', 'HipodromoController');
Route::post('/hipodromos/upload', 'HipodromoController@upload');
//Route::get('/reporte-pdf/{id}', 'JornadaController@generatePDF');

Route::resource('/tab-ponles', 'TabPonleController');

Route::resource('/users', 'UserController');
Route::get('/users-search', 'UserController@search');
Route::get('/users-saldos', 'UserController@available');
Route::get('/users-puntos', 'UserController@availablepuntos');

Route::get('/user-detail', 'UserController@detail');
Route::resource('/roles', 'RoleController');
Route::resource('/jornadas', 'JornadaController');
Route::post('/jornadas/upload', 'JornadaController@upload');

Route::post('/jornadas-notifications', 'JornadaController@jornadasNotifications');


Route::resource('/carreras', 'CarreraController');
Route::resource('/subasta', 'SubastaController');

Route::post('/subasta-live', 'SubastaController@subastaMovil');

//typejugadas
Route::resource('/jugadas-type', 'TypeJugadasController');

//PollaController
Route::resource('/pollas', 'PollaController');
Route::post('/pollas-premio', 'PollaController@pollasPremio');



Route::resource('/suggestions', 'SuggestionsController');

Route::resource('/poso', 'PosoController');

Route::post('/poso/upload', 'PosoController@upload');

Route::get('/poso-datos-retiro/{id}', 'SettingController@datosRetiro');

Route::resource('/currency', 'CurrencyController');
Route::resource('/payment-methods', 'PaymentMethodsController');
Route::post('/payment-methods/upload', 'PaymentMethodsController@upload');

Route::resource('/dashboard', 'DashboardController');


Route::resource('/setting-bank', 'SettingController');


Route::get('/bank-ve', 'RetiroController@index');

//generatePDF


});



Route::get('/reporte-pdf/{id}', 'DashboardController@generatePDF');
Route::get('/reporte-all-jornada-pdf', 'DashboardController@generateReporte');

Route::get('/reporte-pdf-polla/{id}', 'DashboardController@generatePDFPolla');