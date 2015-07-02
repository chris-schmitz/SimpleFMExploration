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

        $hostParameters = [
            'hostname' => "fmrpc.skeletonkey.com",
            'username' => "demo",
            'password' => "skdemo!",
            'dbname'   => "ZipCodes",
        ];
        $this->adapter = $adapter;
        $this->adapter->setHostParams($hostParameters);
    }

    public function index(){


        $this->adapter->setCallParams([
            'layoutname'    => 'Zips',
            'commandstring' => '-findall'
        ]);

        $result = $this->adapter->execute();

        $fields = array_keys($result['rows'][0]);
        $rows = $result['rows'];


        return view('zips.index', compact('fields', 'rows'));
    }
}
