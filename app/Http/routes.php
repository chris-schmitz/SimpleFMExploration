<?php

use Soliant\SimpleFM\Adapter;

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

    $hostParameters = [
    'hostname' => "fmrpc.skeletonkey.com",
    'username' => "demo",
    'password' => "skdemo!",
    'dbname'   => "ZipCodes",
    ];

    $adapter = new Adapter($hostParameters);
    $adapter->setCallParams([
        'layoutname' => 'Zips',
        'commandstring' => '-findall'
    ]);

    $result = $adapter->execute();
    // dd($result);

    foreach($result['rows'] as $row){
        echo "<div>";
        var_dump($row);
        echo "</div>";
    }
});
