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
}