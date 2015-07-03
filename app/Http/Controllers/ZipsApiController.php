<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Services\ZipsService;

class ZipsApiController extends Controller
{

    protected $zips;
    protected $request;

    public function __construct(ZipsService $zips, Request $request){
        $this->zips = $zips;
        $this->request = $request;
    }

    public function index(){

        $returnRowCount = 'all';
        if($this->request->has('returnRowCount')){
            $returnRowCount = $this->request->get('returnRowCount');
        } 

        try{
            $result = $this->zips->getAllZipcodes($returnRowCount);
            $fields = array_keys($result['rows'][0]);
            $rows = $result['rows'];

            return view('zips.index', compact('fields', 'rows'));

        } catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function show($zip){
        try{
            $zipRecord = $this->zips->getZipRecord($zip);
            return $zipRecord;
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }
}
