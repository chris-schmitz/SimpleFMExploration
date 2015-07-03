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

Route::get('api/zips/', ['as' => 'api.zip.index', 'uses' => 'ZipsApiController@index']);
Route::get('api/zips/{zip}', ['as' => 'api.zip.index', 'uses' => 'ZipsApiController@show']);
// Route::resource('test', 'ZipsApiController');

Route::get('/', function () {
    return redirect('api/zips/?returnRowCount=50');
});

Route::get('test', function (){
    return config('database.connections.filemaker');
});