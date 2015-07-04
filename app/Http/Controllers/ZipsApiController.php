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

    // These rules should include *at least* the validation rules you have in filemaker for the given table. If they don't, then you could
    // potentially accept form data as valid that will cause an error when trying to write to FileMaker. That said, you could include 
    // *more* validation rules than what you have in FileMaker if you want to. 
    protected $validationRules = [
        'zip'          => 'required|integer',
        'type'         => 'in:PO BOX,STANDARD,UNIQUE',
        'primary_city' => 'required',
        'state'        => 'required',
    ];

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
        if($this->request->has('json') && $this->request->get('json') == true){
            $data = compact(['fields', 'rows']);
            return compact('data');
        }
        return view('zips.index', compact('fields', 'rows'));
    }

    public function create(){
        return view('zips.create');
    }

    public function store(){
        $this->validate($this->request, $this->validationRules);

        $data    = $this->request->all();
        $zipData = $this->removeNonDataKeys($data);

        try{
            $result = $this->zips->storeZipRecord($zipData);
            $zipRecord = $result['rows'][0];

            $message['style'] = 'success';
            $message['text']  = "Your record has been created.";
            $this->request->session()->flash('message', $message);

        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        if($this->request->has('json') && $this->request->get('json') == true){
            $data = compact('zipRecord');
            return compact('data');
        }

        return view('zips.edit', compact('zipRecord'));
    }

    public function edit($zip){
        try{
            $result    = $this->zips->getZipRecord($zip);
            $zipRecord = $result['rows'][0];
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }


       if($this->request->has('json') && $this->request->get('json') == true){
            $data = compact('zipRecord');
            return compact('data');
        }
 
        return view('zips.edit', compact('zipRecord'));
    }

    public function update($zip){
        $this->validate($this->request, $this->validationRules);

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

       if($this->request->has('json') && $this->request->get('json') == true){
            $data = compact('zipRecord');
            return compact('data');
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

       if($this->request->has('json') && $this->request->get('json') == true){
            $data = ['success' => true];
            return compact('data');
        }

        return redirect()->route('api.zip.index', compact('returnRowCount'))->with(compact('message'));
    }

    protected function removeNonDataKeys($formInput){
        array_forget($formInput, '_method');
        array_forget($formInput, 'json');
        array_forget($formInput, '_token');
        return $formInput;
    }
}