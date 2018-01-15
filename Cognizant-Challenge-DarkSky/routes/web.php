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

Route::get('/', function () {
    return view('welcome');
});

/*
	The page for the main challenge, which changes the color theme based on the weather forcast
 */
Route::get('/home/{place}', ['as'=>'home', 'uses'=>"Controller@index"]);


/*
	The extra credit challenge, which cycles the color theme based on the weather forecast for a particular day
 */
Route::get('/time-machine/{date1?}/{date2?}', ['as'=>"timeMachine", 'uses'=>"Controller@timeMachine"]);