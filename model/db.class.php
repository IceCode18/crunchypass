<?php
use Aws\DynamoDb\DynamoDbClient;
use Aws\DynamoDb\Exception\DynamoDbException;

class DB{

    private $region;
    private $version;
    
    public function __construct($region='us-east-1', $version='2012-08-10'){
        $this->region = $region;
        $this->version = $version;
    }

    public function connect(){
        try{
            $client = new DynamoDbClient([
                'region' => $this->region,
                'version' => $this->version
            ]);
            return $client;
        }catch (DynamoDbException $e){
            echo "Error! Could not connect to database ".$e->getMessage(); 
            return false;
        }
    }
}