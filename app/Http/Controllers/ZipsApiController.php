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
            $rows   = $result['rows'];
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        return view('zips.index', compact('fields', 'rows'));
    }

    public function edit($zip){
        try{
            $result    = $this->zips->getZipRecord($zip);
            $zipRecord = $result['rows'][0];
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        return view('zips.edit', compact('zipRecord'));
    }

    public function update($zip){
        $data    = $this->request->all();
        $zipData = $this->removeNonDataKeys($data);

        $recid = $zipData['recid'];
        array_forget($zipData, 'recid');

        try{
            $result           = $this->zips->updateZipRecord($recid, $zipData);
            $zipRecord        = $result['rows'][0];

            $message['style'] = 'success';
            $message['text']  = 'You changes have been saved.';

            $this->request->session()->flash('message', $message);

        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        return view('zips.edit', compact('zipRecord'));
    }

    public function delete($zip){
        $recid = $this->request->get('recid');

        try{
            $this->zips->destroyZipRecord($recid);

            $message['style'] = 'success';
            $message['text']  = "The record has been deleted.";
            $returnRowCount   = 50;

        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        return redirect()->route('api.zip.index', compact('returnRowCount'))->with(compact('message'));
    }

    protected function removeNonDataKeys($formInput){
        array_forget($formInput, '_method');
        array_forget($formInput, '_token');
        return $formInput;
    }
}
