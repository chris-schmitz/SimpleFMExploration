<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Soliant\SimpleFM\Adapter;

class ZipsApiController extends Controller
{
    protected $adapter; 

    public function __construct(Adapter $adapter){

        $this->adapter = $adapter;
    }

    public function index(){

        $hostParameters = [
            'hostname' => "fmrpc.skeletonkey.com",
            'username' => "demo",
            'password' => "skdemo!",
            'dbname'   => "ZipCodes",
        ];

        $this->adapter->setHostParams($hostParameters);

        $this->adapter->setCallParams([
            'layoutname'    => 'Zips',
            'commandstring' => '-findall'
        ]);

        $result = $this->adapter->execute();
        dd($result['rows']);

        $firstRecord = $result['rows'][0];
        foreach($result['rows'] as $record){

            foreach($fields as $field){
                 // $row[$field] = $record[]
            }
            $tableContent[] = $row;
        } 
    }
}
