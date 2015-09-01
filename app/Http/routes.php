<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['auth']],function() {

Route::get('/home', 'HomeController@index');
Route::get('/houselights/toggle/{houselight}','HouseLightController@toggle');
Route::get('/houselights/colorchange/{houselight}/{x}/{y}','HouseLightController@colorchange_xy');

Route::resource('lightsettings','LightSettingController');


Route::get('/', function () {
    return view('welcome');
});

});
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);