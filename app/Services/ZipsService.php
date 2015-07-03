<?php

namespace App\Services;

use Soliant\SimpleFM\Adapter;


class ZipsService {

    protected $adapter;

    public function __construct(Adapter $adapter){
        $hostParameters = config('database.connections.filemaker');
        $this->adapter = $adapter;
        $this->adapter->setHostParams($hostParameters);
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

        if($result['error'] !== 0){
            throw new \Exception('An error was thrown: ' . $result['errortext']);
        }
        return $result;
    }

    public function getZipRecord($zip){
        $this->adapter->setLayoutname('Zips');

        $string = $this->adapter->setCommandarray([
            '-db'   => 'ZipCodes',
            '-lay'  => 'Zips',
            'zip'   => $zip,
            '-find' => null
        ]);

        $result = $this->adapter->execute();
        dd($result);
    }
}