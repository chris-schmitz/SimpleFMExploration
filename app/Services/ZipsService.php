<?php

namespace App\Services;

use Soliant\SimpleFM\Adapter;


class ZipsService {

    protected $adapter;

    public function __construct(Adapter $adapter){
        $hostParameters = config('database.connections.filemaker');
        $this->adapter = $adapter;
        $this->adapter->setHostParams($hostParameters);
        // setting the default layout, note if you want to interact with 
        // a different layout you can override it in the method
        $this->adapter->setLayoutName('Zips');
    }

    public function getAllZipcodes($returnRowCount){

        // This is one way of passing in a command to fire. 
        // Something important to point out: when you set the CallParams, you specify the layout name
        // as part of the array you're passing in, but if you set the commandstring or commandarray
        // separately, you *must* set the layout name as a separate method call (see the `getZipRecord()`
        // method below). If the layoutname property on the adapter is not set you will get an error 
        // stating that the layout is not set *even if it's set with the `-lay` flag in your command*.
        $this->adapter->setCallParams([
            'layoutname'    => 'Zips',
            'commandstring' => "-findall&-max=$returnRowCount"
        ]);

        $result = $this->adapter->execute();

        $this->checkResultForError($result);

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

    public function updateZipRecord($recid, $newZipData){
        $newZipData['-db'] = 'ZipCodes';
        $newZipData['-lay'] = 'Zips';
        $newZipData['-recid'] = $recid;
        $newZipData['-edit'] = null;

        $this->adapter->setCommandarray($newZipData);
        $result = $this->adapter->execute();
        $this->checkResultForError($result);
        
        return $result;
    }

    protected function checkResultForError($result){
        if(empty($result)){
            throw new \Exception('Zip Service Error.');
        }

        if($result['error'] !== 0){
            throw new \Exception('An error was thrown: ' . $result['errortext']);
        }
    }
}