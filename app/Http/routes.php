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

Route::get('/', function () {
    return redirect('api/zips/?returnRowCount=50');
});

// I broke this out because I wanted to build up the API piece by piece, but it could all be constructed using one line:
// Route::resource('api/zips', 'ZipApiController');
Route::get('api/zips', ['as' => 'api.zip.index', 'uses' => 'ZipsApiController@index']);
Route::get('api/zips/create', ['as' => 'api.zip.create', 'uses' => 'ZipsApiController@create']);
Route::post('api/zips', ['as' => 'api.zip.store', 'uses' => 'ZipsApiController@store']);
Route::get('api/zips/{zip}', ['as' => 'api.zip.edit', 'uses' => 'ZipsApiController@edit']);
Route::put('api/zips/{zip}', ['as' => 'api.zip.update', 'uses' => 'ZipsApiController@update']);
Route::delete('api/zips/{zip}', ['as' => 'api.zip.delete', 'uses' => 'ZipsApiController@delete']);

