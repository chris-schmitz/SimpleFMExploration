<?php

namespace App\Services;

use Soliant\SimpleFM\Adapter;


class ZipsService {

    protected $adapter;

    // Note: You don't necessarily *need* to exclude these columns, I'm just pulling them out to simplify the demo's display
    protected $columnsToExclude = [
        'index',
        'modid',
    ];

    public function __construct(Adapter $adapter){
        $hostParameters = config('database.connections.filemaker');
        $this->adapter  = $adapter;
        $this->adapter->setHostParams($hostParameters);
        // setting the default layout, note if you want to interact with a different layout you can override it in the method
        $this->adapter->setLayoutName('Zips');
    }

    public function getAllZipcodes($returnRowCount){

        // This is one way of passing in a command to fire. 
        // Something important to point out: when you set the CallParams, you specify the layout name
        // as part of the array you're passing in, but if you set the commandstring or commandarray
        // separately, you *must* set the layout name as a separate method call (see the `getZipRecord()`
        // method below). If the layoutname property on the adapter is not set you will get an error 
        // stating that the layout is not set *even if it's set with the `-lay` flag in your command*.
        try{
            $this->adapter->setCallParams([
                'layoutname'    => 'Zips',
                'commandstring' => "-findall&-max=$returnRowCount"
            ]);

            $result = $this->adapter->execute();

            $this->checkResultForError($result);
            $this->columnsToExclude[] = 'recid';
            $this->forgetUnnededColumns($result['rows']);
        } catch (\Exception $exception){
            dd($exception->getMessage());
        }

        return $result;
    }

    public function getZipRecord($zip){

        $string = $this->adapter->setCommandarray([
            '-db'   => 'ZipCodes',
            '-lay'  => 'Zips',
            'zip'   => $zip,
            '-find' => null
        ]);

        $result = $this->adapter->execute();
        $this->checkResultForError($result);

        return $result;
    }

    public function storeZipRecord($zipData){
        $zipData['-db']  = 'ZipCodes';
        $zipData['-lay'] = 'Zips';
        $zipData['-new'] = null;

        $this->adapter->setCommandarray($zipData);
        $result = $this->adapter->execute();
        $this->checkResultForError($result);

        return $result;
    }

    public function updateZipRecord($recid, $newZipData){
        $newZipData['-db']    = 'ZipCodes';
        $newZipData['-lay']   = 'Zips';
        $newZipData['-recid'] = $recid;
        $newZipData['-edit']  = null;

        $this->adapter->setCommandarray($newZipData);
        $result = $this->adapter->execute();
        $this->checkResultForError($result);

        return $result;
    }

    public function destroyZipRecord($recid){
        $this->adapter->setCommandarray([
            '-db'     => 'ZipCodes',
            '-lay'    => 'Zips',
            '-recid'  => $recid,
            '-delete' => null
        ]);
        $result = $this->adapter->execute();
        $this->checkResultForError($result);
    }

    protected function checkResultForError($result){
        if(empty($result)){
            throw new \Exception('Zip Service Error.');
        }

        if($result['error'] !== 0){
            throw new \Exception('An error was thrown: ' . $result['errortext']);
        }
    }

    /*
    | Note: When it comes to the user added fields in FileMaker, it's better to exclude them from 
    | the returned data by removing them from the specific layout you're accessing, in this case
    | the Zips layout. I'm using this to remove some of the meta data columns that I don't need
    | for this particular demo.
    */
    protected function forgetUnnededColumns(&$returnedResult){

        foreach($returnedResult as $index => $values){
            foreach($this->columnsToExclude as $column){
                array_forget($returnedResult[$index], $column);
            }
        }
    }
}